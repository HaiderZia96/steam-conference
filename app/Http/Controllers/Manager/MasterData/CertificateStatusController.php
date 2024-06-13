<?php

namespace App\Http\Controllers\Manager\MasterData;

use App\Http\Controllers\Controller;
use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;

class CertificateStatusController extends Controller
{
     /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getIndexCertificateStatusSelect(Request $request)
    {
        $data = [];
    
        if ($request->has('q')) {
            $search = $request->q;
            $data = UserRegistration::where(function ($q) use ($search) {
                $q->where('attendee_status', 'like', '%' . $search . '%');
            })
            ->select('attendee_status') // Select the 'attendee_status' column
            ->groupBy('attendee_status') // Group by 'attendee_status' to remove duplicates
            ->get();
    
            // Create an array with two options: "0" and "1"
            $options = [
                ['id' => '0', 'text' => 'Not Issue Certificate'],
                ['id' => '1', 'text' => 'Issue Certificate'],
            ];
    
            // Merge the two arrays: options and data
            $data = $options + $data->map(function ($item) {
                return [
                    'id' => $item->attendee_status,
                    'text' => $item->attendee_status,
                ];
            })->toArray();

            // dd($data);
        }
    
        return response()->json($data);
    }
}
