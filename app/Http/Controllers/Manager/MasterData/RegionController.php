<?php

namespace App\Http\Controllers\Manager\MasterData;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Models\Activity;

class RegionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:manager_demographic-data_region-list', ['only' => ['index','getIndex']]);
        $this->middleware('permission:manager_demographic-data_region-activity-log', ['only' => ['getActivity','getActivityLog']]);
        $this->middleware('permission:manager_demographic-data_region-create', ['only' => ['create','store']]);
        $this->middleware('permission:manager_demographic-data_region-show', ['only' => ['show']]);
        $this->middleware('permission:manager_demographic-data_region-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:manager_demographic-data_region-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=[
            'page_title'=>'Region',
            'p_title'=>'Region',
            'p_summary'=>'List of Region',
            'p_description'=>null,
            'url'=>route('manager.region.create'),
            'url_text'=>'Add New',
            'trash'=>route('manager.get.region-activity-trash'),
            'trash_text'=>'View Trash',
        ];
        return view('manager.masterData.region.index')->with($data);
    }
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
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

        // Total records
        $totalRecords = Region::select('regions.*')->count();
        // Total records with filter
        $totalRecordswithFilter = Region::select('regions.*')
            ->where(function ($q) use ($searchValue){
                $q->where('regions.name', 'like', '%' .$searchValue . '%');
            })
            ->count();
        // Fetch records
        $records = Region::select('regions.*')
            ->where(function ($q) use ($searchValue){
                $q->where('regions.name', 'like', '%' .$searchValue . '%');
            })
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName,$columnSortOrder)
            ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;
            $description = $record->description;

            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "description" => $description,
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getIndexSelect(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = Region::select('regions.id as id','regions.name as name')
                ->where(function ($q) use ($search){
                    $q->where('regions.name', 'like', '%' .$search . '%');
                })
                ->get();
        }

        return response()->json($data);

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = array(
            'page_title'=>'Region',
            'p_title'=>'Region',
            'p_summary'=>'Add Region',
            'p_description'=>null,
            'method' => 'POST',
            'action' => route('manager.region.store'),
            'url'=>route('manager.region.index'),
            'url_text'=>'View All',
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.masterData.region.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:regions,name',
            'description' => 'nullable|description',
        ]);
        //
        $arr =  [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ];
        $record = Region::create($arr);
        $messages =  [
            array(
                'message' => 'Record created successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.region.index');
    }

    /**
     * Display the specified resource.
     * @param  String_  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $record = Region::select('regions.*')
            ->where('id', '=' ,$id )
            ->first();
        if (empty($record)){
            abort(404, 'NOT FOUND');
        }
        // Add activity logs
        $user = Auth::user();
        activity('Region')
            ->performedOn($record)
            ->causedBy($user)
            ->event('viewed')
            ->withProperties(['attributes' => ['name'=>$record->name]])
            ->log('viewed');
        //Data Array
        $data = array(
            'page_title'=>'Region',
            'p_title'=>'Region',
            'p_summary'=>'Show Region',
            'p_description'=>null,
            'method' => 'POST',
            'action' => route('manager.region.update',$record->id),
            'url'=>route('manager.region.index'),
            'url_text'=>'View All',
            'data'=>$record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.masterData.region.show')->with($data);
    }
    /**
     * Show the form for editing the specified resource.
     * @param  String_  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $record = Region::select('regions.*')
            ->where('id', '=' ,$id )
            ->first();
        if (empty($record)){
            abort(404, 'NOT FOUND');
        }
        $data = array(
            'page_title'=>'Region',
            'p_title'=>'Region',
            'p_summary'=>'Edit Region',
            'p_description'=>null,
            'method' => 'POST',
            'action' => route('manager.region.update',$record->id),
            'url'=>route('manager.region.index'),
            'url_text'=>'View All',
            'data'=>$record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.masterData.region.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param  String_  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $record = Region::select('regions.*')
            ->where('id', '=' ,$id )
            ->first();
        if (empty($record)){
            abort(404, 'NOT FOUND');
        }
        $this->validate($request, [
            'name' => 'required|unique:regions,name,'.$record->id,
            'description' => 'nullable|description'
        ]);
        //
        $arr =  [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ];
        $record->update($arr);
        $messages =  [
            array(
                'message' => 'Record updated successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.region.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param  String_  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $record = Region::select('regions.*')
            ->where('id', '=' ,$id )
            ->first();
        if (empty($record)){
            abort(404, 'NOT FOUND');
        }
        $record->delete();

        $messages =  [
            array(
                'message' => 'Record deleted successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.region.index');
    }
    /**
     * Display the specified resource Activity.
     * @param  String_  $id
     * @return \Illuminate\Http\Response
     */
    public function getActivity(string $id)
    {
        //Data Array
        $data = array(
            'page_title'=>'Region Activity',
            'p_title'=>'Region Activity',
            'p_summary'=>'Show Region Activity',
            'p_description'=>null,
            'url'=>route('manager.region.index'),
            'url_text'=>'View All',
            'id'=>$id,
        );
        return view('manager.masterData.region.activity')->with($data);
    }
    /**
     * Display the specified resource Activity Logs.
     * @param  String_  $id
     * @return \Illuminate\Http\Response
     */
    public function getActivityLog(Request $request,string $id)
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
        $totalRecords = Activity::select('activity_log.*','users.name as causer')
            ->leftJoin('users','users.id','activity_log.causer_id')
            ->leftJoin('regions','regions.id','activity_log.subject_id')
            ->where('activity_log.subject_type',Region::class)
            ->where('activity_log.subject_id',$id)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*','users.name as causer')
            ->leftJoin('users','users.id','activity_log.causer_id')
            ->leftJoin('regions','regions.id','activity_log.subject_id')
            ->where('activity_log.subject_id',$id)
            ->where('activity_log.subject_type',Region::class)
            ->where(function ($q) use ($searchValue){
                $q->where('activity_log.description', 'like', '%' .$searchValue . '%')
                    ->orWhere('users.name', 'like', '%' .$searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*','users.name as causer')
            ->leftJoin('users','users.id','activity_log.causer_id')
            ->leftJoin('regions','regions.id','activity_log.subject_id')
            ->where('activity_log.subject_id',$id)
            ->where('activity_log.subject_type',Region::class)
            ->where(function ($q) use ($searchValue){
                $q->where('activity_log.description', 'like', '%' .$searchValue . '%')
                    ->orWhere('users.name', 'like', '%' .$searchValue . '%');
            })
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName,$columnSortOrder)
            ->get();


        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $attributes = (!empty($record->properties['attributes']) ? $record->properties['attributes'] : '');
            $old = (!empty($record->properties['old']) ? $record->properties['old'] : '');
            $current='<ul class="list-unstyled">';
            //Current
            if (!empty($attributes)){
                foreach ($attributes as $key => $value){
                    if (is_array($value)) {
                        $current .= '<li>';
                        $current .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $current .= '</li>';
                    }
                    else{
                        $current .= '<li>';
                        $current .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $current .= '</li>';
                    }
                }
            }
            $current.='</ul>';
            //Old
            $oldValue='<ul class="list-unstyled">';
            if (!empty($old)){
                foreach ($old as $key => $value){
                    if (is_array($value)) {
                        $oldValue .= '<li>';
                        $oldValue .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $oldValue .= '</li>';
                    }
                    else{
                        $oldValue .= '<li>';
                        $oldValue .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $oldValue .= '</li>';
                    }
                }
            }
            //updated at
            $updated = 'Updated:'.$record->updated_at->diffForHumans().'<br> At:'.$record->updated_at->isoFormat('llll');
            $oldValue.='</ul>';
            //Causer
            $causer = isset($record->causer) ? $record->causer : '';
            $type= $record->description;
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
            'page_title'=>'Region Activity',
            'p_title'=>'Region Activity',
            'p_summary'=>'Show Region Trashed Activity',
            'p_description'=>null,
            'url'=>route('manager.region.index'),
            'url_text'=>'View All',
        );
        return view('manager.masterData.region.trash')->with($data);
    }
    /**
     * Display the trash resource Activity Logs.
     * @param  String_  $id
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
        $totalRecords = Activity::select('activity_log.*','users.name as causer')
            ->leftJoin('users','users.id','activity_log.causer_id')
            ->leftJoin('regions','regions.id','activity_log.subject_id')
            ->where('activity_log.subject_type',Region::class)
            ->where('activity_log.event','deleted')
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*','users.name as causer')
            ->leftJoin('users','users.id','activity_log.causer_id')
            ->leftJoin('regions','regions.id','activity_log.subject_id')
            ->where('activity_log.subject_type',Region::class)
            ->where('activity_log.event','deleted')
            ->where(function ($q) use ($searchValue){
                $q->where('activity_log.description', 'like', '%' .$searchValue . '%')
                    ->orWhere('users.name', 'like', '%' .$searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*','users.name as causer')
            ->leftJoin('users','users.id','activity_log.causer_id')
            ->leftJoin('regions','regions.id','activity_log.subject_id')
            ->where('activity_log.subject_type',Region::class)
            ->where('activity_log.event','deleted')
            ->where(function ($q) use ($searchValue){
                $q->where('activity_log.description', 'like', '%' .$searchValue . '%')
                    ->orWhere('users.name', 'like', '%' .$searchValue . '%');
            })
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName,$columnSortOrder)
            ->get();


        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $attributes = (!empty($record->properties['attributes']) ? $record->properties['attributes'] : '');
            $old = (!empty($record->properties['old']) ? $record->properties['old'] : '');
            $current='<ul class="list-unstyled">';
            //Current
            if (!empty($attributes)){
                foreach ($attributes as $key => $value){
                    if (is_array($value)) {
                        $current .= '<li>';
                        $current .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $current .= '</li>';
                    }
                    else{
                        $current .= '<li>';
                        $current .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $current .= '</li>';
                    }
                }
            }
            $current.='</ul>';
            //Old
            $oldValue='<ul class="list-unstyled">';
            if (!empty($old)){
                foreach ($old as $key => $value){
                    if (is_array($value)) {
                        $oldValue .= '<li>';
                        $oldValue .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $oldValue .= '</li>';
                    }
                    else{
                        $oldValue .= '<li>';
                        $oldValue .= '<i class="fas fa-angle-right"></i> <em></em>' . $key . ': <mark>' . $value . '</mark>';
                        $oldValue .= '</li>';
                    }
                }
            }
            //updated at
            $updated = 'Updated:'.$record->updated_at->diffForHumans().'<br> At:'.$record->updated_at->isoFormat('llll');
            $oldValue.='</ul>';
            //Causer
            $causer = isset($record->causer) ? $record->causer : '';
            $type= $record->description;
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
