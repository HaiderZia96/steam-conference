<?php

namespace App\Http\Controllers\Manager\Glimpse;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Glimpse;
use App\Models\GlimpseCategory;
use App\Models\InternationalCoursesAndCompetitionsDetailAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class GlimpseController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:manager_glimpse_glimpse-list', ['only' => ['index', 'getIndex']]);
        $this->middleware('permission:manager_glimpse_glimpse-activity-log', ['only' => ['getActivity', 'getActivityLog']]);
        $this->middleware('permission:manager_glimpse_glimpse-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:manager_glimpse_glimpse-show', ['only' => ['show']]);
        $this->middleware('permission:manager_glimpse_glimpse-download', ['only' => ['download']]);
        $this->middleware('permission:manager_glimpse_glimpse-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:manager_glimpse_glimpse-delete', ['only' => ['destroy']]);
        $this->middleware('permission:manager_glimpse_glimpse-activity-log-trash', ['only' => ['getTrashActivity', 'getTrashActivityLog']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'page_title' => 'Glimpse',
            'p_title' => 'Glimpse',
            'p_summary' => 'List of Glimpse',
            'p_description' => null,
            'url' => route('manager.glimpse.create'),
            'url_text' => 'Add New',
            'trash' => route('manager.get.glimpse-activity-trash'),
            'trash_text' => 'View Trash',
        ];
        return view('manager.glimpse.glimpse.index')->with($data);
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

        /** Filter Out Records for Department **/
        if (!empty($request->get('department_id'))) {
            $department = $request->get('department_id');
            $var = ['glimpses.department_id', '=', $department];
            array_push($where, $var);
        }

        /** Filter Out Records for Glimpse Category **/
        if (!empty($request->get('glimpse_category_id'))) {
            $glimpseCategory = $request->get('glimpse_category_id');
            $var = ['glimpses.glimpse_category_id', '=', $glimpseCategory];
            array_push($where, $var);
        }

        /** Filter Out Records for Glimpse Year **/
        if (!empty($request->get('glimpse_year_id'))) {
            $glimpseYear = $request->get('glimpse_year_id');
            $var = ['glimpses.glimpse_year_id', '=', $glimpseYear];
            array_push($where, $var);
        }

        /** Filter Out Records for Glimpse Day **/
        if (!empty($request->get('glimpse_day_id'))) {
            $glimpseDay = $request->get('glimpse_day_id');
            $var = ['glimpses.glimpse_day_id', '=', $glimpseDay];
            array_push($where, $var);
        }

        // Total records
        $totalRecords = Glimpse::with('departments', 'glimpseCategories', 'glimpseYears', 'glimpseDays')
            ->where($where)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Glimpse::with('departments', 'glimpseCategories', 'glimpseYears', 'glimpseDays')
            ->where(function ($q) use ($searchValue) {
                $q->where('glimpses.title', 'like', '%' . $searchValue . '%')
                    ->orWhere(function ($query) use ($searchValue) {
                        $query->orWhereHas('departments', function ($subQuery) use ($searchValue) {
                            $subQuery->where('departments.name', 'like', '%' . $searchValue . '%');
                        })->orWhereHas('glimpseCategories', function ($subQuery) use ($searchValue) {
                            $subQuery->where('glimpse_categories.name', 'like', '%' . $searchValue . '%');
                        })->orWhereHas('glimpseYears', function ($subQuery) use ($searchValue) {
                            $subQuery->where('glimpse_years.name', 'like', '%' . $searchValue . '%');
                        })->orWhereHas('glimpseDays', function ($subQuery) use ($searchValue) {
                            $subQuery->where('glimpse_days.day', 'like', '%' . $searchValue . '%');
                        });
                    });
            })
            ->where($where)
            ->count();


        // Fetch records
        $records = Glimpse::with('departments', 'glimpseCategories', 'glimpseYears', 'glimpseDays')
            ->where(function ($q) use ($searchValue) {
                $q->where('glimpses.title', 'like', '%' . $searchValue . '%')
                    ->orWhere(function ($query) use ($searchValue) {
                        $query->orWhereHas('departments', function ($subQuery) use ($searchValue) {
                            $subQuery->where('departments.name', 'like', '%' . $searchValue . '%');
                        })->orWhereHas('glimpseCategories', function ($subQuery) use ($searchValue) {
                            $subQuery->where('glimpse_categories.name', 'like', '%' . $searchValue . '%');
                        })->orWhereHas('glimpseYears', function ($subQuery) use ($searchValue) {
                            $subQuery->where('glimpse_years.name', 'like', '%' . $searchValue . '%');
                        })->orWhereHas('glimpseDays', function ($subQuery) use ($searchValue) {
                            $subQuery->where('glimpse_days.day', 'like', '%' . $searchValue . '%');
                        });
                    });
            })
            ->where($where)
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $title = (isset($record->title) ? $record->title : '');
            $image = (isset($record->image) ? $record->image : '');
            $department = (isset($record->departments->name) ? $record->departments->name : '');
            $glimpse_category = (isset($record->glimpseCategories->name) ? $record->glimpseCategories->name : '');
            $glimpse_year = (isset($record->glimpseYears->name) ? $record->glimpseYears->name : '');
            $glimpse_day = (isset($record->glimpseDays->day) ? $record->glimpseDays->day : '');

            $data_arr[] = array(
                "id" => $id,
                "title" => $title,
                "image" => $image,
                "department" => $department,
                "glimpse_category" => $glimpse_category,
                "glimpse_year" => $glimpse_year,
                "glimpse_day" => $glimpse_day,
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array(
            'page_title' => 'Glimpse',
            'p_title' => 'Glimpse',
            'p_summary' => 'Add Glimpse',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.glimpse.store'),
            'url' => route('manager.glimpse.index'),
            'url_text' => 'View All',
            'enctype' => 'multipart/form-data' // (Default)Without attachment
//            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.glimpse.glimpse.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg',
            'department' => 'required|exists:departments,id',
            'glimpse_category' => 'required|exists:glimpse_categories,id',
            'glimpse_year' => 'required|exists:glimpse_years,id',
            'glimpse_day' => 'required|exists:glimpse_days,id',
        ]);


        //
        $arr = [
            'title' => $request->input('title'),
            'department_id' => $request->input('department'),
            'glimpse_category_id' => $request->input('glimpse_category'),
            'glimpse_year_id' => $request->input('glimpse_year'),
            'glimpse_day_id' => $request->input('glimpse_day'),
            'created_by' => Auth::user()->id,
        ];


        if ($request->hasFile('cropper_thumbnail')) {
            //Uploading Image
            $image = $request->file('cropper_thumbnail');
            $filename = $image->getClientOriginalName();
            $filenameWithTimestamp = date('Y') . '/' . time() . '-' . rand(0, 999999) . '-' . $filename;

            Storage::disk('public')->putFileAs('glimpse', $image, $filenameWithTimestamp);
            $arr['image'] = $filenameWithTimestamp;
        }

        Glimpse::create($arr);
        $messages = [
            array(
                'message' => 'Record created successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.glimpse.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = Glimpse::with('departments', 'glimpseCategories', 'glimpseYears', 'glimpseDays')
            ->where('glimpses.id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        // Add activity logs
        $user = Auth::user();
        activity('Glimpse')
            ->performedOn($record)
            ->causedBy($user)
            ->event('viewed')
            ->withProperties(['attributes' => ['name' => $record->name]])
            ->log('viewed');
        //Data Array
        $data = array(
            'page_title' => 'Glimpse',
            'p_title' => 'Glimpse',
            'p_summary' => 'Show Glimpse',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.glimpse.update', $record->id),
            'url' => route('manager.glimpse.index'),
            'url_text' => 'View All',
            'data' => $record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.glimpse.glimpse.show')->with($data);
    }


    /**
     * Download file for the specified resource.
     */
    public function download(string $id)
    {
        $record = Glimpse::select('glimpses.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        $file = $record->image;
        $path = Storage::disk('public')->path('glimpse/' . $record->image);
        $filename = preg_replace_array('/^\d+\/\d+-\d+-/', [''], $file);

        return response()->download($path, $filename);
    }

    function getGlimpseImage($id)
    {
        $record = Glimpse::select('glimpses.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        $path = Storage::disk('public')->path('glimpse/' . $record->image);

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = Glimpse::with('departments', 'glimpseCategories', 'glimpseYears', 'glimpseDays')
            ->where('glimpses.id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $data = array(
            'page_title' => 'Glimpse',
            'p_title' => 'Glimpse',
            'p_summary' => 'Edit Glimpse',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.glimpse.update', $record->id),
            'url' => route('manager.glimpse.index'),
            'url_text' => 'View All',
            'data' => $record,
            'enctype' => 'multipart/form-data' // (Default)Without attachment
//            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.glimpse.glimpse.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = Glimpse::select('glimpses.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $this->validate($request, [
            'title' => 'required',
            'image' => 'mimes:jpg,png,jpeg',
            'department' => 'required|exists:departments,id',
            'glimpse_category' => 'required|exists:glimpse_categories,id',
            'glimpse_year' => 'required|exists:glimpse_years,id',
            'glimpse_day' => 'required|exists:glimpse_days,id',
        ]);
        //
        $arr = [
            'title' => $request->input('title'),
            'department_id' => $request->input('department'),
            'glimpse_category_id' => $request->input('glimpse_category'),
            'glimpse_year_id' => $request->input('glimpse_year'),
            'glimpse_day_id' => $request->input('glimpse_day'),
            'updated_by' => Auth::user()->id,
        ];

        if ($request->hasFile('cropper_thumbnail')) {

            // Delete previous Image
            $prevImage= $record->image;

            //Uploading Image
            $image = $request->file('cropper_thumbnail');
            $filename = $image->getClientOriginalName();
            $filenameWithTimestamp = date('Y') . '/' . time() . '-' . rand(0, 999999) . '-' . $filename;

            Storage::disk('public')->putFileAs('glimpse', $image, $filenameWithTimestamp);
            $arr['image'] = $filenameWithTimestamp;

            if ($prevImage) {
                $path = Storage::disk('public')->path('glimpse/' . $prevImage);

                if (File::exists($path)) {
                    unlink($path);
                    File::delete($path);
                }
            }        }

        $record->update($arr);
        $messages = [
            array(
                'message' => 'Record updated successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.glimpse.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Glimpse::select('glimpses.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        // delete the uploaded file
        $path = Storage::disk('public')->path('glimpse/' . $record->image);

        if (File::exists($path)) {
            unlink($path);
            File::delete($path);
        }

        $record->delete();

        $messages = [
            array(
                'message' => 'Record deleted successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.glimpse.index');
    }

    /**
     * Display the specified resource Activity.
     * @param String_ $id
     * @return \Illuminate\Http\Response
     */
    public function getActivity(string $id)
    {
        //Data Array
        $data = array(
            'page_title' => 'Glimpse Activity',
            'p_title' => 'Glimpse Activity',
            'p_summary' => 'Show Glimpse Activity',
            'p_description' => null,
            'url' => route('manager.glimpse.index'),
            'url_text' => 'View All',
            'id' => $id,
        );
        return view('manager.glimpse.glimpse.activity')->with($data);
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
            ->leftJoin('glimpses', 'glimpses.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', Glimpse::class)
            ->where('activity_log.subject_id', $id)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('glimpses', 'glimpses.id', 'activity_log.subject_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', Glimpse::class)
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('glimpses', 'glimpses.id', 'activity_log.subject_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', Glimpse::class)
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
    public function getTrashActivity()
    {
        //Data Array
        $data = array(
            'page_title' => 'Glimpse Activity',
            'p_title' => 'Glimpse Activity',
            'p_summary' => 'Show Glimpse Trashed Activity',
            'p_description' => null,
            'url' => route('manager.glimpse.index'),
            'url_text' => 'View All',
        );
        return view('manager.glimpse.glimpse.trash')->with($data);
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
            ->leftJoin('glimpses', 'glimpses.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', Glimpse::class)
            ->where('activity_log.event', 'deleted')
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('glimpses', 'glimpses.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', Glimpse::class)
            ->where('activity_log.event', 'deleted')
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('glimpses', 'glimpses.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', Glimpse::class)
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
