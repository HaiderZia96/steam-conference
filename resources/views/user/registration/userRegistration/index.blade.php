@extends('user.layouts.app')
@section('page_title')
    {{(!empty($page_title) && isset($page_title)) ? $page_title : ''}}
@endsection
@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('user/datatable/datatables.min.css') }}" rel="stylesheet"/>
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
                    @can('user_registration_user-registration-create')
                        <a href="{{(!empty($url) && isset($url)) ? $url : ''}}"
                           class="btn btn-sm btn-primary">{{(!empty($url_text) && isset($url_text)) ? $url_text : ''}}</a>
                    @endcan
                    @can('user_registration_user-registration-activity-log-trash')
                        <a href="{{(!empty($trash) && isset($trash)) ? $trash : ''}}"
                           class="btn btn-sm btn-danger">{{(!empty($trash_text) && isset($trash_text)) ? $trash_text : ''}}</a>
                    @endcan
                </div>
            </div>
            <hr>
            {{-- Datatatble : Start --}}
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="indextable"
                               class="table table-bordered table-striped table-hover table-responsive w-100 pt-1">
                            <thead class="table-dark">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Conference Year</th>
                            <th>Registration Type</th>
                            {{-- <th>Module</th> --}}
                            <th>Voucher</th>
                            <th>Status</th>
                            <th>Gate Pass</th>
                            {{-- <th>Certificate</th> --}}
                            {{-- <th>Actions</th> --}}
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


            {{-- End: Page Content --}}
            <div class="del-model-wrapper">
                <div class="modal fade" id="del-model" tabindex="-1" aria-labelledby="del-model" aria-hidden="true">
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
                                <form method="POST" id="del-form" enctype="multipart/form-data">
                                    @csrf
                                    {{method_field('PUT')}}
                                    <div class="row px-3">
                                        <div class="col-md-12">
                                            <input type="file" name="voucher_upload" class="form-control" id=""
                                                  >
                                            @error('voucher_upload')
                                            <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
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
        </div>
    </div>

@endsection
@push('footer-scripts')
    <script type="text/javascript" src="{{ asset('user/datatable/datatables.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            //Datatable
            $('#indextable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                searching: false,
                sorting: false,
                "bInfo": false,
                "paging": false,
                "lengthChange": false,
                "ordering": false,


                order: [[0, "desc"]],
                ajax: {
                    "type": "GET",
                    "url": "{{route('user.get.user-registration')}}",
                    "data": function (d) {
                        // d.sid = sid;
                    },
                },
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'conference_year_name'},
                    {data: 'registration_type_name'},
                    {data: null},
                    {data: 'status_type_name'},
                    {data: null},
                    // {data: null},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        orderable: false,
                        searchable: false,
                        width: '100px',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        targets: 1,
                        width: '15%'
                    },
                    {
                        targets: 5,
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row, meta) {

                            var voucher = '{{ route("user.download-voucher", ":id") }}';
                            voucher = voucher.replace(':id', data.id);

                            var upload = '{{ route("user.upload-voucher", ":id") }}';
                            upload = upload.replace(':id', data.id);

                            var view = '{{ route("user.get.voucher-image", ":id") }}';
                            view = view.replace(':id', data.id);

                            // console.log(data)
                            if (data.voucher_upload == null) {

                                if (data.registration_type_name == 'Student' || 'Faculty') {

                                    if (data.voucher_upload == null) {
                                        return '<div class="d-flex">' +
                                            '<a href="' + voucher + '" class="btn btn-sm btn-primary mx-2"><i class="fa fa-download text-white"></i></a>' +
                                            '<a class="me-1" href="javascript:void(0)"><span type="button" class="btn btn-sm btn-success" data-url="' + upload + '" data-coreui-toggle="modal" data-coreui-target="#del-model"><i class="fa fa-upload text-white"></i></span></a>' +
                                            '</div>';
                                    } else {
                                        return '<div class="d-flex">' +
                                            '<a href="' + view + '" class="btn btn-sm btn-primary mx-2" target="_blank"><i class="fa fa-eye text-white"></i></a>'
                                            // '<a class="me-1" href="' + view + '" target="_blank"><span class="badge bg-info text-white">view</span>' +
                                            +
                                            '</div>';
                                    }

                                }
                                if (data.status_type_name == 'Approved') {
                                    return '<div class="d-flex">' +
                                        '<p>No Voucher</p>' +
                                        '</div>';
                                } else {
                                    return '<div class="d-flex">' +
                                        '<a href="' + voucher + '" class="btn btn-sm btn-primary mx-2" data-coreui-toggle="tooltip" data-coreui-placement="top" title="Download Voucher"><i class="fa fa-download text-white"></i></a>' +
                                        '<a class="me-1" href="javascript:void(0)"><span type="button" class="btn btn-sm btn-success" data-url="' + upload + '" data-coreui-toggle="modal" data-coreui-target="#del-model" title="Upload Voucher"><i class="fa fa-upload text-white"></i></span></a>' +
                                        '</div>';
                                }

                            } else if (data.status_type_name == 'Rejected') {
                                return '<div class="d-flex">' +
                                    '<a href="' + voucher + '" class="btn btn-sm btn-primary mx-2" data-coreui-toggle="tooltip" data-coreui-placement="top" title="Download Voucher"><i class="fa fa-download text-white"></i></a>' +
                                    '<a class="me-1" href="javascript:void(0)"><span type="button" class="btn btn-sm btn-success" data-url="' + upload + '" data-coreui-toggle="modal" data-coreui-target="#del-model" title="Upload Voucher"><i class="fa fa-upload text-white"></i></span></a>' +
                                    '</div>';
                            } else {
                                return '<div class="d-flex">' +
                                    '<a href="' + view + '" class="btn btn-sm btn-primary mx-2" target="_blank"><i class="fa fa-eye text-white"></i></a>'
                                    // '<a class="me-1" href="' + view + '" target="_blank"><span class="badge bg-info text-white">view</span>' +
                                    +
                                    '</div>';
                            }
                        },
                    },
                    {
                        targets: 6,
                        orderable: false,
                        className: 'perm_col',
                        // defaultContent: '<span class="badge bg-info text-dark">group</span>'
                        render: function (data, type, row, meta) {
                            // let URL = "{{ route('user.get.user-registration-status', ':id') }}";
                            // URL = URL.replace(':id', row.id);

                            var output = "";

                            // Check if data is approved or rejected and set the badge color accordingly
                            if (data === 'Approved') {
                                output += '<span class="badge bg-success">' + data + '</span>';
                            } else if (data === 'Rejected') {
                                output += '<span class="badge bg-danger">' + data + '</span>';
                            } else {
                                output += '<span class="badge bg-secondary">' + data + '</span>';
                            }

                            return output;
                        }
                    },
                    // {
                    //     targets: 5,
                    //     orderable: true,
                    //     className: 'perm_col',
                    //     render: function (data, type, row, meta) {
                    //         var output = "";
                    //         var voucher = '{{ route("user.download-voucher", ":id") }}';
                    //         voucher = voucher.replace(':id', data.id);
                    //         output += '<a href="' + voucher + '" class="btn btn-sm bg-success mx-2"><i class="fa fa-download text-white"></i></a>';

                    //         return output;
                    //     }

                    // },

                    // {
                    //     render: function (data, type, row, meta) {

                    //         var voucher = '{{ route("user.download-voucher", ":id") }}';
                    //         voucher = voucher.replace(':id', data.id);

                    //         var upload = '{{ route("user.upload-voucher", ":id") }}';
                    //         upload = upload.replace(':id', data.id);

                    //         if (data.voucher_upload == null) {
                    //             if(data.registration_type_name === 'Student'){

                    //                     if (data.voucher_upload != null) {
                    //                         return '<div class="d-flex">' +
                    //                             '<a href="{{URL('/')}}/front/images/voucher/' + data.voucher_upload + '" class="btn btn-sm btn-primary mx-2" target="_blank"><i class="fa fa-eye text-white"></i></a>' +
                    //                             '</div>';
                    //                     } else {

                    //                             return '<div class="d-flex">' +
                    //                         '<a href="' + voucher + '" class="btn btn-sm btn-primary mx-2"><i class="fa fa-download text-white"></i></a>' +
                    //                         '<a class="me-1" href="javascript:void(0)"><span type="button" class="btn btn-sm btn-success" data-url="' + upload + '" data-coreui-toggle="modal" data-coreui-target="#del-model"><i class="fa fa-upload text-white"></i></span></a>' +
                    //                       '</div>';
                    //                     }

                    //             }
                    //             if (data.status_type_name === 'Approved') {
                    //                 return '<div class="d-flex">' +
                    //                     '<p>No Voucher</p>' +
                    //                     '</div>';
                    //             } else {
                    //                 return '<div class="d-flex">' +
                    //                     '<a href="' + voucher + '" class="btn btn-sm btn-primary mx-2" data-coreui-toggle="tooltip" data-coreui-placement="top" title="Download Voucher"><i class="fa fa-download text-white"></i></a>' +
                    //                     '<a class="me-1" href="javascript:void(0)"><span type="button" class="btn btn-sm btn-success" data-url="' + upload + '" data-coreui-toggle="modal" data-coreui-target="#del-model" title="Upload Voucher"><i class="fa fa-upload text-white"></i></span></a>' +
                    //                     '</div>';
                    //             }

                    //         } else if (data.status_type_name === 'Rejected') {
                    //             return '<div class="d-flex">' +
                    //                 '<a href="' + voucher + '" class="btn btn-sm btn-primary mx-2" data-coreui-toggle="tooltip" data-coreui-placement="top" title="Download Voucher"><i class="fa fa-download text-white"></i></a>' +
                    //                 '<a class="me-1" href="javascript:void(0)"><span type="button" class="btn btn-sm btn-success" data-url="' + upload + '" data-coreui-toggle="modal" data-coreui-target="#del-model" title="Upload Voucher"><i class="fa fa-upload text-white"></i></span></a>' +
                    //                 '</div>';
                    //         } else {
                    //             return '<div class="d-flex">' +
                    //                 '<a href="{{URL('/')}}/front/images/voucher/' + data.voucher_upload + '" class="btn btn-sm btn-primary mx-2" target="_blank"><i class="fa fa-eye text-white"></i></a>' +
                    //                 '</div>';
                    //             }
                    //     },
                    //     searchable: false,
                    //     orderable: false,
                    //     targets: 5
                    // },
                    {
                        targets: 7,
                        orderable: false,
                        className: 'perm_col',
                        // defaultContent: '<span class="badge bg-info text-dark">group</span>'
                        render: function (data, type, row, meta) {

                            var gatePass = '{{ route("user.download-gate-pass", ":id") }}';
                            gatePass = gatePass.replace(':id', data.id);

                            // var output = "";
if (data.status_type_name == 'Approved') {
                                return '<div class="d-flex">' +
                                    '<a href="' + gatePass + '"><span class="btn btn-sm btn-warning mx-2"><i class="fa fa-download text-white"></i></span></a>'
                                '</div>';
                            } else {
                                return '<div class="d-flex">' + '</div>';
                            }
                            // output += '<a href="' + gatePass + '"><span class="badge bg-secondary"><i class="fa fa-download text-white"></i></span></a>';


                            // return output;
                        }
                    },
                    // {
                    //     targets: -1,
                    //     orderable: false,
                    //     className: 'perm_col',
                    //     render: function (data, type, row, meta) {

                    //         var certificate = '{{ route("user.download-certificate", ":id") }}';
                    //         certificate = certificate.replace(':id', data.id);

                    //         // {{--                            @can('manager_registration_user-registration-gate-pass-download')--}}
                    //         if (data.attendee_status == 0) {
                    //             return '<div class="d-flex">' +'</div>';
                    //         } else if (data.attendee_status == 1) {
                    //             return '<div class="d-flex">' +
                    //                 '<a href="' + certificate + '"><span class="btn btn-sm btn-dark mx-2"><i class="fa fa-download text-white"></i></span></a>'
                    //             '</div>';
                    //         }
                    //         // {{--                            @endcan--}}

                    //     }
                    // },
                    // {
                    //     targets: -1,
                    //     searchable: false,
                    //     orderable: false,
                    //
                    // }
                ]
            });
        });

        function selectRange() {
            $('.dataTable').DataTable().ajax.reload()
        }
    </script>
    {{-- Delete Confirmation Model : Script : Start --}}
    <script>
        $("#del-model").on('show.coreui.modal', function (event) {
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
