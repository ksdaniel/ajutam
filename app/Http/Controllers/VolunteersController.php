<?php

namespace App\Http\Controllers;

use App\Http\Resources\VolunteerCollection;
use App\Laravue\Models\Role;
use App\Laravue\Models\User;
use App\Solicitation;

use App\Volunteer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class VolunteersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return VolunteerCollection
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $userQuery = Volunteer::query();
        $limit = Arr::get($searchParams, 'limit', 15);

        $keyword = Arr::get($searchParams, 'keyword', '');
        $involvement_direction = Arr::get($searchParams, 'involvement_direction', '');
        $type = Arr::get($searchParams, 'type', '');
        $has_car = Arr::get($searchParams, 'has_car', '');
        $county = Arr::get($searchParams, 'county', '');

        if (!empty($keyword)) {
            $userQuery->where(function ($query) use ($keyword) {
                $query->orWhere('name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('email', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('phone', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('address', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('car_plates', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('neighborhood', 'LIKE', '%' . $keyword . '%');
            });
        }

        $userQuery->with("user.roles");

        if (!empty($type) && $type != 'admin') {
            $userQuery->where('type', '=', $type);
        } elseif (!empty($type) && $type = 'admin') {

            $userQuery->whereHas("user.roles", function ($q) {
                $q->where("name", "admin");
            });
        }

        if (!empty($has_car)) {
            $userQuery->where('has_car', '=', $has_car);
        }

        if (!empty($involvement_direction)) {
            $userQuery->where('involvement_direction', '=', $involvement_direction);
        }

        if (!empty($county)) {
            $userQuery->where('county', '=', $county);
        }

        return new VolunteerCollection($userQuery->paginate($limit));
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
        $data["user_id"] = $user->id;

        if (isset($data["acord_semnat"]) && $data["acord_semnat"]) {

            $data["ip_acord"] = $request->ip();
            $data["data_acord"] = Carbon::now()->toDateTimeString();
        }

        $volunteer = Volunteer::updateOrCreate(["user_id" => $user->id], $data);


        return response()->json(["success" => $volunteer]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        return response()->json(["volunteer" => Volunteer::where("user_id", $user->id)->first()]);
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
        $volunteer = Volunteer::find($id);

        $data = $request->toArray();

        if (isset($data["acord_semnat"]) && $data["acord_semnat"]) {

            $data["ip_acord"] = $request->ip();
            $data["data_acord"] = Carbon::now()->toDateTimeString();
        }

//        if (isset($data["type"])) {
//            $volunteerUser = User::find($data["user_id"]);
//
//            if ($data["type"] == "dispecer") {
//
//
//                $userRole = Role::findByName("dispecer");
//                $volunteerUser->syncRoles($userRole);
//
//            } elseif ($data["type"] == "coordonator") {
//
//                $volunteerUser = User::find($data["user_id"]);
//                $userRole = Role::findByName("coordonator");
//                $volunteerUser->syncRoles($userRole);
//
//            } else {
//
//                if (!$volunteerUser->isAdmin()) {
//
//                    $userRole = Role::findByName(\App\Laravue\Acl::ROLE_USER);
//                    $volunteerUser->syncRoles($userRole);
//
//                }
//
//            }
//        }


        $volunteer->update($data);
        return response()->json(["volunteer" => $volunteer]);

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
     * Return a listing of the resource Volunteer.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {

        $query = $request->get('name');
        $type = $request->get('type');

        $volunters = Volunteer::where("name", "like", "%$query%")->when(isset($request->type) && !empty($request->type), function ($q) use ($type) {

            if($type=="medicamente"){
                $q->where("involvement_direction", "Medicamente");

            }
            elseif ($type=="alimente"){

                $q->where("involvement_direction", "Alimente");
            }

            elseif ($type=="altele"){

//                $q->where("involvement_direction", "Alimente");
            }

            else{

                $q->where("type", $type);

            }



        })->get();

        return response()->json(["volunteers" => $volunters]);
    }

    public function volunteerMap()
    {

        return response()->json(["volunteers" => Volunteer::whereNotNull("geojson")->select("name", "phone", "geojson")->get()]);
    }
}
