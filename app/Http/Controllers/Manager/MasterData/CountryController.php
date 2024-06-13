<?php

namespace App\Http\Controllers\Manager\MasterData;


use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:manager_master-data_payment-type-list', ['only' => ['index', 'getIndex']]);
        $this->middleware('permission:manager_master-data_payment-type-activity-log', ['only' => ['getActivity', 'getActivityLog']]);
        $this->middleware('permission:manager_master-data_payment-type-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:manager_master-data_payment-type-show', ['only' => ['show']]);
        $this->middleware('permission:manager_master-data_payment-type-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:manager_master-data_payment-type-delete', ['only' => ['destroy']]);
    }

    public function getCountryIndexSelect(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;

            $data = Country::where('name', 'like', '%' . $search . '%')
                ->get();
        }

        return response()->json($data);
    }
}
