<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaperSubmission;
use App\Models\StatusType;
use App\Models\User;
use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class PaperSubmissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user_registration_paper-submission-list', ['only' => ['index', 'getIndex']]);
        $this->middleware('permission:user_registration_paper-submission-activity-log', ['only' => ['getActivity', 'getActivityLog']]);
        $this->middleware('permission:user_registration_paper-submission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user_registration_paper-submission-show', ['only' => ['show']]);
        $this->middleware('permission:user_registration_paper-submission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user_registration_paper-submission-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        // $registerStatus = StatusType::where('id', 3)->first();
        //  if (empty($uid)) {
        //     abort(404, 'NOT FOUND');
        // }
        // dd($registerStatus);
        // dd($abstract);

        // $abstract = null;
        // if (Auth::check()) {
        //     $user_id = Auth::user()->id;
        //     $register = UserRegistration::where('user_id', $user_id)->first();
        // $abstract = StatusType::where('user_id', $user_id)->where('slug', '!=', 'rejected')->first();

        // }

        $abstract = null;
        $register = null;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $register = UserRegistration::where('user_id', $user_id)->first();
            $abstract = PaperSubmission::where('user_id', $user_id)->where('status_type_id', '!=', 3)->first();
        }
        // dd( $abstract);
        $data = [
            'page_title' => 'Paper Submission',
            'p_title' => 'Paper Submission',
            'p_summary' => '',
            'p_description' => null,
            'url' => route('user.paper-submission.create'),
            'url_text' => 'Add New',
            'trash' => route('user.get.paper-submission-activity-trash'),
            'trash_text' => 'View Trash',
            'abstract' => $abstract,
            // 'sdata' => $sid->id,
            // 'udata' => $uid->id,
        ];
        return view('user.registration.paperSubmission.index')->with($data);
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
        // $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        // $columnIndex = $columnIndex_arr[0]['column']; // Column index
        // $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        // $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value



        // Total records
        $totalRecords = PaperSubmission::with('user_registrations','status_types','users')
            ->count();

        // Total records with filter
        $totalRecordswithFilter = PaperSubmission::with('user_registrations','status_types','users')
        ->where('user_id',Auth::user()->id)
        ->where(function ($query) use ($searchValue) {
            $query->orWhereHas('status_types', function ($subQuery) use ($searchValue) {
                $subQuery->where('status_types.name', 'like', '%' . $searchValue . '%');
            })->orWhereHas('users', function ($subQuery) use ($searchValue) {
                $subQuery->where('users.name', 'like', '%' . $searchValue . '%');
            });
        })
        ->count();

        // Fetch records
        $records = PaperSubmission::with('user_registrations','status_types','users')
        ->where('user_id',Auth::user()->id)
        ->where(function ($query) use ($searchValue) {
            $query->orWhereHas('status_types', function ($subQuery) use ($searchValue) {
                $subQuery->where('status_types.name', 'like', '%' . $searchValue . '%');
            })->orWhereHas('users', function ($subQuery) use ($searchValue) {
                $subQuery->where('users.name', 'like', '%' . $searchValue . '%');
            });
        })
            // ->skip($start)
            // ->take($rowperpage)
            // ->orderBy($columnName, $columnSortOrder)
            ->get();

        // dd($records);

        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $name = $record->users->name;
            $email = $record->users->email;
//            $contact_no = $record->user_registrations->contact_no;
            $status_type_name = $record->status_types->name;

            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
//                "contact_no" => $contact_no,
                "status_type_name" => $status_type_name,

            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        // dd($response);
        echo json_encode($response);
        exit;
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getStatusTypeIndex(Request $request)
    {
// dd('abc');

        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $user = UserRegistration::where('user_id', Auth::user()->id)->first();
             $data = StatusType::where('id', $user->status_type_id )
             ->where('abstract_submissions.name', 'like', '%' . $search . '%')->get();

        }
        return response()->json($data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // $sid = \App\Models\Session::where('id', $sid)->first();
        // if (empty($sid)) {
        //     abort(404, 'NOT FOUND');
        // }

        // $uid = UserRegistration::where('id', $uid)->first();
        // if (empty($uid)) {
        //     abort(404, 'NOT FOUND');
        // }
        $data = array(
            'page_title' => 'Paper Submission',
            'p_title' => 'Paper Submission',
            'p_summary' => 'Add Paper Submission',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('user.paper-submission.store'),
            'url' => route('user.paper-submission.index'),
            'url_text' => 'View All',
            'enctype' => 'multipart/form-data' // (Default)Without attachment
//            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('user.registration.paperSubmission.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uid = UserRegistration::where('user_id',Auth::user()->id)->first();
        if (empty($uid)) {
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
            'user_id' => Auth::user()->id,
            'user_registration_id' => $uid->id,
            'status_type_id' => $status_type->id,
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

        return redirect()->route('user.paper-submission.index');
    }

    /**
     * Display the specified resource.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {

        $record = PaperSubmission::with('user_registrations','status_types','users')
        ->where('id', $id)
        ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        //Data Array
        $data = array(
            'page_title' => 'Paper Submission',
            'p_title' => 'Paper Submission',
            'p_summary' => 'Show Paper Submission',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('user.paper-submission.update', $record->id),
            'url' => route('user.paper-submission.index'),
            'url_text' => 'View All',
            'data' => $record,
            'enctype' => 'application/x-www-form-urlencoded',
        );

        return view('user.registration.paperSubmission.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $recordId = PaperSubmission::with('user_registrations','status_types','users')
        ->where('id', $id)
        ->first();

        if (empty($recordId)) {
            abort(404, 'NOT FOUND');
        }


        $record = PaperSubmission::select('abstract_submissions.*', 'users.name as name', 'users.email as email',
            'user_registrations.contact_no as contact_no', 'status_types.id as status_type_id', 'status_types.name as status_type_name')
            ->leftJoin('users', 'users.id', '=', 'abstract_submissions.user_id')
            ->leftJoin('user_registrations', 'user_registrations.id', '=', 'abstract_submissions.user_registration_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'abstract_submissions.status_type_id')
            ->where('abstract_submissions.id', '=', $id)
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
            'action' => route('user.paper-submission.update',$recordId->id),
            'url' => route('user.paper-submission.index'),
            'url_text' => 'View All',
            'data' => $recordId,
            'enctype' => 'multipart/form-data' // (Default)Without attachment
//            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('user.registration.paperSubmission.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param String_ $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $uid = UserRegistration::where('user_id',Auth::user()->id)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }


        $recordId = PaperSubmission::with('user_registrations','status_types','users')
        ->where('id', $id)
        ->first();

        if (empty($recordId)) {
            abort(404, 'NOT FOUND');
        }


        // Find the paper-submission record by $id
        $record = PaperSubmission::where('id', '=', $id)
            ->first();

        if (empty($record)) {
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
            'user_id' => Auth::user()->id,
            'user_registration_id' => $uid->id,
            'status_type_id' => $status_type->id,
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

        return redirect()->route('user.paper-submission.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function editStatus($uid, string $id)
    {
        // $sid = \App\Models\Session::where('id', $sid)->first();
        // if (empty($sid)) {
        //     abort(404, 'NOT FOUND');
        // }

        $uid = UserRegistration::where('id', $uid)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        $record = PaperSubmission::select('abstract_submissions.*', 'users.name as name', 'users.email as email',
            'user_registrations.contact_no as contact_no', 'status_types.id as status_type_id', 'status_types.name as status_type_name')
            ->leftJoin('users', 'users.id', '=', 'abstract_submissions.user_id')
            ->leftJoin('user_registrations', 'user_registrations.id', '=', 'abstract_submissions.user_registration_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'abstract_submissions.status_type_id')
            ->where('abstract_submissions.id', '=', $id)
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
            'action' => route('user.get.paper-submission-update-status', [$uid->id, $record->id]),
            'url' => route('user.paper-submission.index',  $uid->id),
            'url_text' => 'View All',
            'data' => $record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('user.registration.paperSubmission.status')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param String_ $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $uid, string $id)
    {
        // $sid = \App\Models\Session::where('id', $sid)->first();
        // if (empty($sid)) {
        //     abort(404, 'NOT FOUND');
        // }

        $uid = UserRegistration::where('id', $uid)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        $record = PaperSubmission::select('abstract_submissions.*', 'users.name as name', 'users.email as email',
            'user_registrations.contact_no as contact_no', 'status_types.id as status_type_id', 'status_types.name as status_type_name')
            ->leftJoin('users', 'users.id', '=', 'abstract_submissions.user_id')
            ->leftJoin('user_registrations', 'user_registrations.id', '=', 'abstract_submissions.user_registration_id')
            ->leftJoin('status_types', 'status_types.id', '=', 'abstract_submissions.status_type_id')
            ->where('abstract_submissions.id', '=', $id)
            ->first();

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }


        $this->validate($request, [
            'registration-status' => 'required',
        ]);

        $arr = [
            'status_type_id' => $request->input('registration-status'),
        ];

        $record->update($arr);

        $messages = [
            array(
                'message' => 'Record updated successfully',
                'message_type' => 'success'
            ),
        ];

        Session::flash('messages', $messages);
        return redirect()->route('user.paper-submission.index',  $uid->id);
    }


    /**
     * Remove the specified resource from storage.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uid, string $id,)
    {

        // $sid = \App\Models\Session::where('id', $sid)->first();
        // if (empty($sid)) {
        //     abort(404, 'NOT FOUND');
        // }

        $uid = UserRegistration::where('id', $uid)->first();
        if (empty($uid)) {
            abort(404, 'NOT FOUND');
        }

        $record = PaperSubmission::select('abstract_submissions.*')
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

        return redirect()->route('user.paper-submission.index', $uid->id);
    }

    /**
     * Display the specified resource Activity.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function getActivity($uid, string $id)
    {
        // $sid = \App\Models\Session::where('id', $sid)->first();
        // if (empty($sid)) {
        //     abort(404, 'NOT FOUND');
        // }

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
            'url' => route('user.paper-submission.index', $uid->id),
            'url_text' => 'View All',
            'id' => $id,
        );
        return view('user.registration.paperSubmission.activity')->with($data);
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
    public function getTrashActivity($uid)
    {
        // $sid = \App\Models\Session::where('id', $sid)->first();
        // if (empty($sid)) {
        //     abort(404, 'NOT FOUND');
        // }

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
            'url' => route('user.paper-submission.index', $uid->id),
            'url_text' => 'View All',
        );
        return view('user.registration.paperSubmission.trash')->with($data);
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
    public function getImage($id)
    {
        // dd('123');
        $record = PaperSubmission::where('id','=',$id )->first();
        // dd($record);
        if (empty($record)){
            abort(404, 'NOT FOUND');
        }

        // $path = Storage::disk('private')->path('user/abstract/' . $record->file);
        // if (File::exists($path)) {
        //     $file = File::get($path);
        //     $type = File::mimeType($path);
        //     $response = Response::make($file, 200);
        //     $response->header("Content-Type", $type);
        //     return $response;
        // }
        // else{
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
}
