<?php

namespace App\Http\Controllers;

use App\Beneficiary;
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
     * @return SolicitationCollection
     */
    public function index(Request $request)
    {
        $authUser = Auth::user();

        $searchParams = $request->all();
        $userQuery = Solicitation::query();

        $limit = Arr::get($searchParams, 'limit', 15);
        $categories = Arr::get($searchParams, 'categories', '');
        $status = Arr::get($searchParams, 'status', '');

        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($categories)) {
            $userQuery->where("categories", $categories);
        }

        if (!empty($status) && $authUser->hasRole('admin')) {
            $userQuery->where("status", $status);
        }

        $userQuery->with("beneficiary");
        $userQuery->with("volunteer");

        if (!empty($keyword)) {
            $userQuery->leftJoin('beneficiaries', 'solicitations.beneficiary_id', '=', 'beneficiaries.id');

            $userQuery->orWhere('beneficiaries.first_name', 'LIKE', '%' . $keyword . '%');
            $userQuery->orWhere('beneficiaries.last_name', 'LIKE', '%' . $keyword . '%');
            $userQuery->orWhere('beneficiaries.phone', 'LIKE', '%' . $keyword . '%');
            $userQuery->orWhere('beneficiaries.address', 'LIKE', '%' . $keyword . '%');
            $userQuery->orWhere('beneficiaries.neighborhood', 'LIKE', '%' . $keyword . '%');
            $userQuery->orWhere('beneficiaries.city', 'LIKE', '%' . $keyword . '%');
        }

        if (!$authUser->hasRole('admin')) {

            $userQuery->where(function ($q) use ($authUser) {

                $q->where("status", "necesita_voluntar")->orWhere("volunteer_id", $authUser->id);

            });

        }

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

        $phone = '0745000001';

        $beneficiary = Beneficiary::where('phone', $phone)->first();
        if (!$beneficiary) {
            $newBeneficiary = [
                'first_name' => 'First',
                'last_name' => 'Last',
                'phone' => $phone,
                'address' => 'Principala nr 1',
                'neighborhood' => 'Marasti',
                'city' => 'Cluj-Napoca',
                'county' => 'Cluj'
            ];
            $beneficiary = Beneficiary::create($newBeneficiary);
        }
        $data['beneficiary_id'] = $beneficiary->id;
        $data['categories'] = 'alimente';
        $data['emergency'] = 'test';
        $data['status'] = 'triaj';
        $data['payment_type'] = 'card';
        $data['payment_status'] = 'neachitat';
        $data['payment_value'] = '9.90';
        $data['additional_responses'] = 'test test';

        $solicitation = Solicitation::create($data);

        return response()->json(["success" => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
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
        $user = $request->user();
        $solicitation = Solicitation::find($id);

        if ($data['action'] == 'preluare') {
            $data['solicitation']['volunteer_id'] = $user->id;
            $data['solicitation']['status'] = 'solutionare';
        }

        if ($data['action'] == 'renunta') {
            $data['solicitation']['volunteer_id'] = null;
            $data['solicitation']['status'] = 'necesita_voluntar';
        }

        if ($data['action'] == 'solutioneaza') {
            $data['solicitation']['status'] = 'finalizat';
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
}
