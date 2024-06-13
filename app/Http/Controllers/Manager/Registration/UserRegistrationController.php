<?php

namespace App\Http\Controllers\Manager\Registration;

use App\Http\Controllers\Controller;
use App\Models\CertificatePDF;
use App\Models\City;
use App\Models\ConferenceYear;
use App\Models\Country;
use App\Models\Module;
use App\Models\PaymentType;
use App\Models\StatusType;
use App\Models\RegistrationType;
use App\Models\State;
use App\Models\Venue;
use App\Models\User;
use App\Models\UserRegistration;
use App\Models\VoucherPDF;
use App\Models\VoucherPDFHead;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Response;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;

class UserRegistrationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:manager_registration_user-registration-list', ['only' => ['index', 'getIndex']]);
        $this->middleware('permission:manager_registration_user-registration-activity-log', ['only' => ['getActivity', 'getActivityLog']]);
        $this->middleware('permission:manager_registration_user-registration-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:manager_registration_user-registration-show', ['only' => ['show']]);
        $this->middleware('permission:manager_registration_user-registration-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:manager_master-data_status-type-status-edit', ['only' => ['editStatus', 'updateStatus']]);
        $this->middleware('permission:manager_master-data_certificate-status-edit', ['only' => ['editCertificateStatus', 'updateCertificateStatus']]);
        $this->middleware('permission:manager_registration_user-registration-voucher-download', ['only' => ['voucher']]);
        $this->middleware('permission:manager_registration_user-registration-voucher-upload', ['only' => ['upload']]);
        $this->middleware('permission:manager_registration_user-registration-voucher-view', ['only' => ['getImage']]);
        $this->middleware('permission:manager_registration_user-registration-gate-pass-download', ['only' => ['gatePass']]);
        $this->middleware('permission:manager_registration_user-registration-delete', ['only' => ['destroy']]);
        // $this->middleware('permission:manager_session_convocation-session-active', ['only' => ['sessionStatus']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($yid)
    {
        $yid = ConferenceYear::where('id', $yid)->first();
       

        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }
        $registration_types = RegistrationType::get();
        $status_types = StatusType::get();
        $qualifications = UserRegistration::groupBy('qualification')->get();
        // dd($qualifications);
        //Data Array
        $data = array(
            'page_title' => 'User Registration',
            'p_title' => 'User Registration',
            'p_summary' => 'List of User Registration',
            'p_description' => null,
            'url' => route('manager.conference-year.user-registration.create', $yid->id),
            'url_text' => 'Add New',
            'trash' => route('manager.get.user-registration-activity-trash', $yid->id),
            'trash_text' => 'View Trash',
            'sdata' => $yid->id,
            'registration_types' => $registration_types,
            'status_types' => $status_types,
            'qualifications' => $qualifications,
            // 'fees' => $fees,
        );

        return view('manager.registration.userRegistration.index')->with($data);
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        //Add Filters
        $where = [];

        if (!empty($request->get('user_id'))) {
            $user = $request->get('user_id');
            $var = ['user_registrations.user_id', '=', $user];
            array_push($where, $var);
        }
        if (!empty($request->get('registration_type_id'))) {
            $registration_type = $request->get('registration_type_id');
            $var = ['user_registrations.registration_type_id', '=', $registration_type];
            array_push($where, $var);
        }

        if (!empty($request->get('conference_year_id'))) {
            $session = $request->get('conference_year_id');
            $var = ['user_registrations.conference_year_id', '=', $session];
            array_push($where, $var);
        } elseif (!empty($request->get('yid'))) {
            // Use the 'yid' parameter to filter by session ID
            $session = $request->get('yid');
            $var = ['user_registrations.conference_year_id', '=', $session];
            array_push($where, $var);
        }

        // if (!empty($request->get('status_type_id'))) {
        //     $status_type = $request->get('status_type_id');
        //     $var = ['user_registrations.status_type_id', '=', $status_type];
        //     array_push($where, $var);
        // }
        if (!empty($request->get('status_type_id'))) {
            $status_type = $request->get('status_type_id');
        // dd($status_type);
            if ($status_type == '1') {
                // If status type is pending, filter based on voucher_upload not equal to null
                $var = ['user_registrations.voucher_upload', '!=', null];
                $var1 = ['user_registrations.status_type_id', '!=', '2'];
                $var2 = ['user_registrations.status_type_id', '!=', '3'];
                array_push($where, $var, $var1, $var2);
            }
            elseif ($status_type == '4') {
                // If status type is pending, filter based on voucher_upload not equal to null
                $var = ['user_registrations.voucher_upload', '=', null];
                $var1 = ['user_registrations.status_type_id', '!=', '2'];
                $var2 = ['user_registrations.status_type_id', '!=', '3'];
                array_push($where, $var, $var1, $var2);
            }
            else {
                // For other status types, filter based on status_type_id
                $var = ['user_registrations.status_type_id', '=', $status_type];
                // dd($var);
                array_push($where, $var);
            }
        }
        

        if (!empty($request->get('payment_type_id'))) {
            $payment_type = $request->get('payment_type_id');
            $var = ['user_registrations.payment_type_id', '=', $payment_type];
            array_push($where, $var);
            // dd($payment_type);
        }
        if (!empty($request->get('qualification'))) {
            $qualification = $request->get('qualification');
            
            $var = ['user_registrations.qualification', '=', $qualification];
            array_push($where, $var);
        }
        // dd($where);
        // Total records
        $totalRecords = UserRegistration::select('user_registrations.*', 'users.name as name', 'users.email as email',
            'registration_types.name as registration_type_name',
            'status_types.name as status_type_name', 'conference_years.name as conference_year_name')
            ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
            ->leftJoin('conference_years', 'conference_years.id', '=', 'user_registrations.conference_year_id')
            ->leftJoin('payment_types', 'payment_types.id', '=', 'user_registrations.payment_type_id')
            ->leftJoin('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
            ->where($where)
            ->count();
            //  dd($totalRecords);

        // Total records with filter
        $totalRecordswithFilter = UserRegistration::select('user_registrations.*', 'users.name as name', 'users.email as email',
            'registration_types.name as registration_type_name',
            'status_types.name as status_type_name', 'conference_years.name as conference_year_name')
            ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
            ->leftJoin('conference_years', 'conference_years.id', '=', 'user_registrations.conference_year_id')
            ->leftJoin('payment_types', 'payment_types.id', '=', 'user_registrations.payment_type_id')
            ->leftJoin('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
            ->where($where)
            ->where(function ($q) use ($searchValue) {
                $q->where('users.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('conference_years.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = UserRegistration::select('user_registrations.*', 'users.name as name', 'users.email as email',
            'registration_types.name as registration_type_name',
            'status_types.name as status_type_name', 'conference_years.name as conference_year_name', 'payment_types.name as payment_type_name')
            ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
            ->leftJoin('conference_years', 'conference_years.id', '=', 'user_registrations.conference_year_id')
            ->leftJoin('payment_types', 'payment_types.id', '=', 'user_registrations.payment_type_id')
            ->leftJoin('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
            ->where($where)
            ->where(function ($q) use ($searchValue) {
                $q->where('users.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.email', 'like', '%' . $searchValue . '%')
                    ->orWhere('conference_years.name', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();
            // dd($records);

        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $name = $record->name;
            $email = $record->email;
            $qualification = $record->qualification;
            $conference_year_name = $record->conference_year_name;
            $registration_type_name = $record->registration_type_name;
            $payment_type_name = $record->payment_type_name;
            $status_type_name = $record->status_type_name;
            $voucher_upload = $record->voucher_upload;
            $attendee_status = $record->attendee_status;
            $status = User::where('id',$record->user_id )->pluck('status')->first();
            $user_id = $record->user_id;
// dd($status);

            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "qualification" => $qualification,
                "conference_year_name" => $conference_year_name,
//                "module_name" => $module_name,
                "registration_type_name" => $registration_type_name,
                "status_type_name" => $status_type_name,
                "voucher_upload" => $voucher_upload,
                "payment_type_name" => $payment_type_name,
                "attendee_status" => $attendee_status,
                "status" => $status,
                "user_id" => $user_id,
//                "submission_type_name" => $submission_type_name,

            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        // dd( $response);
        echo json_encode($response);
        exit;
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getIndexSelect(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = UserRegistration::select('user_registrations.id as id', 'user_registrations.name as name')
                ->where(function ($q) use ($search) {
                    $q->where('user_registrations.name', 'like', '%' . $search . '%');
                })
                ->get();
        }

        return response()->json($data);

    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getSessionIndexSelect(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = UserRegistration::select('user_registrations.id as id', 'user_registrations.name as name', 'conference_years.id as conference_year_id', 'conference_years.name as conference_year_name')
                ->leftJoin('conference_years', 'conference_years.id', '=', 'user_registrations.conference_year_id')
                ->where(function ($q) use ($search) {
                    $q->where('conference_years.name', 'like', '%' . $search . '%');
                })
                ->groupBy(['conference_years.id'])
                ->get();
        }

        return response()->json($data);

    }

    /**
     * Show the form for creating a new resource.
     * @param String_ $yid
     * @return \Illuminate\Http\Response
     */
    public function create(string $yid)
    {
        $record = ConferenceYear::where('id', '=', $yid)
            ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $paymentType = \App\Models\PaymentType::where('id', '=', 2)
            ->first();
        // dd($paymentType->name);

        $data = array(
            'page_title' => 'User Registration',
            'p_title' => 'User Registration',
            'p_summary' => 'Add User Registration',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.conference-year.user-registration.store', $record->id),
            'url' => route('manager.conference-year.user-registration.index', $record->id),
            'url_text' => 'View All',
//            'data' => $record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded',
            'paymentType' => $paymentType->name, // With attachment like file or images in form
        );
        return view('manager.registration.userRegistration.create')->with($data);
    }

    public function sessionDetail($yid)
    {
        // $userRegistrations = UserRegistration::get();

        // // Separate records into two arrays based on registration type
        // $registrationType0 = $userRegistrations->where('registration_type_id', 1)->all();
        // // dd($registrationType0);
        // $registrationType1 = $userRegistrations->where('registration_type_id', 2)->all();
        
        // // Extract necessary information from each array
        // $registrationType0Data = [];
        // $registrationType1Data = [];
        
        // foreach ($registrationType0 as $registration) {
        //     // Extract relevant information for registration type 0
        //     $registrationType0Data[] = [
        //         'id' => $registration->id,
        //         'name' => $registration->title,
        //         // Add more fields as needed
        //     ];
        // }
        
        // foreach ($registrationType1 as $registration) {
        //     // Extract relevant information for registration type 1
        //     $registrationType1Data[] = [
        //         'id' => $registration->id,
        //         'name' => $registration->title,
        //         // Add more fields as needed
        //     ];
        // }
        
        // // Convert arrays to JSON
        // $registrationType0Json = json_encode($registrationType0Data);
        // // dd($registrationType0Json);
        // $registrationType1Json = json_encode($registrationType1Data);
        // dd($registrationType1Json);
        // Use $registrationType0Json and $registrationType1Json as needed
        

          // Registration Wise Count
          $userRegistrationCount = DB::select("SELECT registration_types.name as name,
          (SELECT COUNT(*) FROM user_registrations WHERE user_registrations.registration_type_id =registration_types.id) AS registration_count
          FROM registration_types
          LEFT JOIN user_registrations
          ON user_registrations.registration_type_id =registration_types.id
          GROUP by user_registrations.registration_type_id");
            $registrationCountName = array();
            $registrationCountCount = array();
            foreach ($userRegistrationCount as $reg) {
            $registrationCountName[] = $reg->name;
            $registrationCountCount[] = $reg->registration_count;
            }
            $registrationCountNameJs = json_encode($registrationCountName);
            $registrationCountCountJs = json_encode($registrationCountCount);

            // Fee Wise Count
          $userFeeCount = DB::select("SELECT status_types.name as name,
          (SELECT COUNT(*) FROM user_registrations WHERE user_registrations.status_type_id = status_types.id) AS fee_status_count
          FROM status_types
          LEFT JOIN user_registrations
          ON user_registrations.status_type_id = status_types.id
          GROUP by user_registrations.status_type_id");
        //   dd( $userFeeCount);
            $feeCountName = array();
            $feeCountCount = array();
            foreach ($userFeeCount as $reg) {
            $feeCountName[] = $reg->name;
            $feeCountCount[] = $reg->fee_status_count;
            }
            $feeCountNameJs = json_encode($feeCountName);
            $feeCountCountJs = json_encode($feeCountCount);
        // dd($userRegistrationCount)
        // ;
        // User Paper Submission Count
        $candidateRCount = UserRegistration::count();
        // dd($candidateRCount);
        // $userPaperCount = DB::select("SELECT status_types.name as name,
        // (SELECT COUNT(*) FROM paper_submissions WHERE paper_submissions.status_type_id = status_types.id  ) AS paper_count
        // FROM status_types
        // LEFT JOIN paper_submissions  
        // ON paper_submissions.status_type_id = status_types.id
        // GROUP by paper_submissions.status_type_id");
        $userPaperCount = DB::select("SELECT
        status_type_id,
        status_type_name,
        COUNT(*) AS count
        FROM (
        SELECT DISTINCT
            user_registrations.id AS user_registration_id,
            COALESCE(paper_submissions.user_registration_id, NULL) AS paper_submission_user_registration_id,
            COALESCE(paper_submissions.status_type_id, 4) AS status_type_id,
            COALESCE(status_types.name, 'Not Submitted') AS status_type_name
        FROM
            user_registrations
        LEFT JOIN
            paper_submissions ON user_registrations.id = paper_submissions.user_registration_id
        LEFT JOIN
            status_types ON status_types.id = paper_submissions.status_type_id
        ) AS subquery
        GROUP BY
            status_type_id, status_type_name");
        //   dd($userPaperCount);
            $paperCountName = array();
            $paperCountCount = array();
            foreach ($userPaperCount as $reg) {
            $paperCountName[] = $reg->status_type_name;
            $paperCountCount[] = $reg->count;
            }
            $paperCountNameJs = json_encode($paperCountName);
            $paperCountCountJs = json_encode($paperCountCount);
       
        // Total Alumni
        // $eligibleCount = Eligibles::count();
        // Total Candidate Register
        $registerCount = UserRegistration::where('conference_year_id', $yid)->count();
        $tufiansCount = UserRegistration::where('conference_year_id', $yid)
        ->where('registration_type_id', 2)->count();
        $nontufiansCount = UserRegistration::where('conference_year_id', $yid)
        ->where('registration_type_id', 1)->count();

        $statusPendingCount = UserRegistration::where('conference_year_id', $yid)
        ->where('status_type_id', 1)
        ->where('voucher_upload', '!=', null)
        ->count();
        $statusApprovedCount = UserRegistration::where('conference_year_id', $yid)
        ->where('status_type_id', 2)
        ->count();
        $statusRejectedCount = UserRegistration::where('conference_year_id', $yid)
        ->where('status_type_id', 3)
        ->count();
        $statusNotSubmittedCount = UserRegistration::where('conference_year_id', $yid)
        ->where('status_type_id', 4)
        // ->where('voucher_upload', '=', null)
        ->count();
        // dd($statusNotSubmittedCount);

        // Total Guest
        // $guestCount = GuestDetail::where('session_id', $sid)->count();
        // Total Degree
        // $degreeCount = CandidateRegistration::where('session_id', $sid)->groupBy('degree_name')->get()->count();


        // Attendance
        // $candidatePresent = CandidateAttendance::groupBy('candidate_id')->where('session_id', $sid)->get()->count();
        // $candidateAbsent = $registerCount - $candidatePresent;
        // $guestPresent = GuestAttendance::groupBy('guest_id')->where('session_id', $sid)->get()->count();
        // $guestAll = GuestDetail::where('session_id', $sid)->count();
        // $guestAbsent = $guestAll - $guestPresent;

        // $attendanceView = array();
        // $attendanceCompile = [
        //     'present_candidate' => $candidatePresent,
        //     'absent_candidate' => $candidateAbsent,
        //     'preset_guest' => $guestPresent,
        //     'absent_guest' => $guestAbsent,
        // ];
        // array_push($attendanceView, $attendanceCompile);
        // $attendanceDetail = [
        //     'Present Candidate', 'Absent Candidate', 'Present Guest', 'Absent Guest'
        // ];
        // $attendanceTotalCount = [
        //     $candidatePresent, $candidateAbsent, $guestPresent, $guestAbsent
        // ];
        // $attendanceFilter_label = json_encode($attendanceDetail);
        // $attendanceCount = json_encode($attendanceTotalCount);


        $session = ConferenceYear::where('id', $yid)->first();
        $data = array(
            'page_title' => $session->title . ' Event Dashboard',
            'p_title' => 'Dashboard',
            's_title' => $session->title,
            'p_summary' => 'Dashboard',
            'p_description' => null,
            'method' => 'POST',
            // 'action' => route('manager.convocation-session.store'),
            // 'url' => route('manager.convocation-session.index'),
            'url_text' => 'View All',
            'enctype' => 'multipart/form-data', // (Default)Without attachment
            'session' => $session,
            // 'guest_count' => $guestCount,
            // 'attendance_view' => $attendanceView,
            // 'attendance_filter_label' => $attendanceFilter_label,
            // 'attendance_count' => $attendanceCount,
            'userRegistrationCount' => $userRegistrationCount,
            'registrationCountNameJs' =>  $registrationCountNameJs,
            'registrationCountCountJs' =>  $registrationCountCountJs,
            'userFeeCount' => $userFeeCount,
            'feeCountNameJs' =>  $feeCountNameJs,
            'feeCountCountJs' =>  $feeCountCountJs,
            // 'eligibleCount' => $eligibleCount,
            'registerCount' => $registerCount,
            'tufiansCount' => $tufiansCount,
            'nontufiansCount' => $nontufiansCount,
            'statusPendingCount' =>  $statusPendingCount,
            'statusApprovedCount' =>  $statusApprovedCount,
            'statusRejectedCount' =>  $statusRejectedCount,
            'statusNotSubmittedCount' =>  $statusNotSubmittedCount,
            'userPaperCount' =>  $userPaperCount,
            'paperCountNameJs' =>  $paperCountNameJs,
            'paperCountCountJs' =>  $paperCountCountJs,
           
            // 'registrationType0Json' =>  $registrationType0Json,
            // 'registrationType1Json' =>  $registrationType1Json,
            // 'guestCount' => $guestCount,
            // 'degreeCount' => $degreeCount,

        );
        // dd($data);
        return view('manager.conferenceSession.detail')->with($data);
    }

    public function candidateStatus($yid, $id)
    {
        $record = User::find($id);
        // dd($record);
        if ($record->status == '0') {
            $value = '1';
        } else {
            $value = '0';
        }
        $arr = [
            'status' => $value,
        ];

        $record->update($arr);
        $messages = [
            array(
                'message' => 'Record updated successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);
        return redirect()->route('manager.conference-year.user-registration.index', $yid);

    }
    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $yid)
    {
        $yid = ConferenceYear::where('id', '=', $yid)
            ->first();

        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }


        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
            'contact_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'qualification' => 'required',
            'title' => 'required',
            'payment' => 'required',
            'registration' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);


        // Check if the session is open
        $session = ConferenceYear::where('id', $yid->id)
            ->where('status', 1)->first();

        if (empty($session)) {
            // If the session is not open, show a message and redirect back
            $messages = [
                array(
                    'message' => 'Session is not active for registration. Please activate the session first',
                    'message_type' => 'error'
                ),
            ];
            Session::flash('messages', $messages);
            // dd(Session::flash('messages', $messages));
            return redirect()->back();
        }

        //Payment Type
        $payment = PaymentType::where('payment_types.id', $request->input('payment'))->first();
        if (empty($payment)) {
            abort(404, 'NOT FOUND');
        }

        //Registration Type
        $registration = RegistrationType::where('registration_types.id', $request->input('registration'))->first();
        if (empty($registration)) {
            abort(404, 'NOT FOUND');
        }

        //Country
        $country = Country::where('countries.id', $request->input('country'))->first();
        if (empty($country)) {
            abort(404, 'NOT FOUND');
        }

        //State
        $state = State::where('states.id', '=', $request->input('state'))->first();
        if (empty($state)) {
            abort(404, 'NOT FOUND');
        }

        //City
        $city = City::where('cities.id', '=', $request->input('city'))->first();
        if (empty($city)) {
            abort(404, 'NOT FOUND');
        }


        //Registration Status
        $status_type = StatusType::where('status_types.slug', 'not-submitted')->first();
        if (empty($status_type)) {
            abort(404, 'NOT FOUND');
        }
        // dd($status_type);


        // assign user module
        $module_slug = 'user';

        //Module
        $module = Module::where('modules.slug', '=', $module_slug)->first();
        if (empty($module)) {
            abort(404, 'NOT FOUND');
        }

        //Role
        $role = Role::where('roles.name', '=', 'user')->first();
        if (empty($role)) {
            abort(404, 'NOT FOUND');
        }



        $arr1 = [
            
            'qualification' => $request->input('qualification'),
            'title' => $request->input('title'),
            'contact_no' => $request->input('contact_no'),
            'conference_year_id' => $session->id,
            'payment_type_id' => $request->input('payment'),
            'submission_type_id' => $request->input('submission'),
            'registration_type_id' => $request->input('registration'),
            'status_type_id' => $status_type->id,
            'country_id' => $request->input('country'),
            'state_id' => $request->input('state'),
            'city_id' => $request->input('city'),
            'pass_id' => 'c_' . Str::uuid()->toString(),
            'created_by' => Auth::user()->id,
        ];
        
        $registrationRecord = UserRegistration::create($arr1);
        
        if ($registrationRecord) {
            // If $registrationRecord is successfully created, proceed to create $user
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'module_id' => $module->id,
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'created_by' => Auth::user()->id,
            ]);
        
            if ($user) {
                // If $user is successfully created, proceed to store $arr1
                $user->assignRole($role->name);

                $arr5 = [
                    'user_id' => $user->id
                ];

                $registrationRecord->update($arr5);
        
                $messages = [
                    array(
                        'message' => 'Record created successfully',
                        'message_type' => 'success'
                    ),
                ];
                Session::flash('messages', $messages);
            } else {
                // If $user creation fails, delete the $registrationRecord record
                $registrationRecord->delete();
        
                $messages = [
                    array(
                        'message' => 'Failed to create user record',
                        'message_type' => 'error'
                    )
                ];
                Session::flash('messages', $messages);
            }
        } else {
            $messages = [
                array(
                    'message' => 'Failed to create user registration record',
                    'message_type' => 'error'
                ),
            ];
            Session::flash('messages', $messages);
        }
        
        return redirect()->route('manager.conference-year.user-registration.index', $yid->id);
        
    }

    /**
     * Display the specified resource.
     * @param String_ $id ,
     * @return \Illuminate\Http\Response
     */
    public function show(string $yid, string $id)
    {
        $yid = ConferenceYear::where('id', '=', $yid)
            ->first();

        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }
        $record = UserRegistration::select('user_registrations.*', 'users.name as name', 'users.email as email',
            'users.password as password', 'conference_years.id as conference_year_id', 'conference_years.name as conference_year_name',
            'payment_types.id as payment_id', 'payment_types.name as payment_name',
            'registration_types.id as registration_id', 'registration_types.name as registration_name',
            'countries.id as country_id', 'countries.name as country_name',
            'states.id as state_id', 'states.name as state_name',
            'cities.id as city_id', 'cities.name as city_name',
            'status_types.id as status_type_id', 'status_types.name as status_type_name')
            ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
            ->leftJoin('conference_years', 'conference_years.id', '=', 'user_registrations.conference_year_id')
            ->leftJoin('payment_types', 'payment_types.id', '=', 'user_registrations.payment_type_id')
            ->leftJoin('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->leftJoin('countries', 'countries.id', '=', 'user_registrations.country_id')
            ->leftJoin('states', 'states.id', '=', 'user_registrations.state_id')
            ->leftJoin('cities', 'cities.id', '=', 'user_registrations.city_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
            ->where('user_registrations.id', '=', $id)
            ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        $userRecord = UserRegistration::select('user_registrations.*')
            ->where('id', '=', $id)
            ->first();

        if (empty($userRecord)) {
            abort(404, 'NOT FOUND');
        }

        // Add activity logs
        $user = Auth::user();
        activity('User Registration')
            ->performedOn($record)
            ->causedBy($user)
            ->event('viewed')
            ->withProperties(['attributes' => ['name' => $record->name]])
            ->log('viewed');

        //Data Array
        $data = array(
            'page_title' => 'User Registration',
            'p_title' => 'User Registration',
            'p_summary' => 'Show User Registration',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.conference-year.user-registration.update', [$yid->id, $record->id]),
            'url' => route('manager.conference-year.user-registration.index', $yid->id),
            'url_text' => 'View All',
            'data' => $record,
            'sdata' => $yid,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.registration.userRegistration.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $yid, string $id)
    {
        $yid = ConferenceYear::where('id', '=', $yid)
            ->first();

        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }
        $record = UserRegistration::select('user_registrations.*', 'users.name as name', 'users.email as email',
            'users.password as password', 'conference_years.id as conference_year_id', 'conference_years.name as conference_year_name',
            'payment_types.id as payment_id', 'payment_types.name as payment_name',
            'registration_types.id as registration_id', 'registration_types.name as registration_name',
            'countries.id as country_id', 'countries.name as country_name',
            'states.id as state_id', 'states.name as state_name',
            'cities.id as city_id', 'cities.name as city_name',
            'status_types.id as status_type_id', 'status_types.name as status_type_name')
            ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
            ->leftJoin('conference_years', 'conference_years.id', '=', 'user_registrations.conference_year_id')
            ->leftJoin('payment_types', 'payment_types.id', '=', 'user_registrations.payment_type_id')
            ->leftJoin('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
            ->leftJoin('countries', 'countries.id', '=', 'user_registrations.country_id')
            ->leftJoin('states', 'states.id', '=', 'user_registrations.state_id')
            ->leftJoin('cities', 'cities.id', '=', 'user_registrations.city_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
            ->where('user_registrations.id', '=', $id)
            ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $data = array(
            'page_title' => 'User Registration',
            'p_title' => 'User Registration',
            'p_summary' => 'Edit User Registration',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.conference-year.user-registration.update', [$yid->id, $record->id]),
            'url' => route('manager.conference-year.user-registration.index', $yid->id),
            'url_text' => 'View All',
            'data' => $record,
            'sdata' => $yid,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.registration.userRegistration.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param String_ $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $yid, string $id)
    {
        $yid = ConferenceYear::where('id', $yid)->first();
        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        // Find the user-registration record by $id
        $user_registration = UserRegistration::where('id', '=', $id)
            ->first();

        if (empty($user_registration)) {
            abort(404, 'NOT FOUND');
        }

        // Find the user record who has a reference in the user_registrations table
        $user = User::select('users.*')
            ->join('user_registrations', 'user_registrations.user_id', '=', 'users.id')
            ->where('user_registrations.id', '=', $id)
            ->first();

        if (!$user) {
            abort(404, 'User not found');
        }

        $this->validate($request, [
            'name' => 'required', 'string', 'max:255' . $user->id,
            'email' => 'required', 'string', 'email', 'max:255', 'unique:' . User::class . $user->id,
            'password' => Rules\Password::defaults(),
            'contact_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
            'qualification' => 'required',
            'title' => 'required',
            'payment' => 'required',
            'registration' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);


        // Check if the session is open
        $session = ConferenceYear::where('id', $yid->id)
            ->where('status', 1)->first();

        if (empty($session)) {
            // If the session is not open, show a message and redirect back
            $messages = [
                array(
                    'message' => 'Session is not active for registration. Please activate the session first',
                    'message_type' => 'error'
                ),
            ];
            Session::flash('messages', $messages);

            return redirect()->back();
        }

        //Payment Type
        $payment = PaymentType::where('payment_types.id', $request->input('payment'))->first();
        if (empty($payment)) {
            abort(404, 'NOT FOUND');
        }


        //Registration Type
        $registration = RegistrationType::where('registration_types.id', $request->input('registration'))->first();
        if (empty($registration)) {
            abort(404, 'NOT FOUND');
        }

        //Country
        $country = Country::where('countries.id', $request->input('country'))->first();
        if (empty($country)) {
            abort(404, 'NOT FOUND');
        }

        //State
        $state = State::where('states.id', '=', $request->input('state'))->first();
        if (empty($state)) {
            abort(404, 'NOT FOUND');
        }

        //City
        $city = City::where('cities.id', '=', $request->input('city'))->first();
        if (empty($city)) {
            abort(404, 'NOT FOUND');
        }

        //Registration Status
        $status_type = StatusType::where('status_types.name', 'Pending')->first();
        if (empty($status_type)) {
            abort(404, 'NOT FOUND');
        }

        // assign user module
        $module_slug = 'user';

        //Module
        $module = Module::where('modules.slug', '=', $module_slug)->first();
        if (empty($module)) {
            abort(404, 'NOT FOUND');
        }

        //Role
        $role = Role::where('roles.name', '=', 'user')->first();
        if (empty($role)) {
            abort(404, 'NOT FOUND');
        }

        $arr = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'module_id' => $module->id,
            'updated_by' => Auth::user()->id,
        ];

//        Update User
        $record = $user->update($arr);

        if ($record) {
            // If $user_registration is successfully created, proceed to store $arr1
            $user->assignRole($role->name);

            $arr1 = [
                'user_id' => $user->id,
                'qualification' => $request->input('qualification'),
                'title' => $request->input('title'),
                'contact_no' => $request->input('contact_no'),
                'conference_year_id' => $session->id,
                'payment_type_id' => $request->input('payment'),
                // 'submission_type_id' => $request->input('submission'),
                'registration_type_id' => $request->input('registration'),
                'status_type_id' => $status_type->id,
                'country_id' => $request->input('country'),
                'state_id' => $request->input('state'),
                'city_id' => $request->input('city'),
                'updated_by' => Auth::user()->id,
            ];

//            update User Registration
            $user_registration->update($arr1);

            if (!$user_registration) {
                // If $user_registration update fails, delete the $user record
                $user->delete();

                $messages = [
                    array(
                        'message' => 'Failed to create user registration record',
                        'message_type' => 'error'
                    ),
                ];
                Session::flash('messages', $messages);

                return redirect()->back();
            }

            $messages = [
                array(
                    'message' => 'Record updated successfully',
                    'message_type' => 'success'
                ),
            ];
            Session::flash('messages', $messages);
        } else {
            $messages = [
                array(
                    'message' => 'Failed to update user record',
                    'message_type' => 'error'
                ),
            ];
            Session::flash('messages', $messages);
        }

        return redirect()->route('manager.conference-year.user-registration.index', $yid->id);
    }

//    generate voucher
    public function voucher($id)
    {

        $user_registration = UserRegistration::where('id', $id)->first();
        $user = User::where('id', $user_registration->user_id)->first();
        $registration_types = RegistrationType::where('id', $user_registration->registration_type_id)
            ->orderBy('id', 'desc')
            ->first();
        $conference_years = ConferenceYear::where('id', $user_registration->conference_year_id)->first();
        $voucher = VoucherPDF::where('user_registration_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();
        if ($voucher) {
            $voucher->update(['name' => $user->name, 'email' => $user->email]);
        }
        

//        if voucher record is not stored then store record and download voucher
        if (!isset($voucher)) {
            $arr = [
                'user_id' => $user->id,
                'conference_year_id' => $conference_years->id,
                'registration_type_id' => $registration_types->id,
                'user_registration_id' => $user_registration->id,
                // 'bank_name' => 'Habib Metropolitan Bank Limited',
                'bank_name' => 'Habib Metropolitan Bank Limited',
                'branch_code' => '1208',
                'swift_code' => 'MPBLPKKA',
                // 'branch_code' => '',
                // 'swift_code' => '',
                'account_title' => 'University of Faisalabad (Amin)',
                'account_no' => '6-12-08-20311-714-100031',
                'iban_no' => 'PK32MPBL1208027140100031',
                'country_no' => 'Pakistan',
                'last_date' => '06/12/2023',
                // 'bank_name' => '',
                // 'branch_code' => '',
                // 'swift_code' => '',
                // 'account_title' => '',
                // 'account_no' => '',
                // 'iban_no' => '',
                // 'country_no' => 'Pakistan',
                // 'last_date' => '',
                'challan_no' => random_int(1000000000, 9999999999),
                'name' => $user->name,
                'email' => $user->email,
                'voucher_type' => 'cash'
            ];


            $voucherPdf = VoucherPDF::create($arr);

            if ($voucherPdf) {
                if ($user_registration->country_id == 167) {
                    $voucherHeadStore['voucher_pdf_id'] = $voucherPdf->id;
                    $voucherHeadStore['head'] = $registration_types->name;
                    $voucherHeadStore['amount'] = $registration_types->fee;
                    VoucherPDFHead::create($voucherHeadStore);
                } else {
                    $voucherHeadStore['voucher_pdf_id'] = $voucherPdf->id;
                    $voucherHeadStore['head'] = $registration_types->name;
                    $voucherHeadStore['amount'] = $registration_types->international_fee;
                    VoucherPDFHead::create($voucherHeadStore);
                }
            }
        } else {
        // dd($voucher);
            $arr = [
                'user_id' => $voucher->user_id,
                'conference_year_id' => $voucher->conference_year_id,
                'registration_type_id' => $registration_types->id,
                'user_registration_id' => $voucher->user_registration_id,
                'bank_name' => 'Habib Metropolitan Bank Limited',
                'branch_code' => '1208',
                'swift_code' => 'MPBLPKKA',
                'account_title' => 'University of Faisalabad (Amin)',
                'account_no' => '6-12-08-20311-714-100031',
                'iban_no' => 'PK32MPBL1208027140100031',
                'country_no' => 'Pakistan',
                'last_date' => '06/12/2023',
                'challan_no' => $voucher->challan_no,
                'name' => $voucher->name,
                'email' => $voucher->email,
                'voucher_type' => 'cash'
            ];

            $voucherPdf = $voucher->update($arr);
        //    dd($voucher->id);
        
           $voucherHead = VoucherPDFHead::where('voucher_pdf_id',$voucher->id)->first();
            if ($voucherPdf) {
                if ($user_registration->country_id == 167) {
                    $arr1 = [
                        'voucher_pdf_id' => $voucherHead->voucher_pdf_id,
                        'head' => $registration_types->name,
                        'amount' => $registration_types->fee
                    ];
                    $voucherHead->update($arr1);

                } else {
                    $arr1 = [
                        'voucher_pdf_id' => $voucherHead->voucher_pdf_id,
                        'head' => $registration_types->name,
                        'amount' => $registration_types->international_fee
                    ];
                    // dd($arr1);
                    $voucherHead->update($arr1);
                }
                // dd($voucherHead);
            }
          
        }

        $voucher = VoucherPDF::where('user_registration_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();
            // dd($voucher);

        $voucherHead = VoucherPDFHead::select('voucher_pdf_fee_head.*')
            ->leftjoin('voucher_pdf', 'voucher_pdf.id', '=', 'voucher_pdf_fee_head.voucher_pdf_id')
            ->where('voucher_pdf.user_registration_id', $id)->get();
            // dd($voucherHead);

        $grand_total = 0;
        foreach ($voucherHead as $total_amount) {
            $grand_total += $total_amount->amount;
        }
        $amount_words = $this->numberToWord($grand_total);
         // dd($voucherHead);
        $pdf = PDF::loadView('pdf.voucher', compact('voucher', 'voucherHead', 'grand_total', 'amount_words', 'user_registration'));
        $pdf->setPaper('A4', 'landscape');
        $name = $voucher->name;
        return $pdf->download("$name-" . $voucher->id . '.pdf');

    }

    public function upload(Request $request, $yid, $id)
    {
        $yid = ConferenceYear::where('id', '=', $yid)->where('status', 1)->first();

        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        $user_registration = UserRegistration::findOrFail($id);

        try {
            $this->validate($request, [
                'voucher_upload' => 'required|mimes:jpg,png,jpeg,pdf',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $messages = [
                [
                    'message' => 'Only .pdf, .jpg, .png, .jpeg format are allowed.',
                    'message_type' => 'error'
                ]
            ];

            return redirect()->back()->with('messages', $messages);
        }

        $uploadedFile = $request->file('voucher_upload');
        $uploadedFileOriginalName = $uploadedFile->getClientOriginalName();
        $fileName = pathinfo($uploadedFileOriginalName, PATHINFO_FILENAME);
        $extension = $request->file('voucher_upload')->extension();
        $folderPath = 'user/voucher/';
        $filename = date('Y') . '/' . date('m') . '/' . date('d') . '/' . time() . '-' . rand(0, 999999) . $fileName . '.' . $extension;
        $file = $folderPath . $filename;
        Storage::disk('private')->put($file, file_get_contents($uploadedFile->getRealPath()));

        $arr = [
            'voucher_upload' => $filename,
            'updated_by' => Auth::user()->id,
            'sdata' => $yid,
        ];

        $user_registration['status_type_id'] = 1;
        $user_registration->update($arr);
        $messages = [
            array(
                'message' => 'Voucher Uploaded successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.conference-year.user-registration.index', $yid->id);

    }

    public function gatePass($id)
    {
        $user_registration = UserRegistration::where('id', $id)->first();
        $user = User::where('id', $user_registration->user_id)->first();
        $registration_type = RegistrationType::where('id',$user_registration->registration_type_id)->first();
        $venue = Venue::Where('conference_year_id', $user_registration->conference_year_id)->first();
        // dd($venue);
        $usersCount = User::where('id', $user_registration->user_id)->where('name', '!=', '')->count();
        // dd($user_registration);
        $pdf = PDF::loadView('pdf.gate_pass', compact('user_registration', 'user', 'usersCount','venue','registration_type'));
        $pdf->setPaper('A4', 'portrait');
        $name = $user->name;
        return $pdf->download("$name-" . $user_registration->id . '.pdf');
    }

    public function GetGatePass($id)
    {
        $user_registration = UserRegistration::where('id', $id)->first();
        
        $user = User::where('id', $user_registration->user_id)->first();
        $usersCount = User::where('id', $user_registration->user_id)->where('name', '!=', '')->count();
        $pdf = PDF::loadView('pdf.gate_pass', compact('user_registration', 'user', 'usersCount'));
        $pdf->setPaper('A4', 'landscape');
        $name = $user->name;
        Storage::disk('private')->put('user/gatePass/' . $name . '-' . $user_registration->id . '.pdf', $pdf->download("$name-" . $user_registration->id . '.pdf'));
    }
    public function certificate($id)
    {

        $user_registration = UserRegistration::where('id', $id)->first();
        $user = User::where('id', $user_registration->user_id)->first();

        $sessions = ConferenceYear::where('id', $user_registration->conference_year_id)->first();

        $certificate = CertificatePDF::where('user_registration_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();


//        if certificate record is not stored then store record and download certificate
        if (!isset($certificate)) {
            $arr = [
                'user_id' => $user->id,
                'user_registration_id' => $user_registration->id,
                'conference_year_id' => $sessions->id,
                'issue_date' => '12/07/2023',
                'start_date' => '12/05/2023',
                'end_date' => '12/06/2023',
                'title' => $user_registration->title,
                'name' => $user->name,
                'event_name' => '1st International Conference on Advance STEAM Education',
                'venue' => 'The University of Faisalabad',
            ];

            CertificatePDF::create($arr);

        } else {

            $arr = [
                'user_id' => $user->id,
                'user_registration_id' => $user_registration->id,
                'conference_year_id' => $sessions->id,
                'issue_date' => '12/07/2023',
                'start_date' => '12/05/2023',
                'end_date' => '12/06/2023',
                'title' => $user_registration->title,
                'name' => $user->name,
                'event_name' => '1st International Conference on Advance STEAM Education',
                'venue' => 'The University of Faisalabad',
            ];

            $certificate->update($arr);
        }

        $certificate = CertificatePDF::where('user_registration_id', $id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->first();

        
        $pdf = PDF::loadView('pdf.certificate', compact('certificate',  'user_registration'));
        $pdf->setPaper('A4', 'landscape');
        $name = $certificate->name;
        Storage::disk('private')->put('user/certificate/' . $name . '-' . $user_registration->id . '.pdf', $pdf->download("$name-" . $user_registration->id . '.pdf'));
        return $pdf->download("$name-" . $certificate->id . '.pdf');

    }

    public
    function numberToWord($num = '')
    {
        $num = ( string )(( int )$num);

        if (( int )($num) && ctype_digit($num)) {
            $words = array();

            $num = str_replace(array(',', ' '), '', trim($num));

            $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
                'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
                'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');

            $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
                'seventy', 'eighty', 'ninety', 'hundred');

            $list3 = array('', 'thousand', 'million', 'billion', 'trillion',
                'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion',
                'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion',
                'octodecillion', 'novemdecillion', 'vigintillion');

            $num_length = strlen($num);
            $levels = ( int )(($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds = ( int )($num_part / 100);
                $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
                $tens = ( int )($num_part % 100);
                $singles = '';

                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                } else {
                    $tens = ( int )($tens / 10);
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = ( int )($num_part % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . (($levels && ( int )($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words = implode(', ', $words);

            $words = trim(str_replace(' ,', ',', ucwords($words)), ', ');
            if ($commas) {
                $words = str_replace(',', ' and', $words);
            }

            return $words;
        } else if (!(( int )$num)) {
            return 'Zero';
        }
        return '';
    }

    /**
     * Show the form for editing the specified resource.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public
    function editStatus(string $yid, string $id)
    {
        $yid = ConferenceYear::where('id', '=', $yid)
            ->first();

        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }
        $record = UserRegistration::select('user_registrations.*', 'status_types.id as status_type_id', 'status_types.name as status_type_name')
            ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
            ->where('user_registrations.id', '=', $id)
            ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $data = array(
            'page_title' => 'Registration Status',
            'p_title' => 'Registration Status',
            'p_summary' => 'Edit Status',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.get.user-registration-update-status', [$yid->id, $record->id]),
            'url' => route('manager.conference-year.user-registration.index', $yid->id),
            'url_text' => 'View All',
            'data' => $record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.registration.userRegistration.status')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param String_ $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function updateStatus(Request $request, $yid, string $id)
    {
        // Find the session record by $yid
        $yid = ConferenceYear::where('id', $yid)->first();
        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        $record = UserRegistration::select('user_registrations.*', 'status_types.id as status_type_id', 'status_types.name as status_type_name')
            ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
            ->where('user_registrations.id', '=', $id)
            ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        $user = User::where('id', $record->user_id)->first();

        if (empty($user)) {
            abort(404, 'NOT FOUND');
        }


        $this->validate($request, [
            'status-type' => 'required',
        ]);
//        dd("arr");
        $arr = [
            'status_type_id' => $request->input('status-type'),
        ];



        if ($record && $request->input('status-type') == 2) {
            if (empty($record->voucher_upload)) {
                $messages = [
                    array(
                        'message' => 'Upload the voucher first',
                        'message_type' => 'info'
                    ),
                ];
                Session::flash('messages', $messages);
            }
            $this->GetGatePass($record->id);
            $pdfName = $user->name . '-' . $record->id;
            $attachFiles = [storage_path('app/private/user/gatePass/' . $pdfName . '.pdf')];
            $items = [];
            $sender = config('mail.from.address');
            $receiver = $user->email;
            array_push($items, $sender);
            Mail::send('emails.register_approval_email', array(
                'name' => $user->name,
            ), function ($message) use ($attachFiles, $receiver, $sender) {
                $message->from($sender)->to($receiver)->subject('Registration Approved');
                foreach ($attachFiles as $file) {
                    $message->attach($file);
                }
            });

            $record->update($arr);
            $delImage = storage_path('app/private/user/gatePass/' . $pdfName . '.pdf');
            File::delete($delImage);

            $messages = [
                array(
                    'message' => 'Email Send to the Candidate',
                    'message_type' => 'success'
                ),
            ];
        } else if ($record && $request->input('status-type') == 3) {
            $items = [];
            $sender = config('mail.from.address');
            $receiver = $user->email;
            array_push($items, $sender);
            Mail::send('emails.register_rejected_email', array(
                'name' => $user->name,
            ), function ($message) use ($receiver, $sender) {
                $message->from($sender)->to($receiver)->subject('Registration Rejected');
            });

            $record->update($arr);

            $messages = [
                array(
                    'message' => 'Email Send to the Candidate',
                    'message_type' => 'success'
                ),
            ];
        } else {
            $record->update($arr);

            $messages = [
                array(
                    'message' => 'Record updated successfully',
                    'message_type' => 'success'
                ),
            ];
        }

        Session::flash('messages', $messages);
        return redirect()->route('manager.conference-year.user-registration.index', $yid->id);
    }


    /**
     * Remove the specified resource from storage.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($yid, string $id)
    {
        // Find the session record by $yid
        $yid = ConferenceYear::where('id', $yid)->first();
        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        // get user-registration record
        $record = UserRegistration::select('user_registrations.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        // Find the user record who has a reference in the user_registrations table
        $user = User::select('users.*')
            ->join('user_registrations', 'user_registrations.user_id', '=', 'users.id')
            ->where('user_registrations.id', '=', $id)
            ->first();

        if (!$user) {
            abort(404, 'User not found');
        }
        $record->delete();
        $user->delete();

        $messages = [
            array(
                'message' => 'Record deleted successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.conference-year.user-registration.index', $yid->id);
    }

    /**
     * Display the specified resource Activity.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public
    function getActivity(string $yid, string $id)
    {
        $yid = ConferenceYear::where('id', '=', $yid)
            ->first();

        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }
        //Data Array
        $data = array(
            'page_title' => 'User Registration Activity',
            'p_title' => 'User Registration Activity',
            'p_summary' => 'Show User Registration Activity',
            'p_description' => null,
            'url' => route('manager.conference-year.user-registration.index', $yid->id),
            'url_text' => 'View All',
            'id' => $id,
        );
        return view('manager.registration.userRegistration.activity')->with($data);
    }

    /**
     * Display the specified resource Activity Logs.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public
    function getActivityLog(Request $request, string $id)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('user_registrations', 'user_registrations.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', UserRegistration::class)
            ->where('activity_log.subject_id', $id)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('user_registrations', 'user_registrations.id', 'activity_log.subject_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', UserRegistration::class)
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('user_registrations', 'user_registrations.id', 'activity_log.subject_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', UserRegistration::class)
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();


        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $attributes = (!empty($record->properties['attributes']) ? $record->properties['attributes'] : '');
            $old = (!empty($record->properties['old']) ? $record->properties['old'] : '');
            $current = '<ul class="list-unstyled">';
            //Current
            if (!empty($attributes)) {
                foreach ($attributes as $key => $value) {
                    if (is_array($value)) {
                        $current .= '<li>';
                        $current .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $current .= '</li>';
                    } else {
                        $current .= '<li>';
                        $current .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $current .= '</li>';
                    }
                }
            }
            $current .= '</ul>';
            //Old
            $oldValue = '<ul class="list-unstyled">';
            if (!empty($old)) {
                foreach ($old as $key => $value) {
                    if (is_array($value)) {
                        $oldValue .= '<li>';
                        $oldValue .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $oldValue .= '</li>';
                    } else {
                        $oldValue .= '<li>';
                        $oldValue .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $oldValue .= '</li>';
                    }
                }
            }
            //updated at
            $updated = 'Updated:' . $record->updated_at->diffForHumans() . '<br> At:' . $record->updated_at->isoFormat('llll');
            $oldValue .= '</ul>';
            //Causer
            $causer = isset($record->causer) ? $record->causer : '';
            $type = $record->description;
            $data_arr[] = array(
                "id" => $id,
                "current" => $current,
                "old" => $oldValue,
                "updated" => $updated,
                "causer" => $causer,
                "type" => $type,
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }

    /**
     * Display the trash resource Activity.
     * @return \Illuminate\Http\Response
     */
    public
    function getTrashActivity(string $yid)
    {
        $yid = ConferenceYear::where('id', '=', $yid)
            ->first();

        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }
        //Data Array
        $data = array(
            'page_title' => 'User Registration Activity',
            'p_title' => 'User Registration Activity',
            'p_summary' => 'Show User Registration Trashed Activity',
            'p_description' => null,
            'url' => route('manager.conference-year.user-registration.index', $yid->id),
            'url_text' => 'View All',
        );
        return view('manager.registration.userRegistration.trash')->with($data);
    }

    /**
     * Display the trash resource Activity Logs.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public
    function getTrashActivityLog(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('user_registrations', 'user_registrations.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', UserRegistration::class)
            ->where('activity_log.event', 'deleted')
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('user_registrations', 'user_registrations.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', UserRegistration::class)
            ->where('activity_log.event', 'deleted')
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('user_registrations', 'user_registrations.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', UserRegistration::class)
            ->where('activity_log.event', 'deleted')
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();


        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $attributes = (!empty($record->properties['attributes']) ? $record->properties['attributes'] : '');
            $old = (!empty($record->properties['old']) ? $record->properties['old'] : '');
            $current = '<ul class="list-unstyled">';
            //Current
            if (!empty($attributes)) {
                foreach ($attributes as $key => $value) {
                    if (is_array($value)) {
                        $current .= '<li>';
                        $current .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $current .= '</li>';
                    } else {
                        $current .= '<li>';
                        $current .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $current .= '</li>';
                    }
                }
            }
            $current .= '</ul>';
            //Old
            $oldValue = '<ul class="list-unstyled">';
            if (!empty($old)) {
                foreach ($old as $key => $value) {
                    if (is_array($value)) {
                        $oldValue .= '<li>';
                        $oldValue .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $oldValue .= '</li>';
                    } else {
                        $oldValue .= '<li>';
                        $oldValue .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $oldValue .= '</li>';
                    }
                }
            }
            //updated at
            $updated = 'Updated:' . $record->updated_at->diffForHumans() . '<br> At:' . $record->updated_at->isoFormat('llll');
            $oldValue .= '</ul>';
            //Causer
            $causer = isset($record->causer) ? $record->causer : '';
            $type = $record->description;
            $data_arr[] = array(
                "id" => $id,
                "current" => $current,
                "old" => $oldValue,
                "updated" => $updated,
                "causer" => $causer,
                "type" => $type,
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }


    public function getImage($id)
    {
        $record = UserRegistration::where('id', '=', $id)->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        $path = Storage::disk('private')->path('user/voucher/' . $record->voucher_upload);
        if (File::exists($path)) {
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        } else {
            abort(404, 'NOT FOUND');
        }

    }

    public
    function editCertificateStatus(Request $request,string $yid, string $id)
    {
        $yid = ConferenceYear::where('id', '=', $yid)->first();

    if (empty($yid)) {
        abort(404, 'Conference Year Not Found');
    }

    $record = UserRegistration::find($id);

    if (empty($record)) {
        abort(404, 'Registration NOT FOUND');
    }

    if ($request->isMethod('POST')) {
        // Handle the form submission and update the attendee status
        $newStatus = $request->input('attendee_status');
        // Assuming you have a 'status' field in your 'user_registrations' table
        $record->update(['attendee_status' => $newStatus]);

        // Redirect back to the index page
        return redirect()->route('manager.session.user-registration.index', $sid->id);
    }

    $data = array(
        'page_title' => 'Registration Certificate Status',
        'p_title' => 'Registration Certificate Status',
        'p_summary' => 'Edit Certificate Status',
        'p_description' => null,
        'method' => 'POST',
        'action' => route('manager.get.user-registration-update-certificate-status', [$yid->id, $record->id]),
        'url' => route('manager.conference-year.user-registration.index', $yid->id),
        'url_text' => 'View All',
        'data' => $record,
        'enctype' => 'application/x-www-form-urlencoded',
    );

    return view('manager.registration.userRegistration.attendee')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param String_ $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function updateCertificateStatus(Request $request, $yid, string $id)
    {
      // Find the session record by $yid
    $yid = ConferenceYear::where('id', $yid)->first();
    if (empty($yid)) {
        abort(404, 'Conference Year Not Found');
    }

    $record = UserRegistration::find($id);

    if (empty($record)) {
        abort(404, 'Registration NOT FOUND');
    }
    $user = User::where('id', $record->user_id)->first();

    if (empty($user)) {
        abort(404, 'NOT FOUND');
    }

    // Validate the request
    $this->validate($request, [
        'attendee_status' => 'required',
    ]);

    $newStatus = $request->input('attendee_status');
    $record->attendee_status = $newStatus;

    $this->certificate($record->id);
    $pdfName = $user->name . '-' . $record->id;
    $attachFiles = [storage_path('app/private/user/certificate/' . $pdfName . '.pdf')];
    $items = [];
    $sender = config('mail.from.address');
    $receiver = $user->email;
    array_push($items, $sender);
    Mail::send('emails.attendee_email', array(
        'name' => $user->name,
    ), function ($message) use ($attachFiles, $receiver, $sender) {
        $message->from($sender)->to($receiver)->subject('Conference Certificate');
        foreach ($attachFiles as $file) {
            $message->attach($file);
        }
    });


//     if ($record && $request->input('attendee_status') == 0) {
//         if (empty($record->vattendee_status)) {
//             $messages = [
//                 array(
//                     'message' => 'Candidate is not present.',
//                     'message_type' => 'info'
//                 ),
//             ];
//             Session::flash('messages', $messages);
//         }
//     $this->GetCertificate($record->id);
//     $pdfName = $user->name . '-' . $record->id;
//     $attachFiles = [storage_path('app/private/user/certificate/' . $pdfName . '.pdf')];
//     $items = [];
//     $sender = config('mail.from.address');
//     $receiver = $user->email;
//     array_push($items, $sender);
//     Mail::send('emails.register_approval_email', array(
//         'name' => $user->name,
//     ), function ($message) use ($attachFiles, $receiver, $sender) {
//         $message->from($sender)->to($receiver)->subject('Registration Approved');
//         foreach ($attachFiles as $file) {
//             $message->attach($file);
//         }
//     });

//     $record->update($arr);
//     $delImage = storage_path('app/private/user/gatePass/' . $pdfName . '.pdf');
//     File::delete($delImage);

//     $messages = [
//         array(
//             'message' => 'Email Send to the Candidate',
//             'message_type' => 'success'
//         ),
//     ];
//    } else if ($record && $request->input('attendee_status') == 3) {
//     $items = [];
//     $sender = config('mail.from.address');
//     $receiver = $user->email;
//     array_push($items, $sender);
//     Mail::send('emails.register_rejected_email', array(
//         'name' => $user->name,
//     ), function ($message) use ($receiver, $sender) {
//         $message->from($sender)->to($receiver)->subject('Registration Rejected');
//     })};


    $record->save();

    // Redirect back to the index page
    return redirect()->route('manager.conference-year.user-registration.index', $yid->id);
    }

}