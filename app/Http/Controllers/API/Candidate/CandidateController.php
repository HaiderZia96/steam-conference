<?php

namespace App\Http\Controllers\API\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CandidateAttendance;
use App\Models\UserRegistration;
use App\Models\User;
use App\Traits\Api\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response as ImageResponse;

class CandidateController extends Controller
{
    use Response;

    public $data;

    public function registerList(Request $request)
    {
        if (!isset($request->event_id)) {
            $this->data = ['status_code' => 200, 'code' => 100401, 'response' => '',
                "success" => ["event field is require"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }
        $page_number = intval($request->page_number); //get page number
        $draw = 10; // per page shows row
        $start = 0; // array start with 0
        if ($page_number != 1) {
            $start = ($page_number * $draw) - $draw;
        }
        $search = $request->name;
        if (isset($search)) {
            // $registered = UserRegistration::join ('users','users.id','user_registrations.user_id')->
            // where('conference_year_id', $request->event_id)->where('reg_no', 'LIKE', "%{$search}%")->skip($start)->take($draw)->get();
            $registered = UserRegistration::join('users', 'users.id', '=', 'user_registrations.user_id')
                ->select('user_registrations.*', 'users.name as user_name', 'users.email as user_email')
                ->where('user_registrations.conference_year_id', $request->event_id)
                ->where('users.name', 'LIKE', "%{$search}%")
                ->skip($start)
                ->take($draw)
                ->get();
            $registeredCount = UserRegistration::join('users', 'users.id', '=', 'user_registrations.user_id')
                ->select('user_registrations.*', 'users.name as user_name', 'users.email as user_email')
                ->where('user_registrations.conference_year_id', $request->event_id)
                ->where('users.name', 'LIKE', "%{$search}%")
                ->count();

        } else {
            // $registered = UserRegistration::where('conference_year_id', $request->event_id)->skip($start)->take($draw)->get();
            $registered = UserRegistration::join('users', 'users.id', '=', 'user_registrations.user_id')
                ->select('user_registrations.*', 'users.name as user_name', 'users.email as user_email')
                ->where('user_registrations.conference_year_id', $request->event_id)
                ->skip($start)
                ->take($draw)
                ->get();

            $registeredCount = UserRegistration::where('conference_year_id', $request->event_id)->count();
        }
        $totalReg = UserRegistration::where('conference_year_id', $request->event_id)->count();
        if (count($registered) < 1) {
            $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
                "success" => ["Data Not Found"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }
        // dd($registered);

        $list = array();
        foreach ($registered as $reg) {
            if ($reg->candidate_image == null) {
                $profile = url('admin/coreui') . '/assets/img/avatars/user.png';
            } else {
                $profile = route('profile-image', $reg->id);
            }

            if ($reg->current_position == null || $reg->current_position == 0) {
                $current_position = 0;
            } else {
                $current_position = 1;
            }
            if ($reg->status_type_id == 1) {
                $voucher_status = 'pending';
            } elseif ($reg->status_type_id == 2) {
                $voucher_status = 'approved';
            } elseif ($reg->status_type_id == 3) {
                $voucher_status = 'rejected';
            } else {
                $voucher_status = 'voucher not submitted';
            }
            $scanBy = CandidateAttendance::where('candidate_id', $reg->id)->orderBy('id', 'desc')->first();
            $scan_at = '';
            $scan_by = '';
            if (isset($scanBy)) {
                $scan_at = date('d/M, Y', strtotime($scanBy->created_at));
                $scan_by = $scanBy->scanBy->name;
            }
            $response = [
                'name' => $reg->user_name,
                'email' => $reg->user_email,
                // 'reg_no' => $reg->reg_no,
                'current_position' => $current_position,
                'profile' => $profile,
                'scan_at' => $scan_at,
                'scan_by' => $scan_by,
                'pass_id' => $reg->pass_id,
                'payment_status' => $voucher_status,
            ];
            array_push($list, $response);
        }

        $response = array(
            "page_number" => $page_number,
            "total_count" => $registeredCount,
            "total_register" => $totalReg,
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

    // Candidate Profile
    public function getImage($cid)
    {
        $record = UserRegistration::where('id', '=', $cid)->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $path = Storage::disk('private')->path('candidate/profile/' . $record->candidate_image);
        if (File::exists($path)) {
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = ImageResponse::make($file, 200);
            $response->header("Content-Type", $type);
            ob_end_clean();
            return $response;
        } else {
            abort(404, 'NOT FOUND');
        }
    }

    public function scanCandidate($qrCode)
    {
        $Candidate = UserRegistration::join('users', 'users.id', '=', 'user_registrations.user_id')
            ->join('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->select('user_registrations.*', 'users.name as user_name', 'users.email as user_email', 'registration_types.name as registration_type_name')
            ->where('pass_id', $qrCode)
            ->first();
        if (!isset($Candidate)) {
            $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
                "error" => ["Data not Found"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }
        if ($Candidate->current_position == null || $Candidate->current_position == 0) {
            $current_position = 0;
        } else {
            $current_position = 1;
        }
        if ($Candidate->status_type_id == 1) {
            $voucher_status = 'pending';
        } elseif ($Candidate->status_type_id == 2) {
            $voucher_status = 'approved';
        } elseif ($Candidate->status_type_id == 3) {
            $voucher_status = 'rejected';
        } else {
            $voucher_status = 'voucher not submitted';
        }

        if ($Candidate->candidate_image == null) {
            $profile = url('admin/coreui') . '/assets/img/avatars/user.png';
        } else {
            $profile = route('profile-image', $Candidate->id);
        }

        $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
            "success" => ["Data Fetched Successfully"],
            'data' => [
                'name' => (isset($Candidate->user_name) ? $Candidate->user_name : ''),
                'contact_no' => (isset($Candidate->contact_no) ? $Candidate->contact_no : ''),
                'email' => (isset($Candidate->user_email) ? $Candidate->user_email : ''),
                'qualification' => (isset($Candidate->qualification) ? $Candidate->qualification : ''),
                'registration_type' => (isset($Candidate->registration_type_name) ? $Candidate->registration_type_name : ''),
                'current_position' => (isset($current_position) ? $current_position : ''),
                'voucher_status' => (isset($voucher_status) ? $voucher_status : ''),
                'profile' => $profile,
            ]
        ];
        $this->setResponse($this->data);
        return $this->getResponse();
    }

    public function attendanceMark(Request $request, $qrCode)
    {
        if (!isset($request->in_out)) {
            $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
                "error" => ["in, out field is require"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }

        $Candidate = UserRegistration::join('users', 'users.id', '=', 'user_registrations.user_id')
            ->join('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->select('user_registrations.*', 'users.name as user_name', 'users.email as user_email', 'registration_types.name as registration_type_name')
            ->where('pass_id', $qrCode)
            ->first();
        if (!isset($Candidate)) {
            $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
                "error" => ["Data not Found"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }

        $user = User::where('m_login_token', $request->header('auth'))->first();
        if (!isset($user)) {
            $this->data = ['status_code' => 401,
                "error" => ["invalid user login token"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }

        $arr = [
            'conference_year_id' => $Candidate->conference_year_id,
            'candidate_id' => $Candidate->id,
            'in_out' => $request->in_out,
            'attendance_mark_by' => $user->id,
        ];
        $record = CandidateAttendance::create($arr);

        $arrUp = [
            'current_position' => $request->in_out,
        ];
        $Candidate->update($arrUp);

        $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
            "success" => ["Success"],
            'data' => [
                'candidate' => $Candidate->user_name,
                'in_out' => $record->in_out,
                'scan_by' => $record->scanBy->name,
            ]
        ];
        $this->setResponse($this->data);
        return $this->getResponse();
    }

    public function attendanceHistory(Request $request, $qrCode)
    {
        $Candidate = UserRegistration::join('users', 'users.id', '=', 'user_registrations.user_id')->
        join('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->select('user_registrations.*', 'users.name as user_name', 'users.email as user_email', 'registration_types.name as registration_type_name')->where('pass_id', $qrCode)->first();

        if (!isset($Candidate)) {
            $response = array(
                "page_number" => 0,
                "draw" => 0,
                "total_attendace" => 0,
                "total_in" => 0,
                "total_out" => 0,
                "response" => []
            );
            $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
                "success" => ["Data Fetched Successfully"],
                'data' => $response
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }

        $page_number = intval($request->page_number); //get page number
        $draw = 10; // per page shows row
        $start = 0; // array start with 0
        if ($page_number != 1) {
            $start = ($page_number * $draw) - $draw;
        }

        $totalAtt = CandidateAttendance::where('candidate_id', $Candidate->id)->get()->count();
        $totalInAtt = CandidateAttendance::where('candidate_id', $Candidate->id)->where('in_out', 1)->get()->count();
        $totalOutAtt = CandidateAttendance::where('candidate_id', $Candidate->id)->where('in_out', 0)->get()->count();
        $attendance = CandidateAttendance::
        join('users', 'users.id', '=', 'candidate_attendances.candidate_id')->
        select('candidate_attendances.*', 'users.name as user_name', 'users.email as user_email')->
        where('candidate_id', $Candidate->id)->skip($start)->take($draw)->get();
        // dd($attendance);
        if (count($attendance) < 1) {
            $response = array(
                "page_number" => $page_number,
                "draw" => $draw,
                "total_attendace" => $totalAtt,
                "total_in" => $totalInAtt,
                "total_out" => $totalOutAtt,
                "response" => []
            );
        }

        $history = array();
        foreach ($attendance as $att) {
            // dd($att);
            $response = [
                'name' => $att->user_name,
                'in_out' => $att->in_out,
                'scan_by' => $att->scanBy->name,
                'scan_at' => date('g:i A d/M, Y', strtotime($att->created_at)),
            ];
            array_push($history, $response);
        }

        $response = array(
            "page_number" => $page_number,
            "draw" => $draw,
            "total_attendace" => $totalAtt,
            "total_in" => $totalInAtt,
            "total_out" => $totalOutAtt,
            "response" => $history
        );

        $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
            "success" => ["Data Fetched Successfully"],
            'data' => $response
        ];
        $this->setResponse($this->data);
        return $this->getResponse();
    }


    public function attendanceDetail($qrCode)
    {
        // Candidate Detail
        $Candidate = UserRegistration::join('users', 'users.id', '=', 'user_registrations.user_id')
            ->join('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->select('user_registrations.*', 'users.name as user_name', 'users.email as user_email', 'registration_types.name as registration_type_name')
            ->where('pass_id', $qrCode)
            ->first();

        if (!isset($Candidate)) {
            $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
                "error" => ["Data not Found"],
                'data' => []
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }

        // Candidate Attendance
        $attendance = CandidateAttendance::join('users', 'users.id', '=', 'candidate_attendances.candidate_id')
            ->where('candidate_id', $Candidate->user_id)->first();
        if (!isset($attendance)) {
            $candidate = array();
            $attendanceResponse = [
                'name' => $Candidate->user_name,
                'in_out' => 0,
            ];
            array_push($candidate, $attendanceResponse);
        } else {
            $candidate = array();
            $attendanceResponse = [
                'name' => $attendance->name,
                'in_out' => intval($Candidate->current_position),
            ];
            array_push($candidate, $attendanceResponse);
        }
        // API Response
        $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
            "success" => ["Data Fetched Successfully"],
            'data' => [
                'candidate' => $candidate,
            ]
        ];
        $this->setResponse($this->data);
        return $this->getResponse();
    }

    public function totalCounts(Request $request)
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
        //Candidate
        $candidateCount = UserRegistration::where('conference_year_id', $event_id)->count();
        $candidateAttendanceInCount = UserRegistration::where('conference_year_id', $event_id)
            ->where('current_position', 1)->count();
        $candidateAttendanceOutCount = UserRegistration::where('conference_year_id', $event_id)
            ->where(function ($q) {
                $q->where('current_position', 0)
                    ->orWhereNull('current_position');
            })
            ->count();
        // API Response
        $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
            "success" => ["Data Fetched Successfully"],
            'data' => [
                'total_candidate' => $candidateCount,
                'total_candidate_in' => $candidateAttendanceInCount,
                'total_candidate_out' => $candidateAttendanceOutCount,
            ]
        ];
        $this->setResponse($this->data);
        return $this->getResponse();
    }

    public function paymentStatus(Request $request)
    {
        $pass_id = $request->pass_id;
        $candidate = UserRegistration::join('users', 'users.id', '=', 'user_registrations.user_id')
            ->join('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->select('user_registrations.*', 'users.name as user_name', 'users.email as user_email', 'registration_types.name as registration_type_name')
            ->where('pass_id', $pass_id)
            ->first();
        if (!isset($candidate)) {
            // API Response
            $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
                "success" => ["Data Fetched Successfully"],
                'data' => [
                    'payment_status' => 'no record found',
                    'candidate_payment_status' => 'no record found'
                ]
            ];
            $this->setResponse($this->data);
            return $this->getResponse();
        }
        if ($candidate->status_type_id == 1) {
            $payment_status = 'pending';
        } elseif ($candidate->status_type_id == 2) {
            $payment_status = 'approved';
        } elseif ($candidate->status_type_id == 3) {
            $payment_status = 'rejected';
        } else {
            $payment_status = 'voucher not submitted';
        }
        // API Response
        $this->data = ['status_code' => 200, 'code' => 100200, 'response' => '',
            "success" => ["Data Fetched Successfully"],
            'data' => [
                'payment_status' => $payment_status,
                'candidate_payment_status' => $payment_status,
            ]
        ];
        $this->setResponse($this->data);
        return $this->getResponse();
    }
}
