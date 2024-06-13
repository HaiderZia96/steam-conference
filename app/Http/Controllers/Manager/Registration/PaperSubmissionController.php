<?php

namespace App\Http\Controllers\Manager\Registration;

use App\Http\Controllers\Controller;
use App\Models\ConferenceYear;
use App\Models\PaperSubmission;
use App\Models\StatusType;
use App\Models\User;
use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class PaperSubmissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:manager_registration_paper-submission-list', ['only' => ['index', 'getIndex']]);
        $this->middleware('permission:manager_registration_paper-submission-activity-log', ['only' => ['getActivity', 'getActivityLog']]);
        $this->middleware('permission:manager_registration_paper-submission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:manager_registration_paper-submission-show', ['only' => ['show']]);
        $this->middleware('permission:manager_registration_paper-submission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:manager_registration_paper-submission-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($yid, $uid)
    {
        $yid = ConferenceYear::where('id', $yid)->first();
        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        $uid = UserRegistration::where('id', $uid)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        $data = [
            'page_title' => 'Paper Submission',
            'p_title' => 'Paper Submission',
            'p_summary' => 'List of Paper Submission',
            'p_description' => null,
            'url' => route('manager.conference-year.user-registration.paper-submission.create', [$yid->id, $uid->id]),
            'url_text' => 'Add New',
            'trash' => route('manager.get.paper-submission-activity-trash', [$yid->id, $uid->id]),
            'trash_text' => 'View Trash',
            'sdata' => $yid->id,
            'udata' => $uid->id,
        ];
        return view('manager.registration.paperSubmission.index')->with($data);
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
            $var = ['paper_submissions.user_id', '=', $user];
            array_push($where, $var);
        }

        if (!empty($request->get('user_registration_id'))) {
            $user_registration = $request->get('user_registration_id');
            $var = ['paper_submissions.user_registration_id', '=', $user_registration];
            array_push($where, $var);
        }

        if (!empty($request->get('status_type_id'))) {
            $status_type = $request->get('status_type_id');
            $var = ['paper_submissions.status_type_id', '=', $status_type];
            array_push($where, $var);
        }

        // Add a condition to filter based on 'user_registration_id'
        if (!empty($request->get('uid'))) {
            $uid = $request->get('uid');
            $var = ['paper_submissions.user_registration_id', '=', $uid];
            array_push($where, $var);
        }

        // Total records
        $totalRecords = PaperSubmission::select('paper_submissions.*', 'users.name as name', 'users.email as email',
            'user_registrations.contact_no as contact_no', 'status_types.name as status_type_name')
            ->leftJoin('users', 'users.id', '=', 'paper_submissions.user_id')
            ->leftJoin('user_registrations', 'user_registrations.id', '=', 'paper_submissions.user_registration_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'paper_submissions.status_type_id')
            ->where($where)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = PaperSubmission::select('paper_submissions.*', 'users.name as name', 'users.email as email',
            'user_registrations.contact_no as contact_no', 'status_types.name as status_type_name')
            ->leftJoin('users', 'users.id', '=', 'paper_submissions.user_id')
            ->leftJoin('user_registrations', 'user_registrations.id', '=', 'paper_submissions.user_registration_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'paper_submissions.status_type_id')
            ->where($where)
            ->where(function ($q) use ($searchValue) {
                $q->where('users.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.email', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = PaperSubmission::select('paper_submissions.*', 'users.name as name', 'users.email as email',
            'user_registrations.contact_no as contact_no', 'status_types.name as status_type_name')
            ->leftJoin('users', 'users.id', '=', 'paper_submissions.user_id')
            ->leftJoin('user_registrations', 'user_registrations.id', '=', 'paper_submissions.user_registration_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'paper_submissions.status_type_id')
            ->where($where)
            ->where(function ($q) use ($searchValue) {
                $q->where('users.name', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.email', 'like', '%' . $searchValue . '%');
            })
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $name = $record->name;
            $email = $record->email;
            $contact_no = $record->contact_no;
            $status_type_name = $record->status_type_name;

            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "contact_no" => $contact_no,
                "status_type_name" => $status_type_name,

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
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getIndexSelect(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = PaperSubmission::select('paper_submissions.id as id', 'paper_submissions.name as name')
                ->where(function ($q) use ($search) {
                    $q->where('paper_submissions.name', 'like', '%' . $search . '%');
                })
                ->get();
        }

        return response()->json($data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($yid, $uid)
    {

        $yid = ConferenceYear::where('id', $yid)->first();
        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        $uid = UserRegistration::where('id', $uid)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }
        $data = array(
            'page_title' => 'Paper Submission',
            'p_title' => 'Paper Submission',
            'p_summary' => 'Add Paper Submission',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.conference-year.user-registration.paper-submission.store', [$yid->id, $uid->id]),
            'url' => route('manager.conference-year.user-registration.paper-submission.index', [$yid->id, $uid->id]),
            'url_text' => 'View All',
            'enctype' => 'multipart/form-data' // (Default)Without attachment
//            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.registration.paperSubmission.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $yid, $uid)
    {
        $yid = ConferenceYear::where('id', $yid)->first();
        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        $uid = UserRegistration::where('id', $uid)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        $userid = User::select('users.*')
            ->leftJoin('user_registrations', 'user_registrations.user_id', '=', 'users.id')
            ->where('users.id', $uid->user_id)->first();
        if (empty($userid)) {
            abort(404, 'NOT FOUND');
        }


        $this->validate($request, [
            'file' => 'required|mimes:pdf,docx|max:1024',
        ]);

        //Registration Status
        $status_type = StatusType::where('status_types.slug', 'pending')->first();
        if (empty($status_type)) {
            abort(404, 'NOT FOUND');
        }

        $arr = [
            'user_id' => $userid->id,
            'user_registration_id' => $uid->id,
            'status_type_id' => $status_type->id,
            'created_by' => Auth::user()->id,
        ];

        $uploadedFile = $request->file('file');
        $fileOriginalName = $uploadedFile->getClientOriginalName();
        $fileName = pathinfo($fileOriginalName, PATHINFO_FILENAME);
        $extension = $request->file->extension();
        $folderPath = 'user/abstract/';
        
        $filename = date('Y') . '/' . date('m') . '/' . date('d') . '/' . time() . '-' . rand(0, 999999) . $fileName . '.' . $extension;
        $file = $folderPath . $filename;
        Storage::disk('private')->put($file, file_get_contents($uploadedFile->getRealPath()));
        $arr['file'] = $filename;
        PaperSubmission::create($arr);


        $messages = [
            array(
                'message' => 'Record created successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.conference-year.user-registration.paper-submission.index', [$yid->id, $uid->id]);
    }

    /**
     * Display the specified resource.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function show($yid, $uid, string $id)
    {
        $yid = ConferenceYear::where('id', '=', $yid)
            ->first();

        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        $uid = UserRegistration::where('id', '=', $uid)
            ->first();

        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        $record = PaperSubmission::select('paper_submissions.*', 'users.name as name', 'users.email as email',
            'user_registrations.contact_no as contact_no', 'status_types.id as status_type_id', 'status_types.name as status_type_name')
            ->leftJoin('users', 'users.id', '=', 'paper_submissions.user_id')
            ->leftJoin('user_registrations', 'user_registrations.id', '=', 'paper_submissions.user_registration_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'paper_submissions.status_type_id')
            ->where('paper_submissions.id', '=', $id)
            ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        $userRecord = PaperSubmission::select('paper_submissions.*')
            ->where('id', '=', $id)
            ->first();

        if (empty($userRecord)) {
            abort(404, 'NOT FOUND');
        }

        // Add activity logs
        $user = Auth::user();
        activity('Paper Submission')
            ->performedOn($record)
            ->causedBy($user)
            ->event('viewed')
            ->withProperties(['attributes' => ['name' => $record->name]])
            ->log('viewed');

        //Data Array
        $data = array(
            'page_title' => 'Paper Submission',
            'p_title' => 'Paper Submission',
            'p_summary' => 'Show Paper Submission',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.conference-year.user-registration.paper-submission.update', [$yid->id, $uid->id, $record->id]),
            'url' => route('manager.conference-year.user-registration.paper-submission.index', [$yid->id, $uid->id]),
            'url_text' => 'View All',
            'data' => $record,
            'sdata' => $yid->id,
            'udata' => $uid->id,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );

        return view('manager.registration.paperSubmission.show')->with($data);
    }

    public function getImage($id)
    {
      
        $record = PaperSubmission::where('id', '=', $id)->first();
        // dd( $record);
        if (empty($record)) {
            abort(404, 'Paper NOT FOUND');
            // return redirect()->back();
        }

        // if (File::exists(Storage::disk('private')->path('user/abstract/' . $record->file))) {
        //     $path = Storage::disk('private')->path('user/abstract/' . $record->file);
        //     $file = File::get($path);
        //     $type = File::mimeType($path);
        //     $response = Response::make($file, 200);
        //     $response->header("Content-Type", $type);
        //     ob_end_clean();
        //     return $response;
        // } else {
        //     abort(404, 'NOT FOUND');
        // }
        $abstractFilePath = Storage::disk('private')->path('user/abstract/' . $record->file);
        $paperFilePath = Storage::disk('private')->path('user/paper/' . $record->file);

        if (File::exists($abstractFilePath) || File::exists($paperFilePath)) {
            $path = File::exists($abstractFilePath) ? $abstractFilePath : $paperFilePath;

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            ob_end_clean();
            return $response;
        } else {
            abort(404, 'NOT FOUND');
        }

    }

    /**
     * Show the form for editing the specified resource.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $yid, string $uid, string $id)
    {

        $yid = ConferenceYear::where('id', '=', $yid)
            ->first();

        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        $uid = UserRegistration::where('id', '=', $uid)
            ->first();

        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        $record = PaperSubmission::select('paper_submissions.*', 'users.name as name', 'users.email as email',
            'user_registrations.contact_no as contact_no', 'status_types.id as status_type_id', 'status_types.name as status_type_name')
            ->leftJoin('users', 'users.id', '=', 'paper_submissions.user_id')
            ->leftJoin('user_registrations', 'user_registrations.id', '=', 'paper_submissions.user_registration_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'paper_submissions.status_type_id')
            ->where('paper_submissions.id', '=', $id)
            ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $data = array(
            'page_title' => 'Paper Submission',
            'p_title' => 'Paper Submission',
            'p_summary' => 'Edit Paper Submission',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.conference-year.user-registration.paper-submission.update', [$yid->id, $uid->id, $record->id]),
            'url' => route('manager.conference-year.user-registration.paper-submission.index', [$yid->id, $uid->id]),
            'url_text' => 'View All',
            'data' => $record,
            'enctype' => 'multipart/form-data' // (Default)Without attachment
//            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.registration.paperSubmission.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param String_ $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $yid, $uid, string $id)
    {
        $yid = ConferenceYear::where('id', $yid)->first();
        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        $uid = UserRegistration::where('id', $uid)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        $userid = User::select('users.*')
            ->leftJoin('user_registrations', 'user_registrations.user_id', '=', 'users.id')
            ->where('users.id', $uid->user_id)->first();
        if (empty($userid)) {
            abort(404, 'NOT FOUND');
        }

        // Find the paper-submission record by $id
        $record = PaperSubmission::where('id', '=', $id)
            ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }


        //Registration Status
        $status_type = StatusType::where('status_types.slug', 'pending')->first();
        if (empty($status_type)) {
            abort(404, 'NOT FOUND');
        }

        $arr = [
            'user_id' => $userid->id,
            'user_registration_id' => $uid->id,
            'status_type_id' => $status_type->id,
            'updated_by' => Auth::user()->id,
        ];

        if (isset($record) && $record->file) {
            $prevImage = Storage::disk('private')->path('user/abstract/' . $record->file);
            if (File::exists($prevImage)) { // unlink or remove previous image from folder
                File::delete($prevImage);
            }
        }

        $uploadedFile = $request->file('file');
        $fileOriginalName = $uploadedFile->getClientOriginalName();
        $fileName = pathinfo($fileOriginalName, PATHINFO_FILENAME);
        $extension = $request->file->extension();
        $folderPath = 'user/abstract/';
        $filename = date('Y') . '/' . date('m') . '/' . date('d') . '/' . time() . '-' . rand(0, 999999) . $fileName . '.' . $extension;
        $file = $folderPath . $filename;
        Storage::disk('private')->put($file, file_get_contents($uploadedFile->getRealPath()));
        $arr['file'] = $filename;


//        Update User
        $record->update($arr);

        $messages = [
            array(
                'message' => 'Record updated successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.conference-year.user-registration.paper-submission.index', [$yid->id, $uid->id]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function editStatus($yid, $uid, string $id)
    {
        $yid = ConferenceYear::where('id', $yid)->first();
        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        $uid = UserRegistration::where('id', $uid)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        $record = PaperSubmission::select('paper_submissions.*', 'users.name as name', 'users.email as email',
            'user_registrations.contact_no as contact_no', 'status_types.id as status_type_id', 'status_types.name as status_type_name')
            ->leftJoin('users', 'users.id', '=', 'paper_submissions.user_id')
            ->leftJoin('user_registrations', 'user_registrations.id', '=', 'paper_submissions.user_registration_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'paper_submissions.status_type_id')
            ->where('paper_submissions.id', '=', $id)
            ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $data = array(
            'page_title' => 'Paper Submission Status',
            'p_title' => 'Paper Submission Status',
            'p_summary' => 'Edit Status',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.get.paper-submission-update-status', [$yid->id, $uid->id, $record->id]),
            'url' => route('manager.conference-year.user-registration.paper-submission.index', [$yid->id, $uid->id]),
            'url_text' => 'View All',
            'data' => $record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.registration.paperSubmission.status')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param String_ $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $yid, $uid, string $id)
    {
        // get conference-year record
        $yid = ConferenceYear::where('id', $yid)->first();
        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        // get user-registration record
        $uid = UserRegistration::where('id', $uid)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        // get user-registration record
        $record = PaperSubmission::select('paper_submissions.*', 'users.name as name', 'users.email as email',
            'user_registrations.contact_no as contact_no', 'status_types.id as status_type_id', 'status_types.name as status_type_name')
            ->leftJoin('users', 'users.id', '=', 'paper_submissions.user_id')
            ->leftJoin('user_registrations', 'user_registrations.id', '=', 'paper_submissions.user_registration_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'paper_submissions.status_type_id')
            ->where('paper_submissions.id', '=', $id)
            ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        // get user record based on user-registration
        $user = User::where('id', $record->user_id)->first();

        if (empty($user)) {
            abort(404, 'NOT FOUND');
        }


        $this->validate($request, [
            'status-type' => 'required',
        ]);

        $arr = [
            'status_type_id' => $request->input('status-type'),
        ];

        if ($record && $request->input('status-type') == 2) {
            $items = [];
            $creator = $user['email'];
            array_push($items, $creator);
            Mail::send('emails.approval_email', array(
                'name' => $user->name,
            ), function ($message) use ($items, $creator) {
                $message->from($creator)->to($items)->subject('Paper Approved');
            });

            $record->update($arr);

            $messages = [
                array(
                    'message' => 'Email Send to the Candidate',
                    'message_type' => 'success'
                ),
            ];
        } else if ($record && $request->input('status-type') == 3) {
            $items = [];
            $creator = $user['email'];
            array_push($items, $creator);
            Mail::send('emails.rejected_email', array(
                'name' => $user->name,
            ), function ($message) use ($items, $creator) {
                $message->from($creator)->to($items)->subject('Paper Rejected');
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
        return redirect()->route('manager.conference-year.user-registration.paper-submission.index', [$yid->id, $uid->id]);
    }


    /**
     * Remove the specified resource from storage.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($yid, $uid, string $id,)
    {

        $yid = ConferenceYear::where('id', $yid)->first();
        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        $uid = UserRegistration::where('id', $uid)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        $record = PaperSubmission::select('paper_submissions.*')
            ->where('id', '=', $id)
            ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $record->delete();

        $messages = [
            array(
                'message' => 'Record deleted successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.conference-year.user-registration.paper-submission.index', [$yid->id, $uid->id]);
    }

    /**
     * Display the specified resource Activity.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function getActivity($yid, $uid, string $id)
    {
        $yid = ConferenceYear::where('id', $yid)->first();
        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        $uid = UserRegistration::where('id', $uid)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        //Data Array
        $data = array(
            'page_title' => 'Paper Submission Activity',
            'p_title' => 'Paper Submission Activity',
            'p_summary' => 'Show Paper Submission Activity',
            'p_description' => null,
            'url' => route('manager.conference-year.user-registration.paper-submission.index', [$yid->id, $uid->id]),
            'url_text' => 'View All',
            'id' => $id,
        );
        return view('manager.registration.paperSubmission.activity')->with($data);
    }

    /**
     * Display the specified resource Activity Logs.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function getActivityLog(Request $request, string $id)
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
            ->where('activity_log.subject_type', PaperSubmission::class)
            ->where('activity_log.subject_id', $id)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('user_registrations', 'user_registrations.id', 'activity_log.subject_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', PaperSubmission::class)
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
            ->where('activity_log.subject_type', PaperSubmission::class)
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
    public function getTrashActivity($yid, $uid)
    {
        $yid = ConferenceYear::where('id', $yid)->first();
        if (empty($yid)) {
            abort(404, 'NOT FOUND');
        }

        $uid = UserRegistration::where('id', $uid)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        //Data Array
        $data = array(
            'page_title' => 'Paper Submission Activity',
            'p_title' => 'Paper Submission Activity',
            'p_summary' => 'Show Paper Submission Trashed Activity',
            'p_description' => null,
            'url' => route('manager.conference-year.user-registration.paper-submission.index', [$yid->id, $uid->id]),
            'url_text' => 'View All',
        );
        return view('manager.registration.paperSubmission.trash')->with($data);
    }

    /**
     * Display the trash resource Activity Logs.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function getTrashActivityLog(Request $request)
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
            ->where('activity_log.subject_type', PaperSubmission::class)
            ->where('activity_log.event', 'deleted')
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('user_registrations', 'user_registrations.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', PaperSubmission::class)
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
            ->where('activity_log.subject_type', PaperSubmission::class)
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
}
