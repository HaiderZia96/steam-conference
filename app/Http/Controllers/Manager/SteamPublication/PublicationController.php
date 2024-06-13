<?php

namespace App\Http\Controllers\Manager\SteamPublication;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Publication;
use App\Models\PublicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class PublicationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:manager_steam-publication_publication-list', ['only' => ['index', 'getIndex']]);
        $this->middleware('permission:manager_steam-publication_publication-activity-log', ['only' => ['getActivity', 'getActivityLog']]);
        $this->middleware('permission:manager_steam-publication_publication-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:manager_steam-publication_publication-show', ['only' => ['show']]);
        $this->middleware('permission:manager_steam-publication_publication-download', ['only' => ['download']]);
        $this->middleware('permission:manager_steam-publication_publication-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:manager_steam-publication_publication-delete', ['only' => ['destroy']]);
        $this->middleware('permission:manager_steam-publication_publication-activity-log-trash', ['only' => ['getTrashActivity', 'getTrashActivityLog']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'page_title' => 'Publication',
            'p_title' => 'Publication',
            'p_summary' => 'List of Publication',
            'p_description' => null,
            'url' => route('manager.publication.create'),
            'url_text' => 'Add New',
            'trash' => route('manager.get.publication-activity-trash'),
            'trash_text' => 'View Trash',
        ];
        return view('manager.steamPublication.publication.index')->with($data);
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

        /** Filter Out Records for Publication Type **/
        if (!empty($request->get('publication_type_id'))) {
            $publicationType = $request->get('publication_type_id');
            $var = ['publications.publication_type_id', '=', $publicationType];
            array_push($where, $var);
        }

        /** Filter Out Records for Department **/
        if (!empty($request->get('department_id'))) {
            $department = $request->get('department_id');
            $var = ['publications.department_id', '=', $department];
            array_push($where, $var);
        }

        // Total records
        $totalRecords = Publication::with('publicationTypes', 'departments')
            ->where($where)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Publication::with('publicationTypes', 'departments')
            ->where(function ($q) use ($searchValue) {
                $q->where('publications.title', 'like', '%' . $searchValue . '%')
                    ->orWhere(function ($query) use ($searchValue) {
                        $query->orWhereHas('publicationTypes', function ($subQuery) use ($searchValue) {
                            $subQuery->where('publication_types.name', 'like', '%' . $searchValue . '%');
                        })->orWhereHas('departments', function ($subQuery) use ($searchValue) {
                            $subQuery->where('departments.name', 'like', '%' . $searchValue . '%');
                        });
                    });
            })
            ->where($where)
            ->count();


        // Fetch records
        $records = Publication::with('publicationTypes', 'departments')
            ->where(function ($q) use ($searchValue) {
                $q->where('publications.title', 'like', '%' . $searchValue . '%')
                    ->orWhere(function ($query) use ($searchValue) {
                        $query->orWhereHas('publicationTypes', function ($subQuery) use ($searchValue) {
                            $subQuery->where('publication_types.name', 'like', '%' . $searchValue . '%');
                        })->orWhereHas('departments', function ($subQuery) use ($searchValue) {
                            $subQuery->where('departments.name', 'like', '%' . $searchValue . '%');
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
            $author = (isset($record->author) ? $record->author : '');
            $doc_file = (isset($record->doc_file) ? $record->doc_file : '');
            $publication_type = (isset($record->publicationTypes->name) ? $record->publicationTypes->name : '');
            $department = (isset($record->departments->name) ? $record->departments->name : '');

            $data_arr[] = array(
                "id" => $id,
                "title" => $title,
                "author" => $author,
                "doc_file" => $doc_file,
                "publication_type" => $publication_type,
                "department" => $department,
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
            'page_title' => 'Publication',
            'p_title' => 'Publication',
            'p_summary' => 'Add Publication',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.publication.store'),
            'url' => route('manager.publication.index'),
            'url_text' => 'View All',
            'enctype' => 'multipart/form-data' // (Default)Without attachment
//            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.steamPublication.publication.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'doc_file' => 'required|mimes:jpg,png,jpeg,pdf',
            'publication_type' => 'required|exists:publication_types,id',
            'department' => 'required|exists:departments,id',
        ]);


        //
        $arr = [
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'publication_type_id' => $request->input('publication_type'),
            'department_id' => $request->input('department'),
            'created_by' => Auth::user()->id,
        ];


        if ($request->hasFile('doc_file')) {
            $file = $request->file('doc_file');
            $fileOriginalName = $file->getClientOriginalName();
            $filename = pathinfo($fileOriginalName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();

            $folderPath = public_path('front/publication/');

            // add timestamp to filename
            $filenameWithTimestamp = $filename . '-' . time() . '.' . $extension;

            $request->doc_file->move($folderPath, $filenameWithTimestamp);

            $arr['doc_file'] = $filenameWithTimestamp;

        }

        Publication::create($arr);
        $messages = [
            array(
                'message' => 'Record created successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.publication.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = Publication::with('departments', 'publicationTypes')
            ->where('publications.id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        // Add activity logs
        $user = Auth::user();
        activity('Publication')
            ->performedOn($record)
            ->causedBy($user)
            ->event('viewed')
            ->withProperties(['attributes' => ['name' => $record->name]])
            ->log('viewed');
        //Data Array
        $data = array(
            'page_title' => 'Publication',
            'p_title' => 'Publication',
            'p_summary' => 'Show Publication',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.publication.update', $record->id),
            'url' => route('manager.publication.index'),
            'url_text' => 'View All',
            'data' => $record,
            // 'enctype' => 'multipart/form-data' // (Default)Without attachment
            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.steamPublication.publication.show')->with($data);
    }


    /**
     * Download file for the specified resource.
     */
    public function download(string $id)
    {
        $record = Publication::select('publications.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        $file = $record->doc_file;
        $path = public_path('front/publication/' . $file);
//        $filename = Str::beforeLast($file, '-'). '.' . Str::afterLast($file, '.');
        $filename = preg_replace_array('/-[0-9]+/', [''], $file);

        return response()->download($path, $filename);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = Publication::with('departments', 'publicationTypes')
            ->where('publications.id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $data = array(
            'page_title' => 'Publication',
            'p_title' => 'Publication',
            'p_summary' => 'Edit Publication',
            'p_description' => null,
            'method' => 'POST',
            'action' => route('manager.publication.update', $record->id),
            'url' => route('manager.publication.index'),
            'url_text' => 'View All',
            'data' => $record,
            'enctype' => 'multipart/form-data' // (Default)Without attachment
//            'enctype' => 'application/x-www-form-urlencoded', // With attachment like file or images in form
        );
        return view('manager.steamPublication.publication.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = Publication::select('publications.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }
        $this->validate($request, [
            'title' => 'required',
            'doc_file' => 'mimes:jpg,png,jpeg,pdf',
            'publication_type' => 'required|exists:publication_types,id',
            'department' => 'required|exists:departments,id',
        ]);
        //
        $arr = [
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'publication_type_id' => $request->input('publication_type'),
            'department_id' => $request->input('department'),
            'updated_by' => Auth::user()->id,
        ];

        if ($request->hasFile('doc_file')) {
            // delete the previous file
            $delFile = public_path('/front/publication/' . $record->doc_file);
            File::delete($delFile);

            $file = $request->file('doc_file');
            $fileOriginalName = $file->getClientOriginalName();
            $filename = pathinfo($fileOriginalName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();

            $folderPath = public_path('front/publication/');

            // add timestamp to filename
            $filenameWithTimestamp = $filename . '-' . time() . '.' . $extension;

            $request->doc_file->move($folderPath, $filenameWithTimestamp);

            $arr['doc_file'] = $filenameWithTimestamp;

        }

        $record->update($arr);
        $messages = [
            array(
                'message' => 'Record updated successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.publication.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Publication::select('publications.*')
            ->where('id', '=', $id)
            ->first();
        if (empty($record)) {
            abort(404, 'NOT FOUND');
        }

        // delete the file
        $delFile = public_path('/front/publication/' . $record->doc_file);
        File::delete($delFile);

        $record->delete();

        $messages = [
            array(
                'message' => 'Record deleted successfully',
                'message_type' => 'success'
            ),
        ];
        Session::flash('messages', $messages);

        return redirect()->route('manager.publication.index');
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
            'page_title' => 'Publication Activity',
            'p_title' => 'Publication Activity',
            'p_summary' => 'Show Publication Activity',
            'p_description' => null,
            'url' => route('manager.publication.index'),
            'url_text' => 'View All',
            'id' => $id,
        );
        return view('manager.steamPublication.publication.activity')->with($data);
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
            ->leftJoin('publications', 'publications.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', Publication::class)
            ->where('activity_log.subject_id', $id)
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('publications', 'publications.id', 'activity_log.subject_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', Publication::class)
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('publications', 'publications.id', 'activity_log.subject_id')
            ->where('activity_log.subject_id', $id)
            ->where('activity_log.subject_type', Publication::class)
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
            'page_title' => 'Publication Activity',
            'p_title' => 'Publication Activity',
            'p_summary' => 'Show Publication Trashed Activity',
            'p_description' => null,
            'url' => route('manager.publication.index'),
            'url_text' => 'View All',
        );
        return view('manager.steamPublication.publication.trash')->with($data);
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
            ->leftJoin('publications', 'publications.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', Publication::class)
            ->where('activity_log.event', 'deleted')
            ->count();

        // Total records with filter
        $totalRecordswithFilter = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('publications', 'publications.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', Publication::class)
            ->where('activity_log.event', 'deleted')
            ->where(function ($q) use ($searchValue) {
                $q->where('activity_log.description', 'like', '%' . $searchValue . '%')
                    ->orWhere('users.name', 'like', '%' . $searchValue . '%');
            })
            ->count();

        // Fetch records
        $records = Activity::select('activity_log.*', 'users.name as causer')
            ->leftJoin('users', 'users.id', 'activity_log.causer_id')
            ->leftJoin('publications', 'publications.id', 'activity_log.subject_id')
            ->where('activity_log.subject_type', Publication::class)
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
