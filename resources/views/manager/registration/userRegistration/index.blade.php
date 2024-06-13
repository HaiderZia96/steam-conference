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
    <div class="card mt-3">
        <div class="card-body">
            {{-- Start: Page Content --}}
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">{{(!empty($p_title) && isset($p_title)) ? $p_title : ''}}</h4>
                    <div
                        class="small text-medium-emphasis">{{(!empty($p_summary) && isset($p_summary)) ? $p_summary : ''}}</div>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    @can('manager_registration_user-registration-create')
                        <a href="{{(!empty($url) && isset($url)) ? $url : ''}}"
                           class="btn btn-sm btn-primary">{{(!empty($url_text) && isset($url_text)) ? $url_text : ''}}</a>
                    @endcan
                    @can('manager_registration_user-registration-activity-log-trash')
                        <a href="{{(!empty($trash) && isset($trash)) ? $trash : ''}}"
                           class="btn btn-sm btn-danger">{{(!empty($trash_text) && isset($trash_text)) ? $trash_text : ''}}</a>
                    @endcan
                </div>

            </div>
            <hr>
            {{-- Datatatble : Start --}}
            <div class="row">
                <div class="col-12 mb-4">
                    <fieldset class="reset-this redo-fieldset" style="margin-bottom: 10px">
                        <legend class="reset-this redo-legend">Filters</legend>
                        <div class="row gy-2 gx-3 align-items-center">
                            <div class="col-3">
                                <label class="mb-1">Registeration Type</label>
                                <select class="select2-options-degree form-control"
                                         id="registration_type_id">
                                    <option value="">All</option>
                                    @foreach($registration_types as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="col-3">
                                <label class="mb-1">Registeration Status</label>
                                <select class="select2-options-degree form-control"
                                        id="status_type_id">
                                    <option value="">All</option>
                                    @foreach($status_types as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                           
                            <div class="col-3">
                                <label class="mb-1">Qualification</label>
                                {{-- {{dd(request()->qualification)}} --}}
                            <select class="select2-options-degree form-control"
                                     id="qualification">
                                <option value="">All</option>
                                @foreach($qualifications as $q)
                                    {{-- <option value="{{$q}}">{{$q}}</option> --}}
                                    <option value="{{$q->qualification}}"
                                        @if(request()->qualification == $q->qualification) selected @endif>{{$q->qualification}}
                                @endforeach
                                
                            </select></div>
                        </div>
                        <div class="row float-end">
                            <div class="col-auto">
                                <button type="button" class="btn btn-sm btn-primary mt-3" onClick="selectRange()">
                                    Apply Filter
                                </button>
                                <a href="" class="btn btn-sm btn-danger text-white px-3 mt-3">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </fieldset>
                    <div class="table-responsive">
                        <table id="indextable"
                               class="table table-bordered table-striped table-hover table-responsive w-100 pt-1">
                            <thead class="table-dark">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Qualification</th>
                            <th>Session</th>
                            <th>Registration Type</th>
                            <th>Payment Type</th>
                            <th>Payment Status</th>
                            <th>Voucher</th>
                            <th>Gate Pass</th>
                            <th>Status</th>
                            {{-- <th>Certificate</th> --}}
                            <th>Actions</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            {{-- Datatatble : End --}}
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

            {{-- Delete Confirmation Model : Start --}}
            <div class="del-model-wrapper">
                <div class="modal fade" id="del-model-delete" tabindex="-1" aria-labelledby="del-model-delete"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close shadow-none" data-coreui-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="font-weight-bold mb-2"> Are you sure you wanna delete this ?</p>
                                <p class="text-muted "> This item will be deleted immediately. You can't undo this
                                    action.</p>
                            </div>
                            <div class="modal-footer">
                                <form method="POST" id="del-form">
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <button type="button" class="btn btn-light" data-coreui-dismiss="modal">Cancel
                                    </button>
                                    <button type="submit" class="btn btn-danger">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Delete Confirmation Model : End --}}

            {{-- Upload Voucher Model : Start --}}
            <div class="upload-model-wrapper">
                <div class="modal fade" id="upload-model" tabindex="-1" aria-labelledby="upload-model"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close shadow-none" data-coreui-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h5 class="font-weight-bold text-center">Upload Voucher</h5>
                            </div>
                            <div class="my-2">
                                <form method="POST" id="upload-form" enctype="multipart/form-data">
                                    @csrf
                                    {{method_field('PUT')}}
                                    <div class="row px-3">
                                        <div class="col-md-12">
                                            <input type="file" name="voucher_upload" class="form-control" id=""
                                                   value="voucher_upload">
                                                   <p class="mt-2" style="color: red"><strong>Note: </strong> Only .pdf, .jpg, .png, .jpeg format are allowed.</p>
                                        </div>
                                        <div class="col-md-12 mt-3 text-center">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                {{ __('Submit') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Voucher Upload Model : End --}}
            {{-- End: Page Content --}}
        </div>
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
            var yid = {{$sdata}};
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
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10]
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10]
                        }
                    }
                ],
                lengthMenu: [[10, 20, 100,500, 10000], [10, 20, 100,500, 'All']],
                order: [[0, "desc"]],
                ajax: {
                    "type": "GET",
                    "url": "{{route('manager.get.user-registration')}}",
                    "data": function (d) {
                        d.yid = yid;
                        d.registration_type_id = document.getElementById('registration_type_id').value;
                        d.status_type_id = document.getElementById('status_type_id').value;
                        d.qualification = document.getElementById('qualification').value;
                    }
                },
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'qualification'},
                    {data: 'conference_year_name'},
                    {data: 'registration_type_name'}, 
                    {data: 'payment_type_name'},
                    {data: 'status_type_name'},
                    {data: null},
                    // {data: null},
                    {data: null},
                    {data: null},
                    {data: null},
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
                   
                    {
                        targets: 8,
                        searchable: false,
                        orderable: false,

                        render: function (data, type, row, meta) {

                            var voucher = '{{ route("manager.download-voucher", ":id") }}';
                            voucher = voucher.replace(':id', data.id);

                            var upload = '{{ route("manager.upload-voucher", [":yid",":id"]) }}';
                            upload = upload.replace(':yid', {{$sdata}});
                            upload = upload.replace(':id', data.id);

                            var view = '{{ route("manager.get.voucher-image", ":id") }}';
                            view = view.replace(':id', data.id);
                        if (data.payment_type_name != 'Onsite Payment'){
                            if (data.voucher_upload == null) {

                                if ((data.registration_type_name == 'Tufians' || 'Non-Tufians') ) {

                                    if (data.voucher_upload == null) {
                                        return '<div class="d-flex">' +
                                            @can('manager_registration_user-registration-voucher-download')
                                                '<a href="' + voucher + '" class="btn btn-sm btn-primary mx-2"><i class="fa fa-download text-white"></i></a>' +
                                            @endcan
                                                @can('manager_registration_user-registration-voucher-upload')
                                                '<a class="me-1" href="javascript:void(0)"><span type="button" class="btn btn-sm btn-success" data-url="' + upload + '" data-coreui-toggle="modal" data-coreui-target="#upload-model"><i class="fa fa-upload text-white"></i></span></a>' +
                                            @endcan
                                                '</div>';
                                    } else {
                                        return '<div class="d-flex">' +
                                            @can('manager_registration_user-registration-voucher-view')
                                                '<a href="' + view + '" class="btn btn-sm btn-primary mx-2" target="_blank"><i class="fa fa-eye text-white"></i></a>' +
                                            @endcan
                                                '</div>';
                                    }
                                }
                                if (data.status_type_name == 'Approved') {
                                    return '<div class="d-flex">' +
                                        '<p>No Voucher</p>' +
                                        '</div>';
                                } else {
                                    return '<div class="d-flex">' +
                                        @can('manager_registration_user-registration-voucher-download')
                                            '<a href="' + voucher + '" class="btn btn-sm btn-primary mx-2" data-coreui-toggle="tooltip" data-coreui-placement="top" title="Download Voucher"><i class="fa fa-download text-white"></i></a>' +
                                        @endcan
                                            @can('manager_registration_user-registration-voucher-upload')
                                            '<a class="me-1" href="javascript:void(0)"><span type="button" class="btn btn-sm btn-success" data-url="' + upload + '" data-coreui-toggle="modal" data-coreui-target="#upload-model" title="Upload Voucher"><i class="fa fa-upload text-white"></i></span></a>' +
                                        @endcan
                                            '</div>';
                                }

                            } else if (data.status_type_name == 'Rejected') {
                                return '<div class="d-flex">' +
                                    @can('manager_registration_user-registration-voucher-download')
                                        '<a href="' + voucher + '" class="btn btn-sm btn-primary mx-2" data-coreui-toggle="tooltip" data-coreui-placement="top" title="Download Voucher"><i class="fa fa-download text-white"></i></a>' +
                                    @endcan
                                        @can('manager_registration_user-registration-voucher-upload')
                                        '<a class="me-1" href="javascript:void(0)"><span type="button" class="btn btn-sm btn-success" data-url="' + upload + '" data-coreui-toggle="modal" data-coreui-target="#upload-model" title="Upload Voucher"><i class="fa fa-upload text-white"></i></span></a>' +
                                    @endcan
                                        '</div>';
                                        
                            } 
                            else if (data.status_type_name == 'Not Submitted' && data.voucher_upload == null) {
                                return '<div class="d-flex">' +
                                    @can('manager_registration_user-registration-voucher-download')
                                        '<a href="' + voucher + '" class="btn btn-sm btn-primary mx-2" data-coreui-toggle="tooltip" data-coreui-placement="top" title="Download Voucher"><i class="fa fa-download text-white"></i></a>' +
                                    @endcan
                                        @can('manager_registration_user-registration-voucher-upload')
                                        '<a class="me-1" href="javascript:void(0)"><span type="button" class="btn btn-sm btn-success" data-url="' + upload + '" data-coreui-toggle="modal" data-coreui-target="#upload-model" title="Upload Voucher"><i class="fa fa-upload text-white"></i></span></a>' +
                                    @endcan
                                        '</div>';
                                        
                            }
                            else {
                                return '<div class="d-flex">' +
                                    @can('manager_registration_user-registration-voucher-view')
                                        '<a href="' + view + '" class="btn btn-sm btn-primary mx-2" target="_blank"><i class="fa fa-eye text-white"></i></a>' +
                                    @endcan
                                        '</div>';
                            }
                           
                            
                        }
                        else{
                            return '<div class="d-flex">' + '</div>';
                        }
                        },

                    },
                    {
                        targets: 9,
                        orderable: false,
                        className: 'perm_col',
                        render: function (data, type, row, meta) {

                            var gatePass = '{{ route("manager.download-gate-pass", ":id") }}';
                            gatePass = gatePass.replace(':id', data.id);


                            @can('manager_registration_user-registration-gate-pass-download')
                        if (data.status_type_name == 'Approved') {
                                return '<div class="d-flex">' +
                                    '<a href="' + gatePass + '"><span class="btn btn-sm btn-warning mx-2"><i class="fa fa-download text-white"></i></span></a>'
                                '</div>';
                            } else {
                                return '<div class="d-flex">' +
                                    // '<span class="badge bg-secondary mx-2">Pending</span>' +
                                    '</div>';
                            }
                            @endcan
                        }
                    },
                    {
                        targets: 10,
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row, meta) {
                            if (data.status == 0) {
                                return '<div class="d-flex">' +
                                    'Inactive' +
                                    '</div>'
                            } else {
                                return '<div class="d-flex">' +
                                    'Active' +
                                    '</div>'
                            }
                        }
                    },
                    // {
                    //     targets: 8,
                    //     orderable: false,
                    //     className: 'perm_col',
                    //     render: function (data, type, row, meta) {

                    //         var certificate = '{{ route("manager.download-certificate", ":id") }}';
                    //         certificate = certificate.replace(':id', data.id);

                    //         {{--                            @can('manager_registration_user-registration-gate-pass-download')--}}
                    //         if (data.attendee_status == 0) {
                    //             return '<div class="d-flex">' +'</div>';
                    //         } else if (data.attendee_status == 1) {
                    //             return '<div class="d-flex">' +
                    //                 '<a href="' + certificate + '"><span class="btn btn-sm btn-dark mx-2"><i class="fa fa-download text-white"></i></span></a>'
                    //             '</div>';
                    //         }
                    //         {{--@endcan--}}

                    //     }
                    // },
                    
                    {
                        targets: -1,
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row, meta) {

                            let PAPER_SUBMISSION = "{{ route('manager.conference-year.user-registration.paper-submission.index',[':yid',':uid']) }}";
                            PAPER_SUBMISSION = PAPER_SUBMISSION.replace(':uid', row.id);
                            PAPER_SUBMISSION = PAPER_SUBMISSION.replace(':yid', {{$sdata}});

                            let URL = "{{route('manager.conference-year.user-registration.show',[':yid',':id'] )}}";
                            URL = URL.replace(':id', row.id);
                            URL = URL.replace(':yid', {{$sdata}});

                            let ACTIVITY = "{{ route('manager.get.user-registration-activity', [':yid',':id']) }}";
                            ACTIVITY = ACTIVITY.replace(':id', row.id);
                            ACTIVITY = ACTIVITY.replace(':yid', {{$sdata}});

                            let STATUS = "{{ route('manager.get.user-registration-status', [':yid',':id']) }}";
                            STATUS = STATUS.replace(':id', row.id);
                            STATUS = STATUS.replace(':yid', {{$sdata}});

                            let CERTIFICATE = "{{ route('manager.get.user-registration-certificate-status', [':yid',':id']) }}"
                            CERTIFICATE = CERTIFICATE.replace(':id', row.id);
                            CERTIFICATE = CERTIFICATE.replace(':yid', {{$sdata}});

                            let active = "{{ route('manager.candidate-status', [':yid' , ':id']) }}";
                            active = active.replace(':yid', {{$sdata}});
                            active = active.replace(':id', row.user_id);
                            // console.log('data.status:', active);
                          
                         if (data.status == '0'){
                                
                            return '<div class="d-flex">' +
                                @can('manager_registration_user-registration-edit')
                                        '<a class="me-2 px-2" href="' + active + '"><span class="badge bg-success text-white">Active</span></a>  |' +
                                @endcan
                                @can('manager_registration_user-registration-show')
                                    '<a class="me-1" href="' + URL + '"><span class="badge bg-success text-dark">Show</span>' +
                                @endcan
                                    @can('manager_registration_user-registration-edit')
                                    '<a class="me-1" href="' + URL + '/edit"><span class="badge bg-info text-dark">Edit</span></a>' +
                                @endcan
                                    @can('manager_registration_user-registration-activity-log')
                                    '<a class="me-1" href="' + ACTIVITY + '"><span class="badge bg-warning text-dark">Activity</span></a>' +
                                @endcan
                                    @can('manager_registration_user-registration-delete')
                                    '<a class="me-2" href="javascript:void(0)"><span type="button" class="badge bg-danger" data-url="' + URL + '" data-coreui-toggle="modal" data-coreui-target="#del-model-delete">Delete</span></a>' +
                                @endcan
                                    '|' +
                                @can('manager_master-data_status-type-status-edit')
                                generateStatusElement() +
                                @endcan
                                    '|' +
                                @can('manager_registration_paper-submission-list')
                                    '<a class="mx-2" href="' + PAPER_SUBMISSION + '"><span class="badge bg-dark text-light">Paper</span>' +
                                @endcan
                                // '|' + '<br>'+
                                @can('manager_master-data_certificate-status-edit')
                                    candidateStatus() 
                                @endcan
                                // Check if data is approved or rejected and set the badge color accordingly
                               
                            
                                    '</div>'}
                                    else{
                          
                                    return '<div class="d-flex">' +
                                @can('manager_registration_user-registration-edit')
                                        '<a class="me-2 px-2" href="' + active + '"><span class="badge bg-danger text-white">DeActive</span></a>  |' +
                                @endcan
                                @can('manager_registration_user-registration-show')
                                    '<a class="me-1" href="' + URL + '"><span class="badge bg-success text-dark">Show</span>' +
                                @endcan
                                    @can('manager_registration_user-registration-edit')
                                    '<a class="me-1" href="' + URL + '/edit"><span class="badge bg-info text-dark">Edit</span></a>' +
                                @endcan
                                    @can('manager_registration_user-registration-activity-log')
                                    '<a class="me-1" href="' + ACTIVITY + '"><span class="badge bg-warning text-dark">Activity</span></a>' +
                                @endcan
                                    @can('manager_registration_user-registration-delete')
                                    '<a class="me-2" href="javascript:void(0)"><span type="button" class="badge bg-danger" data-url="' + URL + '" data-coreui-toggle="modal" data-coreui-target="#del-model-delete">Delete</span></a>' +
                                @endcan
                                    '|' +
                                @can('manager_master-data_status-type-status-edit')
                                generateStatusElement() +
                                @endcan
                                    '|' +
                                @can('manager_registration_paper-submission-list')
                                    '<a class="mx-2" href="' + PAPER_SUBMISSION + '"><span class="badge bg-dark text-light">Paper</span>' +
                                @endcan
                                // '|' + '<br>'+
                                @can('manager_master-data_certificate-status-edit')
                                    candidateStatus() 
                                @endcan
                                // Check if data is approved or rejected and set the badge color accordingly
                               
                            
                                    '</div>'}
                        
                          // get Status
                          function generateStatusElement() {
                                let statusElement = '';
                                if (data.status_type_name === 'Approved') {
                                    statusElement += '<a class="mx-2" href="' + STATUS + '"><span class="badge bg-success">' + data.status_type_name + '</span></a>';
                                } else if (data.status_type_name === 'Rejected') {
                                    statusElement += '<a class="mx-2" href="' + STATUS + '"><span class="badge bg-danger">' + data.status_type_name + '</span></a>';
                                }
                                else if (data.status_type_name === 'Pending') {
                                    statusElement += '<a class="mx-2" href="' + STATUS + '"><span class="badge bg-secondary">' + data.status_type_name + '</span></a>';
                                }
                                 else {
                                    statusElement += '<a class="mx-2" href="' + STATUS + '"><span class="badge bg-primary">' + data.status_type_name + '</span></a>';
                                }
                                console.log(statusElement);
                                return statusElement;
                            }
                            function candidateStatus(){
                                let statusCandidate = '';
                                if (data.attendee_status == 1) {
                                    statusCandidate +=   '<a href="' + CERTIFICATE + '"><span class="badge bg-success">Issue Certificate</span></a>';
                                } else {
                                    // Display "None" button and link to the status change page
                                    statusCandidate +=  '<a href="' + CERTIFICATE + '"><span class="badge bg-danger">Not Issue Certificate</span></a>';
                                }
                                return statusCandidate;
                            }}
                    }
                ]
            });
        });

        function selectRange() {
            $('.dataTable').DataTable().ajax.reload()
        }
    </script>
    {{-- Delete Confirmation Model : Script : Start --}}
    <script>
        $("#upload-model").on('show.coreui.modal', function (event) {
            var triggerLink = $(event.relatedTarget);
            var url = triggerLink.data("url");
            $("#upload-form").attr('action', url);
        })
    </script>
    <script>
        $("#del-model-delete").on('show.coreui.modal', function (event) {
            var triggerLink = $(event.relatedTarget);
            var url = triggerLink.data("url");
            $("#del-form").attr('action', url);
        })
    </script>

    {{-- Delete Confirmation Model : Script : Start --}}
    {{-- Toastr : Script : Start --}}
    @if(Session::has('messages'))
        <script>
            noti({!! json_encode((Session::get('messages'))) !!});
        </script>
    @endif


    {{-- Toastr : Script : End --}}

@endpush