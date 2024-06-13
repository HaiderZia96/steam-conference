<?php

namespace App\Http\Controllers\API\Event;

use App\Http\Controllers\Controller;
use App\Models\UserRegistration;
use App\Models\ConferenceYear;
use App\Traits\Api\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    use Response;

    public $data;

    public function eventList(Request $request)
    {

        $page_number = intval($request->page_number); //get page number
        $draw = 10; // per page shows row
        $start = 0; // array start with 0
        if ($page_number != 1) {
            $start = ($page_number * $draw) - $draw;
        }
        $eventList = ConferenceYear::orderBy('name', 'Desc')->where('status',1)->skip($start)->take($draw)->get();
        $eventCount = ConferenceYear::where('status',1)->count();

        if (count($eventList) < 1) {
            $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
                "success" => ["Data Not Found"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }

        $list = array();
        foreach ($eventList as $event) {
            $response = [
                'event_id' => $event->id,
                'name' => $event->name,
            ];
            array_push($list, $response);
        }

        $response = array(
            "page_number" => $page_number,
            "total_count" => $eventCount,
            "draw" => $draw,
            "response" => $list
        );

        $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
            "success" => ["Data Fetched Successfully"],
            'data' => $response
        ];
        $this->setResponse($this->data);
        return $this->getResponse();
    }

    public function allCounts(Request $request)
    {
        $event_id = $request->event_id;
        if (!isset($event_id)) {
            $this->data = ['status_code' => 200, 'code' => 100401, 'response' => '',
                "success" => ["event field is require"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }

        $campusCount = UserRegistration::join('registration_types', 'registration_types.id', 'user_registrations.registration_type_id')
            ->select([
                'registration_types.id', 'registration_types.name',
                DB::raw('(SELECT COUNT(*) FROM user_registrations WHERE user_registrations.registration_type_id =registration_types.id) as candidate_count')
            ])->where('user_registrations.conference_year_id', $event_id)->groupBy('user_registrations.registration_type_id')->get();
        $totalRegister = UserRegistration::where('conference_year_id', $event_id)->get()->count();
        $list = array();
        foreach ($campusCount as $camCount) {
            $response = [
                'registration_type' => $camCount->name,
                'count' => $camCount->candidate_count,
            ];
            array_push($list, $response);
        }

        // API Response
        $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
            "success" => ["Data Fetched Successfully"],
            'data' => [
                'total_register' => $totalRegister,
                'registration_type_wise' => $list,
            ]
        ];
        $this->setResponse($this->data);
        return $this->getResponse();
    }
}
