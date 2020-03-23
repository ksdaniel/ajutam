<?php

namespace App\Http\Controllers;

use App\Http\Resources\VolunteerCollection;
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
        $county = Arr::get($searchParams, 'county', '');

        if (!empty($keyword)) {
            $userQuery->where(function ($query) use ($keyword) {
                $query->orWhere('name', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('email', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('phone', 'LIKE', '%' . $keyword . '%');
                $query->orWhere('address', 'LIKE', '%' . $keyword . '%');
            });
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



        return response()->json(["success"=>$volunteer]);

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

        $volunteer->update($data);
        return response()->json(["volunteer"=>$volunteer]);

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


    public function search(Request $request){

        $query=$request->name;

        $volunters=Volunteer::where("name","like","%$query%")->get();

        return response()->json(["volunteers"=>$volunters]);
    }
}
