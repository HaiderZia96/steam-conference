<?php

namespace App\Http\Controllers\Manager\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function getStateIndexSelect(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $countryId = $request->countryId;
            $data = State::where('country_id', $countryId)
                ->where('name', 'like', '%' . $search . '%')
                ->get();
        }

        return response()->json($data);
    }
}
