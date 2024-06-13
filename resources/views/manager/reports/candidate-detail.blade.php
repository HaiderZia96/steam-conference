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
                                    {{-- <label class="mb-1">Qualification</label>
                                    <select class="select2-options-degree form-control"
                                            id="degree_name">
                                        <option value="">All</option>
                                        @foreach($qualification as $q)
                                            <option value="{{$q->qualification}}"
                                                    @if(request()->qualification == $q->qualification) selected @endif>{{$q->qualification}}</option>
                                        @endforeach
                                    </select> --}}
                                    <label class="mb-1">Qualification</label>
                                <select class="select2-options-degree form-control"
                                         id="qualification">
                                    <option value="">All</option>
                                    @foreach($qualification as $q)
                                        <option value="{{$q->qualification}}">{{$q->qualification}}</option>
                                    @endforeach
                                    
                                </select>
                                    {{-- <input type="hidden" value="{{request()->qualification}}" id="qualification"> --}}
                                </div>
                                {{-- <div class="col-3">
                                    <label>Campus</label>
                                    <select class="form-select form-control" name="campus_id">
                                        <option value="">All</option>
                                        @foreach($campus as $cam)
                                            <option value="{{$cam->id}}"
                                                    @if(request()->campus_id == $cam->id) selected @endif>
                                                {{$cam->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" value="{{request()->campus_id}}" id="campus_id">
                                </div> --}}
                                {{-- @if(isset($isPaid))
                                    <div class="col-3">
                                        <label>Payment</label>
                                        <select class="form-select form-control" name="payment_status">
                                            <option value="">All</option>
                                            <option value="paid"
                                                    @if(request()->payment_status == "paid") selected @endif>
                                                Paid
                                            </option>
                                            <option value="not_paid"
                                                    @if(request()->payment_status == "not_paid") selected @endif>Not
                                                Paid
                                            </option>
                                        </select>
                                        <input type="hidden" value="{{request()->payment_status}}" id="payment_status">
                                    </div>
                                @endif --}}
                                {{-- <div class="col-3">
                                    <label>Attendance</label>
                                    <select class="form-select form-control" name="attendance_status">
                                        <option value="">All</option>
                                        <option value="present"
                                                @if(request()->attendance_status == "present") selected @endif>
                                            Present
                                        </option>
                                        <option value="absent"
                                                @if(request()->attendance_status == "absent") selected @endif>Absent
                                        </option>
                                    </select>
                                    <input type="hidden" value="{{request()->attendance_status}}"
                                           id="attendance_status">
                                </div> --}}
                                <div class="col-12 ">
                                    <div class="float-end mt-2">
                                        <button type="button" class="btn btn-sm btn-primary px-3"  onClick="selectRange()">
                                            Apply Filter
                                        </button>
                                        <a href="{{route('manager.report.candidate-detail',$session->id)}}"
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>Registration Type</th>
                            <th>Status Type</th>
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
            var attendance_status = $('#attendance_status').val();
            let URL = "{{ route('manager.report.get.candidate-detail', ':sid') }}";
            URL = URL.replace(':sid', {{$session->id}});
            //Datatable
            $('#indextable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                dom: 'lBfrtip', // Include 'l' to show the length menu
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        }
                    }
                ],
                lengthMenu: [[10, 20, 100,500, 10000], [10, 20, 100,500, 'All']],
                order: [[0, "desc"]],
                ajax: {
                    "type": "GET",
                    "url": URL,
                    "data": function (d) {
                        d.qualification = document.getElementById('qualification').value;
                    }
                },
                columns: [
                    {data: 'id', orderable: false},
                    {data: 'qualification', orderable: false},
                    {data: 'name', orderable: false},
                    {data: 'email', orderable: false},
                    {data: 'contact_no', orderable: false},
                    {data: 'registration_type_name', orderable: false},
                    {data: 'status_type_name', orderable: false},

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
                    },
                    
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
