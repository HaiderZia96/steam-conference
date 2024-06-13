<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Publication;
use App\Models\PublicationType;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $publicationTypes = PublicationType::get();
        $departments = Department::get();
        return view('front.publication', compact('publicationTypes', 'departments'));
    }


    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getPublication(Request $request)
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
        if (!empty($request->get('pubType'))) {
            $publicationType = $request->get('pubType');
            $var = ['publications.publication_type_id', '=', $publicationType];
            array_push($where, $var);
        }

        /** Filter Out Records for Department **/
        if (!empty($request->get('dptID'))) {
            $department = $request->get('dptID');
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
