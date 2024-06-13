<?php

namespace App\Http\Controllers\Manager\MasterData;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getCityIndexSelect(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $countryId = $request->countryId;
            $stateId = $request->stateId;
            $data = City::where('country_id', $countryId)
                ->where('state_id', $stateId)
                ->where('name', 'like', '%' . $search . '%')
                ->get();
        }

        return response()->json($data);
    }


}
