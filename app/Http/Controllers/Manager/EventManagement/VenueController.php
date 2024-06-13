<?php

namespace App\Http\Controllers\Manager\EventManagement;

use App\Http\Controllers\Controller;
use App\Models\ConferenceYear;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;

class VenueController extends Controller
{
    function __construct()
    
    {
        $this->middleware('permission:manager_event_settings-venue-list', ['only' => ['index', 'getIndex', 'getIndexSelect']]);
        $this->middleware('permission:manager_event_settings-venue-activity-log', ['only' => ['getActivity', 'getActivityLog']]);
        $this->middleware('permission:manager_event_settings-venue-activity-log-trash', ['only' => ['getTrashActivity', 'getTrashActivityLog']]);
        $this->middleware('permission:manager_event_settings-venue-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:manager_event_settings-venue-show', ['only' => ['show']]);
        $this->middleware('permission:manager_event_settings-venue-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:manager_event_settings-venue-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index($yid)
    {
        $session = ConferenceYear::where('id', $yid)->first();
        $data = [
            'page_title' => 'venue',
            'p_title' => 'venue',
            's_title' => $session->title,
            'p_summary' => 'List of venue',
            'p_description' => null,
            'url' => route('manager.conference-year.venue.create', $session->id),
            'url_text' => 'Add New',
            'trash' => route('manager.get.venue-activity-trash', $yid),
            'trash_text' => 'View Trash',
            'session' => $session,
        ];
        return view('manager.eventManagement.venue.index')->with($data);
    }

    public function getVenue(Request $request, $yid)
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
        $totalRecords = Venue::select('count(*) as allcount')
            ->where('conference_year_id', $yid)
            ->where(function ($q) use ($searchValue) {
                $q->where('venues.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('venues.location', 'like', '%' . $searchValue . '%');
            })
            ->orderBy('id', 'DESC')
            ->count();
        // Total records with filter
        $totalRecordswithFilter = Venue::select('count(*) as allcount')
            ->where('conference_year_id', $yid)
            ->where(function ($q) use ($searchValue) {
                $q->where('venues.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('venues.location', 'like', '%' . $searchValue . '%');
            })
            ->orderBy('id', 'DESC')
            ->count();
        // Total records
        $records = Venue::orderBy($columnName, $columnSortOrder)
            ->where('conference_year_id', $yid)
            ->where(function ($q) use ($searchValue) {
                $q->where('venues.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('venues.location', 'like', '%' . $searchValue . '%');
            })
            ->select('venues.*')
            ->orderBy('id', 'DESC')
            ->skip($start)
            ->take($rowperpage)
            ->get();
        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $title = $record->title;
            $start_time = $record->start_time;
            $location = $record->location;
            $event_date = $record->event_date;

            $data_arr[] = array(
                "id" => $id,
                "title" => $title,
                "start_time" => $start_time,
                "location" => $location,
                "event_date" => $event_date,
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
    public function create($yid)
    {
        $conference_year = ConferenceYear::where('id', $yid)->first();
        // dd($conference_year);
        $data = array(
            'page_title' => 'venue',
            'p_title' => 'venue',
            'p_summary' => 'Add venue',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.conference-year.venue.store', $conference_year->id),
            'url' => route('manager.conference-year.venue.index', $conference_year->id),
            'url_text' => 'View All',
            'enctype' => 'multipart/form-data', // (Default)Without attachment
            'conference_year' => $conference_year,
        );
        return view('manager.eventManagement.venue.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'start_time' => 'required',
            'event_date' => 'required',
            'location' => 'required',
            'map' => 'required',
            'description' => 'required',
            'conference_year_id'=> 'required|unique:venues,conference_year_id',
        ],[
            'conference_year_id.required'=> 'conference_year field is required.',
            'conference_year_id.unique'=> 'conference_year has already been taken.',
        ]);

        $arr = [
            'conference_year_id' => $request->input('conference_year_id'),
            'title' => $request->input('title'),
            'start_time' => $request->input('start_time'),
            'event_date' => $request->input('event_date'),
            'location' => $request->input('location'),
            'map' => $request->input('map'),
            'description' => $request->input('description'),
            'created_by' => Auth::user()->id,
        ];
        $record = Venue::create($arr);
        if ($record) {
            $messages = [
                array(
                    'message' => 'Record created successfully',
                    'message_type' => 'success'
                ),
            ];
            Session::flash('messages', $messages);

            return redirect()->route('manager.conference-year.venue.index', $request->input('conference_year_id'));
        } else {
            abort(404, 'NOT FOUND');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($yid, string $id)
    {
        $record = Venue::find($id);
        $conference_year = ConferenceYear::where('id', $yid)->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        // Add activity logs
        $user = Auth::user();
        activity('Venue')
            ->performedOn($record)
            ->causedBy($user)
            ->event('viewed')
            ->withProperties(['attributes' => ['name' => $record->location]])
            ->log('viewed');
        $data = array(
            'page_title' => 'Venue',
            'p_title' => 'Venue',
            'p_summary' => 'Show Venue',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.conference-year.venue.update', [$conference_year->id, $record->id]),
            'url' => route('manager.conference-year.venue.index', $conference_year->id),
            'url_text' => 'View All',
            'data' => $record,
            'conference_year' => $conference_year,
            'enctype' => 'application/x-www-form-urlencoded',
        );
        return view('manager.eventManagement.venue.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($yid, string $id)
    {
        $conference_year = ConferenceYear::where('id', $yid)->first();
        $record = Venue::find($id);

        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        $data = array(
            'page_title' => 'Venue',
            'p_title' => 'Venue',
            'p_summary' => 'Edit Venue',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.conference-year.venue.update', [$yid, $record->id]),
            'url' => route('manager.conference-year.venue.index', $yid),
            'url_text' => 'View All',
            'data' => $record,
            'conference_year' => $conference_year,
            'enctype' => 'application/x-www-form-urlencoded',
        );
        return view('manager.eventManagement.venue.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $yid, string $id)
    {
        $record = Venue::find($id);
        $this->validate($request, [
            'title' => 'required',
            'start_time' => 'required',
            'event_date' => 'required',
            'location' => 'required',
            'map' => 'required',
            'description' => 'required',
            'session_id'=> 'unique:venues,session_id,'.$id,
        ],[
            'session_id.required'=> 'conference_year field is required.',
            'session_id.unique'=> 'conference_year has already been taken.',
        ]);

        $arr = [
            'session_id' => $yid,
            'title' => $request->input('title'),
            'start_time' => $request->input('start_time'),
            'event_date' => $request->input('event_date'),
            'location' => $request->input('location'),
            'map' => $request->input('map'),
            'description' => $request->input('description'),
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
        return redirect()->route('manager.conference-year.venue.index', $yid);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($yid, string $id)
    {
        $record = Venue::find($id);
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
        return redirect()->route('manager.conference-year.venue.index', $yid);
    }

    public function getActivity($yid, string $id)
    {
        //Data Array
        $data = array(
            'page_title' => 'Venue',
            'p_title' => 'Venue',
            'p_summary' => 'Show Venue',
            'p_description' => null,
            'url' => route('manager.conference-year.venue.index', $yid),
            'url_text' => 'View All',
            'id' => $id,
        );
        return view('manager.eventManagement.venue.activity')->with($data);
    }

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
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', Venue::class)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', Venue::class)
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', Venue::class)
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

    public function getTrashActivity($yid)
    {
        //Data Array
        $data = array(
            'page_title' => 'Venue',
            'p_title' => 'Venue',
            'p_summary' => 'Show Venue Trashed Activity',
            'p_description' => null,
            'url' => route('manager.conference-year.venue.index', $yid),
            'url_text' => 'View All',
        );
        return view('manager.eventManagement.venue.trash')->with($data);
    }

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
            ->where('activity_log.event', 'deleted')
            ->where('activity_log.subject_type', Venue::class)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->where('activity_log.event', 'deleted')
            ->where('activity_log.subject_type', Venue::class)
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->where('activity_log.event', 'deleted')
            ->where('activity_log.subject_type', Venue::class)
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
