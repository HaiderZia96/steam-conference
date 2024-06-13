<?php

namespace App\Http\Controllers\Manager\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CandidateAttendance;
use App\Models\UserRegistration;
use App\Models\ConferenceYear;
use App\Models\RegistrationType;
use App\Models\StatusType;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:manager_reports_candidate-detail', ['only' => ['candidateDetail', 'getCandidateDetail']]);
       

    }

    public function candidateDetail(Request $request, $yid)
    {
        $session = ConferenceYear::where('id', $yid)->first();
       

        if (empty($session)) {
            abort(404, 'NOT FOUND');
        }
        $registration_types = RegistrationType::get();
        $status_types = StatusType::get();
        $qualification = UserRegistration::groupBy('qualification')->get();
        // $fees = UserRegistration::pluck('voucher_upload');
        // dd($qualification);
        //Data Array
        $data = array(
            'page_title' => 'User Registration',
            'p_title' => 'User Registration',
            'p_summary' => 'List of User Registration',
            'p_description' => null,
            'url' => '',
            'session' => $session,
            'registration_types' => $registration_types,
            'status_types' => $status_types,
            'qualification' => $qualification,
            // 'fees' => $fees,
        );
        return view('manager.reports.candidate-detail')->with($data);
    }

    public function getCandidateDetail(Request $request, $yid)
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
 
          // Register -- Not Register
        //   if (!empty($request->get('qualification'))) {
        //     $var = ['user_registrations.qualification', '=', $request->get('qualification')];
        //     array_push($where, $var);
        // }
        if (!empty($request->get('qualification'))) {
            $qualification = $request->get('qualification');
            $var = ['user_registrations.qualification', '=', $qualification];
            array_push($where, $var);
            // dd($payment_type);
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
            //  dd($records);
 
         $data_arr = array();
 
         foreach ($records as $record) {
             $id = $record->id;
             $name = $record->name;
             $email = $record->email;
             $qualification = $record->qualification;
             $contact_no = $record->contact_no;
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
                 "contact_no" => $contact_no,
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

    public function getRegisterCandidate(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = UserRegistration::select('candidate_registrations.id as id', 'candidate_registrations.name as name', 'candidate_registrations.reg_no as reg_no')
                ->where(function ($q) use ($search) {
                    $q->where('candidate_registrations.name', 'like', '%' . $search . '%')
                        ->orWhere('candidate_registrations.reg_no', 'like', '%' . $search . '%');
                })
                ->get();
        }
        return response()->json($data);
    }

   

    public function CandidateEntrance(Request $request, $yid)
    {

        $in_out = $request->input('in_out');
        $candidate_id = $request->input('candidate_id');
        $registerCan = '';
        if (!empty($candidate_id)) {
            $registerCan = UserRegistration::where('id', $candidate_id)->first();
        }

        $session = ConferenceYear::where('id', $yid)->first();
        $data = [
            'page_title' => 'Reports',
            's_title' => $session->title,
            'p_title' => "Reports",
            'p_summary' => 'Candidate Entrance',
            'p_description' => null,
            'url' => '',
            'session' => $session,
            'candidate_id' => $candidate_id,
            'registerCan' => $registerCan,
            'in_out' => $in_out,

        ];
        return view('manager.reports.candidate-entrance')->with($data);
    }

    public function getCandidateEntrance(Request $request, $yid)
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

        $where = [];
        // Candidate
        if (!is_null($request->get('in_out'))) {
            $in_out = $request->get('in_out');
            $var = ['candidate_attendances.in_out', 'like', '%' . $in_out . '%'];
            array_push($where, $var);
        }
        // Candidate
        if (!empty($request->get('candidate_id'))) {
            $candidate_id = $request->get('candidate_id');
            $var = ['candidate_attendances.candidate_id', '=', $candidate_id];
            array_push($where, $var);
        }

        // Total records
        $totalRecords = CandidateAttendance::select('count(*) as allcount')
            ->where('candidate_attendances.session_id', $yid)
            ->leftJoin('candidate_registrations', 'candidate_registrations.id', '=', 'candidate_attendances.candidate_id')
            ->where($where)
            ->where(function ($q) use ($searchValue) {
                $q->where('candidate_registrations.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('candidate_registrations.reg_no', 'like', '%' . $searchValue . '%');
            })
            ->orderBy('id', 'DESC')
            ->count();
        // Total records with filter
        $totalRecordswithFilter = CandidateAttendance::select('count(*) as allcount')
            ->where('candidate_attendances.session_id', $yid)
            ->leftJoin('candidate_registrations', 'candidate_registrations.id', '=', 'candidate_attendances.candidate_id')
            ->where($where)
            ->where(function ($q) use ($searchValue) {
                $q->where('candidate_registrations.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('candidate_registrations.reg_no', 'like', '%' . $searchValue . '%');
            })
            ->orderBy('id', 'DESC')
            ->count();
        // Total records
        $records = CandidateAttendance::orderBy($columnName, $columnSortOrder)
            ->where('candidate_attendances.session_id', $yid)
            ->leftJoin('candidate_registrations', 'candidate_registrations.id', '=', 'candidate_attendances.candidate_id')
            ->where($where)
            ->where(function ($q) use ($searchValue) {
                $q->where('candidate_registrations.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('candidate_registrations.reg_no', 'like', '%' . $searchValue . '%');
            })
            ->select('candidate_attendances.*')
            ->orderBy('id', 'DESC')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $name = $record->candidate->name;
            $reg_no = $record->candidate->reg_no;
            $email = $record->candidate->email;
            if ($record->in_out == 0) {
                $in_out = 'Out';
            } else {
                $in_out = 'In';
            }
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "reg_no" => $reg_no,
                "email" => $email,
                "in_out" => $in_out,

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

   

    public function registrationDetail(Request $request, $yid)
    {

        $session = ConferenceYear::where('id', $yid)->first();
       

        if (empty($session)) {
            abort(404, 'NOT FOUND');
        }
        $registration_types = RegistrationType::get();
        $status_types = StatusType::get();
        $qualification = UserRegistration::groupBy('qualification')->get();
  
        // $fees = UserRegistration::pluck('voucher_upload');
        // dd($qualification);
        //Data Array
        $data = array(
            'page_title' => 'User Registration',
            'p_title' => 'User Registration',
            'p_summary' => 'List of User Registration',
            'p_description' => null,
            'url' => '',
            'session' => $session,
            'registration_types' => $registration_types,
            'status_types' => $status_types,
            'qualification' => $qualification,
            // 'fees' => $fees,
        );
        return view('manager.reports.registration')->with($data);
    }

    public function getRegistrationDetail(Request $request, $yid)
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

        // Register -- Not Register
      //   if (!empty($request->get('qualification'))) {
      //     $var = ['user_registrations.qualification', '=', $request->get('qualification')];
      //     array_push($where, $var);
      // }
      if (!empty($request->get('qualification'))) {
          $qualification = $request->get('qualification');
          $var = ['user_registrations.qualification', '=', $qualification];
          array_push($where, $var);
          // dd($payment_type);
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

      // Total records Old
// $totalRecords = UserRegistration::select(
//     'user_registrations.*',
//     'users.name as name',
//     'users.email as email',
//     'registration_types.name as registration_type_name',
//     'status_types.name as status_type_name',
//     'conference_years.name as conference_year_name',
//     DB::raw('(SELECT COUNT(*) FROM user_registrations WHERE user_registrations.qualification = user_registrations.qualification) AS total_register_candidate')
// )
//     ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
//     ->leftJoin('conference_years', 'conference_years.id', '=', 'user_registrations.conference_year_id')
//     ->leftJoin('payment_types', 'payment_types.id', '=', 'user_registrations.payment_type_id')
//     ->leftJoin('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
//     ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
//     ->where($where)
//     ->groupBy('user_registrations.qualification')
//     ->count();

       // Total records New
    $CountTotalRecords =  DB::select("SELECT 'user_registrations.*', 'users.name as name', 'users.email as email',
    'registration_types.name as registration_type_name',
    'status_types.name as status_type_name', 'conference_years.name as conference_year_name',
    (SELECT COUNT(*) FROM user_registrations) AS total_register_candidate
    FROM user_registrations
    WHERE  qualification is not null
    AND user_registrations.conference_year_id = $yid
    GROUP by user_registrations.qualification");
    $totalRecords = count($CountTotalRecords);
    // dd($totalRecords);
         
    //    Total records with filter old
    //    $totalRecordswithFilter = UserRegistration::select('user_registrations.*', 'users.name as name', 'users.email as email',
    //        'registration_types.name as registration_type_name',
    //        'status_types.name as status_type_name', 'conference_years.name as conference_year_name',
    //        DB::raw('COUNT(*) as total_register_candidate'))
    //        ->leftJoin('users', 'users.id', '=', 'user_registrations.user_id')
    //        ->leftJoin('conference_years', 'conference_years.id', '=', 'user_registrations.conference_year_id')
    //        ->leftJoin('payment_types', 'payment_types.id', '=', 'user_registrations.payment_type_id')
    //        ->leftJoin('registration_types', 'registration_types.id', '=', 'user_registrations.registration_type_id')
    //        ->leftJoin('status_types', 'status_types.id', '=', 'user_registrations.status_type_id')
    //        ->where($where)
    //        ->where(function ($q) use ($searchValue) {
    //            $q->where('users.name', 'like', '%' . $searchValue . '%')
    //                ->orWhere('users.email', 'like', '%' . $searchValue . '%')
    //                ->orWhere('conference_years.name', 'like', '%' . $searchValue . '%');
    //        })
    //        ->count();


         // Total records with filter New
         $CountTotalRecordswithFilter = DB::select("SELECT 'user_registrations.*', 'users.name as name', 'users.email as email',
         'registration_types.name as registration_type_name',
         'status_types.name as status_type_name', 'conference_years.name as conference_year_name',
         (SELECT COUNT(*) FROM user_registrations) AS total_register_candidate
         FROM user_registrations
         WHERE  qualification is not null
         AND user_registrations.conference_year_id = $yid
        
         GROUP by user_registrations.qualification");
        $totalRecordswithFilter = count($CountTotalRecordswithFilter);
        // dd($totalRecordswithFilter);

       // Fetch records
       $records = UserRegistration::select('user_registrations.*', 'users.name as name', 'users.email as email',
           'registration_types.name as registration_type_name',
           'status_types.name as status_type_name', 'conference_years.name as conference_year_name', 'payment_types.name as payment_type_name',
           DB::raw('COUNT(*) as total_register_candidate'))
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
           ->groupBy('user_registrations.qualification') 
           ->get();
        //    dd($records);

       $data_arr = array();

       foreach ($records as $record) {
           $id = $record->id;
           $name = $record->name;
           $email = $record->email;
           $qualification = $record->qualification;
           $contact_no = $record->contact_no;
           $conference_year_name = $record->conference_year_name;
           $registration_type_name = $record->registration_type_name;
           $payment_type_name = $record->payment_type_name;
           $status_type_name = $record->status_type_name;
           $voucher_upload = $record->voucher_upload;
           $attendee_status = $record->attendee_status;
           $status = User::where('id',$record->user_id )->pluck('status')->first();
           $user_id = $record->user_id;
           $register_candidate = $record->total_register_candidate;
// dd($status);

           $data_arr[] = array(
               "id" => $id,
               "name" => $name,
               "email" => $email,
               "qualification" => $qualification,
               "contact_no" => $contact_no,
               "conference_year_name" => $conference_year_name,
//                "module_name" => $module_name,
               "registration_type_name" => $registration_type_name,
               "status_type_name" => $status_type_name,
               "voucher_upload" => $voucher_upload,
               "payment_type_name" => $payment_type_name,
               "attendee_status" => $attendee_status,
               "status" => $status,
               "user_id" => $user_id,
               "register_candidate" => $register_candidate,
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
}
