<?php

namespace App\Http\Controllers;

use App\Volunteer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VolunteersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(["volunteers"=>Volunteer::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=$request->user();
        $data=$request->toArray();
        $data["user_id"]=$user->id;

        if(isset($data["acord_semnat"]) && $data["acord_semnat"]){

            $data["ip_acord"]=$request->ip();
            $data["data_acord"]=Carbon::now()->toDateTimeString();
        }

        $volunteer=Volunteer::updateOrCreate(["user_id"=>$user->id],$data);



        return response()->json(["success"=>$volunteer]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $user=$request->user();
        return response()->json(["volunteer"=>Volunteer::where("user_id",$user->id)->first()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $volunteer=Volunteer::find($id);

        $data=$request->toArray();

        if(isset($data["acord_semnat"]) && $data["acord_semnat"]){

            $data["ip_acord"]=$request->ip();
            $data["data_acord"]=Carbon::now()->toDateTimeString();
        }
        $volunteer->update($data);
        return response()->json(["volunteer"=>$volunteer]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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
