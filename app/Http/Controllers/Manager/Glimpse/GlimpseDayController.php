<?php

namespace App\Http\Controllers\Manager\Glimpse;

use App\Http\Controllers\Controller;
use App\Models\GlimpseDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;

class GlimpseDayController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:manager_glimpse_glimpse-day-list', ['only' => ['index', 'getIndex']]);
        $this->middleware('permission:manager_glimpse_glimpse-day-activity-log', ['only' => ['getActivity', 'getActivityLog']]);
        $this->middleware('permission:manager_glimpse_glimpse-day-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:manager_glimpse_glimpse-day-show', ['only' => ['show']]);
        $this->middleware('permission:manager_glimpse_glimpse-day-download', ['only' => ['download']]);
        $this->middleware('permission:manager_glimpse_glimpse-day-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:manager_glimpse_glimpse-day-delete', ['only' => ['destroy']]);
        $this->middleware('permission:manager_glimpse_glimpse-day-activity-log-trash', ['only' => ['getTrashActivity', 'getTrashActivityLog']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'page_title' => 'Glimpse Day',
            'p_title' => 'Glimpse Day',
            'p_summary' => 'List of Glimpse Day',
            'p_description' => null,
            'url' => route('manager.glimpse-day.create'),
            'url_text' => 'Add New',
            'trash' => route('manager.get.glimpse-day-activity-trash'),
            'trash_text' => 'View Trash',
        ];
        return view('manager.glimpse.glimpseDay.index')->with($data);
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

        /** Filter Out Records for Glimpse Year **/
        if (!empty($request->get('glimpse_year_id'))) {
            $glimpseYear = $request->get('glimpse_year_id');
            $var = ['glimpse_days.glimpse_year_id', '=', $glimpseYear];
            array_push($where, $var);
        }

        // Total records
        $totalRecords = GlimpseDay::with('glimpseYears')
            ->where($where)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = GlimpseDay::with('glimpseYears')
            ->where(function ($q) use ($searchValue) {
                $q->where('glimpse_days.day', 'like', '%' . $searchValue . '%')->orWhere(function ($query) use ($searchValue) {
                    $query->orWhereHas('glimpseYears', function ($subQuery) use ($searchValue) {
                        $subQuery->where('glimpse_years.name', 'like', '%' . $searchValue . '%');
                    });
                });
            })
            ->where($where)
            ->count();

        // Fetch records
        $records = GlimpseDay::with('glimpseYears')
            ->where(function ($q) use ($searchValue) {
                $q->where('glimpse_days.day', 'like', '%' . $searchValue . '%')->orWhere(function ($query) use ($searchValue) {
                    $query->orWhereHas('glimpseYears', function ($subQuery) use ($searchValue) {
                        $subQuery->where('glimpse_years.name', 'like', '%' . $searchValue . '%');
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
            $day = $record->day;
            $glimpse_year = (isset($record->glimpseYears->name) ? $record->glimpseYears->name : '');
            $date = $record->date;

            $data_arr[] = array(
                "id" => $id,
                "day" => $day,
                "glimpse_year" => $glimpse_year,
                "date" => $date,
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
    public function getIndexGlimpseDaySelect(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $glimpseYear = $request->yid;

//            if(!empty($glimpseYear)){
            $data = GlimpseDay::select('glimpse_days.id as id','glimpse_days.day as name')
                ->where(function ($q) use ($search){
                    $q->where('glimpse_days.day', 'like', '%' .$search . '%');
                })
                ->where('glimpse_days.glimpse_year_id', $glimpseYear)
                ->get();
//            }

//            else{
//                $data = GlimpseDay::select('glimpse_days.id as id','glimpse_days.day as name')
//                    ->where(function ($q) use ($search){
//                        $q->where('glimpse_days.day', 'like', '%' .$search . '%');
//                    })->get();
//            }
        }

        return response()->json($data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array(
            'page_title' => 'Glimpse Day',
            'p_title' => 'Glimpse Day',
            'p_summary' => 'Add Glimpse Day',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.glimpse-day.store'),
            'url' => route('manager.glimpse-day.index'),
            'url_text' => 'View All',
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.glimpse.glimpseDay.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'day' => 'required',
            'glimpse_year' => 'required|exists:glimpse_years,id',
            'date' => 'required',
        ]);

        $glimpseDay = [
            'day' => $request->input('day'),
            'glimpse_year_id' => $request->input('glimpse_year'),
            'date' => $request->input('date'),
            'created_by' => Auth::user()->id,
        ];
        GlimpseDay::create($glimpseDay);
        $messages = [
            array(
                'message' => 'Record created successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.glimpse-day.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = GlimpseDay::with('glimpseYears')
            ->where('glimpse_days.id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        // Add activity logs
        $user = Auth::user();
        activity('Glimpse Day')
            ->performedOn($record)
            ->causedBy($user)
            ->event('viewed')
            ->withProperties(['attributes' => ['name' => $record->name]])
            ->log('viewed');
        //Data Array
        $data = array(
            'page_title' => 'Glimpse Day',
            'p_title' => 'Glimpse Day',
            'p_summary' => 'Show Glimpse Day',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.glimpse-day.update', $record->id),
            'url' => route('manager.glimpse-day.index'),
            'url_text' => 'View All',
            'data' => $record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.glimpse.glimpseDay.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = GlimpseDay::with('glimpseYears')
            ->where('glimpse_days.id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $data = array(
            'page_title' => 'Glimpse Day',
            'p_title' => 'Glimpse Day',
            'p_summary' => 'Edit Glimpse Day',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.glimpse-day.update', $record->id),
            'url' => route('manager.glimpse-day.index'),
            'url_text' => 'View All',
            'data' => $record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.glimpse.glimpseDay.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = GlimpseDay::select('glimpse_days.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        $this->validate($request, [
            'day' => 'required',
            'glimpse_year' => 'required|exists:glimpse_years,id',
            'date' => 'required',
        ]);
        //
        $arr = [
            'day' => $request->input('day'),
            'glimpse_year_id' => $request->input('glimpse_year'),
            'date' => $request->input('date'),
            'updated_by' => Auth::user()->id,
        ];
        $record->update($arr);
        $messages = [
            array(
                'message' => 'Record updated successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.glimpse-day.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = GlimpseDay::select('glimpse_days.*')
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

        return redirect()->route('manager.glimpse-day.index');
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
            'page_title' => 'Glimpse Day Activity',
            'p_title' => 'Glimpse Day Activity',
            'p_summary' => 'Show Glimpse Day Activity',
            'p_description' => null,
            'url' => route('manager.glimpse-day.index'),
            'url_text' => 'View All',
            'id' => $id,
        );
        return view('manager.glimpse.glimpseDay.activity')->with($data);
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
            ->leftJoin('glimpse_days', 'glimpse_days.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', GlimpseDay::class)
            ->where('activity_log.subject_id', $id)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('glimpse_days', 'glimpse_days.id', 'activity_log.subject_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', GlimpseDay::class)
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('glimpse_days', 'glimpse_days.id', 'activity_log.subject_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', GlimpseDay::class)
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
            'page_title' => 'Glimpse Day Activity',
            'p_title' => 'Glimpse Day Activity',
            'p_summary' => 'Show Glimpse Day Trashed Activity',
            'p_description' => null,
            'url' => route('manager.glimpse-day.index'),
            'url_text' => 'View All',
        );
        return view('manager.glimpse.glimpseDay.trash')->with($data);
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
            ->leftJoin('glimpse_days', 'glimpse_days.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', GlimpseDay::class)
            ->where('activity_log.event', 'deleted')
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('glimpse_days', 'glimpse_days.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', GlimpseDay::class)
            ->where('activity_log.event', 'deleted')
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('glimpse_days', 'glimpse_days.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', GlimpseDay::class)
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
