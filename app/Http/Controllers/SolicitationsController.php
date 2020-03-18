<?php

namespace App\Http\Controllers;

use App\Http\Resources\SolicitationCollection;
use App\Solicitation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SolicitationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authUser=Auth::user();

        $searchParams = $request->all();
        $userQuery = Solicitation::query();
        $limit = Arr::get($searchParams, 'limit', 15);
        $categories= Arr::get($searchParams, 'categories', '');
        $status = Arr::get($searchParams, 'status', '');

        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($categories)) {
            $userQuery->where("categories",$categories);
        }

        if (!empty($status) && $authUser->hasRole('admin')) {
            $userQuery->where("status",$status);
        }

           $userQuery->with("volunteer");

        if (!empty($keyword)) {

            $userQuery->where('name', 'LIKE', '%' . $keyword . '%');
            $userQuery->where('last_name', 'LIKE', '%' . $keyword . '%');
            $userQuery->where('phone', 'LIKE', '%' . $keyword . '%');
            $userQuery->where('address', 'LIKE', '%' . $keyword . '%');
            $userQuery->where('neighborhood', 'LIKE', '%' . $keyword . '%');
            $userQuery->where('city', 'LIKE', '%' . $keyword . '%');
        }

        if(!$authUser->hasRole('admin')){

            $userQuery->where(function($q) use ($authUser){

                $q->where("status","necesita_voluntar")->orWhere("volunteer_id",$authUser->id);

            });

        }



        return new SolicitationCollection($userQuery->paginate($limit));
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
        $data['categories']='alimente';
        $data['emergency']='test';
        $data['status']='triaj';
        $solicitation=Solicitation::create($data);

        return response()->json(["success"=>true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
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
        $data=$request->toArray();
        $user=$request->user();
        $solicitation=Solicitation::find($id);

        if($data['action'] == 'preluare'){
            $data['solicitation']['volunteer_id']=$user->id;
            $data['solicitation']['status']='solutionare';
        }

        if($data['action'] == 'renunta') {
            $data['solicitation']['volunteer_id']=null;
            $data['solicitation']['status']='necesita_voluntar';
        }

        if($data['action'] == 'solutioneaza') {
            $data['solicitation']['status']='finalizat';
        }

            $solicitation->update($data['solicitation']);

        return response()->json(["success"=>true]);
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
}
