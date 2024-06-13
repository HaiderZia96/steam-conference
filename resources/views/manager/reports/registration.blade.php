@extends('manager.layouts.app')
@section('page_title')
    {{(!empty($page_title) && isset($page_title)) ? $page_title : ''}}
@endsection
@push('head-scripts')
    <link href="{{ asset('manager/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('manager/select2/dist/css/select2-bootstrap5.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('manager/datatable/datatables.min.css') }}" rel="stylesheet"/>
    <style>
        .dataTables_length {
            margin-bottom: 10px;
        }
    </style>
@endpush
@section('content')
    @include('manager/inc.topHeader')
    <div class="card mt-3">
        <div class="card-body">
            {{-- Start: Page Content --}}
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">{{(!empty($p_title) && isset($p_title)) ? $p_title : ''}}</h4>
                    <div
                        class="small text-medium-emphasis">{{(!empty($p_summary) && isset($p_summary)) ? $p_summary : ''}}</div>
                </div>
            </div>
            <hr>
            {{-- Datatatble : Start --}}
            <div class="row">
                <div class="col-12 mb-4">
                    <fieldset class="reset-this redo-fieldset">
                        <legend class="reset-this redo-legend">Filters</legend>
                       
                            <div class="row gy-2 gx-3 align-items-center">
                               
                                <div class="col-3">
                                    <label class="mb-1">Qualification</label>
                                <select class="select2-options-degree form-control"
                                         id="qualification">
                                    <option value="">All</option>
                                    @foreach($qualification as $q)
                                        <option value="{{$q->qualification}}">{{$q->qualification}}</option>
                                    @endforeach
                                    
                                </select></div>
                                <div class="col-12 ">
                                    <div class="float-end mt-2">
                                        <button type="button" class="btn btn-sm btn-primary px-3"  onClick="selectRange()">
                                            Apply Filter
                                        </button>
                                        <a href="{{route('manager.report.registration',$session->id)}}"
                                           class="btn btn-sm btn-danger text-white px-3">
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                    
                    </fieldset>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="indextable"
                               class="table table-bordered table-striped table-hover table-responsive w-100 pt-1">
                            <thead class="table-dark">
                            <th>#</th>
                            <th>Qualification</th>
                            {{-- <th>Registration Type</th> --}}
                            <th>Registered Candidate</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Datatatble : End --}}
        </div>

        {{-- Page Description : Start --}}
        @if(!empty($p_description) && isset($p_description))
            <div class="card-footer">
                <div class="row">
                    <div class="col-12 mb-sm-2 mb-0">
                        <p>{{(!empty($p_description) && isset($p_description)) ? $p_description : ''}}</p>
                    </div>
                </div>
            </div>
        @endif
        {{-- Page Description : End --}}
        {{-- End: Page Content --}}
    </div>
@endsection
@push('footer-scripts')
    <script src="{{ asset('admin/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('manager/datatable/datatables.min.js')}}"></script>
    <script src="{{ asset('manager/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript">
        $('.select2-options-degree').select2({
           theme: "bootstrap5",
           allowClear: true,
           placeholder: 'All',
       });
   </script>
 <script type="text/javascript">

        $(document).ready(function () {
            var qualification = $('#qualification').val();
            // var degree_name = $('#degree_name').val();

            let URL = "{{ route('manager.report.get.registration', ':sid') }}";
            URL = URL.replace(':sid', {{$session->id}});
            //Datatable
            $('#indextable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                dom: 'lBfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                lengthMenu: [[10, 20, 100, 2000], [10, 20, 100, 'All']],
                order: [[0, "desc"]],
                ajax: {
                    "type": "GET",
                    "url": URL,
                    "data": function (d) {
                        d.qualification = document.getElementById('qualification').value;
                        // d.degree_name = degree_name;
                    }
                },
                columns: [
                    {data: 'id', orderable: false},
                    {data: 'qualification', orderable: false},
                    // {data: 'campus', orderable: false},
                    {data: 'register_candidate', orderable: false},

                ],
                columnDefs: [
                    {
                        targets: 0,
                        orderable: false,
                        searchable: false,
                        width: '20px',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },{
                        render: function (data, type, row, meta) {
                            var preview = '{{route('manager.conference-year.user-registration.index',[':id' ,':qualification' ])}}';
                            preview = preview.replace(':id', 3);
                            preview = preview.replace(':qualification', 'qualification='+row.qualification);
                            // preview = preview.replace(':campus_id', 'campus_id='+row.campus_id);

                            return '<a href="' + preview + '" class="nav-link" title="' + row.qualification + ' Interview" target="_blank">' + row.qualification + '<i class="cil-chevron-double-right btn btn-sm btn-primary ms-1 py-0 px-2"></i></a>';
                        },
                        searchable: false,
                        orderable: false,
                        targets: 1
                    }
                ]
            });
        });

        function selectRange() {
            $('.dataTable').DataTable().ajax.reload()
        }
    </script>
    {{-- Toastr : Script : Start --}}
    @if(Session::has('messages'))
        <script>
            noti({!! json_encode((Session::get('messages'))) !!});
        </script>
    @endif
    {{-- Toastr : Script : End --}}

@endpush
