<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\Exports\SolicitationExport;
use App\Http\Resources\SolicitationCollection;
use App\Solicitation;
use App\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class SolicitationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return SolicitationCollection
     */
    public function index(Request $request)
    {
        $authUser = Auth::user();

        $searchParams = $request->all();
        $userQuery = Solicitation::query();

        $limit = Arr::get($searchParams, 'limit', 15);
        $categories = Arr::get($searchParams, 'categories', '');
        $payment_status= Arr::get($searchParams, 'payment_status', '');
        $volunteer_id= Arr::get($searchParams, 'volunteer_id', '');
        $status = Arr::get($searchParams, 'status', '');

        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($categories)) {
            $userQuery->where("categories", $categories);
        }

        if (!empty($status) && $authUser->hasRole('admin')) {
            $userQuery->where("status", $status);
        }


        if (!empty($payment_status)) {
            $userQuery->where("payment_status", $payment_status);
        }

        if (!empty($volunteer_id)) {
            $userQuery->where("volunteer_id", $volunteer_id);
        }


        $userQuery->with("beneficiary");
        $userQuery->with("volunteer");
        $userQuery->with("creator");
        $userQuery->with("coordinator");

        if (!empty($keyword)) {
            $userQuery->leftJoin('beneficiaries', 'solicitations.beneficiary_id', '=', 'beneficiaries.id');

            $userQuery->where(function ($q) use ($keyword){
                $names = explode(" ", $keyword);

                $q->where(function ($sq) use ($names){
                    $sq->whereIn('beneficiaries.first_name', $names);
                    $sq->orWhere(function($query) use ($names) {
                       $query->whereIn('beneficiaries.last_name', $names);
                     });
                });

                $q->orWhere('beneficiaries.phone', 'LIKE', '%' . $keyword . '%');
                $q->orWhere('beneficiaries.address', 'LIKE', '%' . $keyword . '%');
                $q->orWhere('beneficiaries.neighborhood', 'LIKE', '%' . $keyword . '%');
                $q->orWhere('beneficiaries.city', 'LIKE', '%' . $keyword . '%');
                $q->orWhere('solicitations.code', '=',  $keyword );

            });

        }

        $userQuery->orderBy("solicitations.created_at","DESC");

        return new SolicitationCollection($userQuery->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->toArray();

        $beneficiary = Beneficiary::where('phone', $data["beneficiar"]["phone"])->first();

        if (!$beneficiary) {
            $newBeneficiary = $data["beneficiar"];
            $beneficiary = Beneficiary::create($newBeneficiary);
        }

        $data["solicitation"]['beneficiary_id'] = $beneficiary->id;
        $data["solicitation"]["created_by"]=$user->id;


        do {

            $newHash = rand ( 10000 , 99999 );

        } while (Solicitation::where('code', '=', $newHash)->count() > 0);
        $data["solicitation"]["code"]=$newHash;

        Solicitation::create($data["solicitation"]);

        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $solicitation=Solicitation::where("id",$id)->with(["beneficiary","volunteer","coordinator"])->first();

        return response()->json(["solicitation"=>$solicitation]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->toArray();

        $solicitation = Solicitation::find($id);

        $beneficiary = Beneficiary::where('id', $data['solicitation']["beneficiary_id"])->first();

        $volunteer = Volunteer::where('id', $data['solicitation']["volunteer_id"])->first();

        $coordonator = Volunteer::where('id', $data['solicitation']["coordonator_id"])->first();


        if($beneficiary){


            $beneficiary->update($data['beneficiar']);
        }

        if(!$solicitation->volunteer_id && $volunteer && $solicitation->volunteer_confirmation && $solicitation->volunteer_id !== (int)$data['solicitation']['volunteer_id'] ){

            Mail::send('emails.volunteerNotification', [
                "volunteer_name"=>$volunteer->name,
                "code"=>$solicitation->code,
                "beneficiary"=>$beneficiary,
                "delivery_observation"=>$solicitation->delivery_observation,
                "delivery_period"=>$solicitation->delivery_period,
                "package_weight"=>"",
                "nr_coordonator"=>$solicitation->coordinator->phone,
                "nr_call_center"=>"0364406517"

            ], function ($message) use ($volunteer) {
                $message->from( "ajutam@civicsuport.ro",'Va ajutam de la Cluj!');
                $message->subject("Va ajutam din Cluj - Task de livrare nou!");
                $message->to($volunteer->email);
            });
        }

        if(!$solicitation->coordonator_id && $coordonator && $solicitation->coordonator_id !== (int)$data['solicitation']['coordonator_id'] ){

            Mail::send('emails.coordonatorNotification', [
                "solicitation"=>$solicitation,
                "volunteer_name"=>$volunteer ? $volunteer->name : '-',
                "code"=>$solicitation->code,
                "beneficiary"=>$beneficiary,
                "delivery_observation"=>$solicitation->delivery_observation,
                "delivery_period"=>$solicitation->delivery_period,
                "package_weight"=>"",
                "volunteer"=>$volunteer,
                "nr_coordonator"=>$coordonator ? $coordonator->phone: "",
                "coordonator"=>$coordonator,
                "nr_call_center"=>"0364406517"

            ], function ($message) use ($coordonator) {
                $message->from( "ajutam@civicsuport.ro",'Va ajutam de la Cluj!');
                $message->subject("Va ajutam din Cluj - Task de coordonat nou!");
                $message->to($coordonator->email);
            });
        }

        $solicitation->update($data['solicitation']);

        return response()->json(["success" => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get Beneficiary By Phone.
     *
     * @param $phone
     * @return \Illuminate\Support\Collection
     */
    public function filterBeneficiaryByPhone($phone)
    {
        return Beneficiary::where('phone', 'LIKE', '%' . $phone . '%')->get();
    }

    public function search(Request $request){
        $phone=$request->phone;
        $beneficiari=[];
        if($phone){

            $beneficiari=Beneficiary::where("phone","like","%$phone")->with("solicitation")->get();


        }


        return response()->json($beneficiari);
    }

    public function export(Request $request){

        $params=$request->toArray();

        $params["type"]=isset($request->type) ? $request->type : "alimente";

        return Excel::download(new SolicitationExport($params), 'solicitari-'.$params["type"].date("Y-m-d").'.xlsx');


    }
}
