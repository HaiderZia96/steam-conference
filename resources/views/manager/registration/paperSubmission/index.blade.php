@extends('manager.layouts.app')
@section('page_title')
    {{(!empty($page_title) && isset($page_title)) ? $page_title : ''}}
@endsection
@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('manager/datatable/datatables.min.css') }}" rel="stylesheet"/>
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
                    @can('manager_registration_paper-submission-create')
                        <a href="{{(!empty($url) && isset($url)) ? $url : ''}}"
                           class="btn btn-sm btn-primary">{{(!empty($url_text) && isset($url_text)) ? $url_text : ''}}</a>
                    @endcan
                    @can('manager_registration_paper-submission-activity-log-trash')
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
                            <th>Contact No</th>
                            {{--                            <th>Status</th>--}}
                            <th>Submission File</th>
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
                <div class="modal fade" id="del-model" tabindex="-1" aria-labelledby="del-model" aria-hidden="true">
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

            {{-- Paper Submission Model : Start --}}
            <div class="modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Paper Submission</h5>
                            <button type="button" class="btn-close" data-coreui-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Modal body text goes here.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Paper Submission Model : End --}}
            {{-- End: Page Content --}}
        </div>
    </div>
@endsection
@push('footer-scripts')
    <script type="text/javascript" src="{{ asset('manager/datatable/datatables.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            //Datatable
            $('#indextable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                order: [[0, "desc"]],
                ajax: {
                    "type": "GET",
                    "url": "{{route('manager.get.paper-submission')}}",
                    "data": function (d) {
                        d.uid = {{$udata}}; // Pass the 'udata' variable as 'uid'
                        // Other data parameters if needed
                    }
                },
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'contact_no'},
                    // {data: 'status_type_name'},
                    {data: null},
                    {data: null},
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
                        {{--{--}}
                        {{--    targets: 4,--}}
                        {{--    orderable: true,--}}
                        {{--    className: 'perm_col',--}}
                        {{--    // defaultContent: '<span class="badge bg-info text-dark">group</span>'--}}
                        {{--    render: function (data, type, row, meta) {--}}
                        {{--        let URL = "{{ route('manager.get.paper-submission-status', [':sid',':uid',':id']) }}";--}}
                        {{--        URL = URL.replace(':id', row.id);--}}
                        {{--        URL = URL.replace(':sid', {{$sdata}});--}}
                        {{--        URL = URL.replace(':uid', {{$udata}});--}}

                        {{--        var output = "";--}}

                        {{--        // Check if data is approved or rejected and set the badge color accordingly--}}
                        {{--        if (data.status_type_name === 'Approved') {--}}
                        {{--            output += '<a href="' + URL + '"><span class="badge bg-success">' + data.status_type_name + '</span></a>';--}}
                        {{--        } else if (data.status_type_name === 'Rejected') {--}}
                        {{--            output += '<a href="' + URL + '"><span class="badge bg-danger">' + data.status_type_name + '</span></a>';--}}
                        {{--        } else {--}}
                        {{--            output += '<a href="' + URL + '"><span class="badge bg-secondary">' + data + '</span></a>';--}}
                        {{--        }--}}

                        {{--        return output;--}}
                        {{--    }--}}
                        {{--},--}}
                    {
                        targets: 4,
                        orderable: true,
                        className: 'perm_col',
                        render: function (data, type, row, meta) {
                            var output = "";
                            var paper = '{{ route("manager.paper-submission-file", ":id") }}';
                            paper = paper.replace(':id', data.id);
                            output += '<a href="' + paper + '" class="btn btn-sm bg-primary"><img src="{{asset('manager/coreui/icons/eye.png')}}" width="20" height="20"></a>';
                            return output;
                        }
                    },
                    {
                        targets: -1,
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row, meta) {

                            let URL = "{{ route('manager.conference-year.user-registration.paper-submission.show', [':sid',':uid',':id']) }}";
                            URL = URL.replace(':id', row.id);
                            URL = URL.replace(':sid', {{$sdata}});
                            URL = URL.replace(':uid', {{$udata}});

                            let ACTIVITY = "{{ route('manager.get.paper-submission-activity', [':sid',':uid',':id']) }}";
                            ACTIVITY = ACTIVITY.replace(':id', row.id);
                            ACTIVITY = ACTIVITY.replace(':sid', {{$sdata}});
                            ACTIVITY = ACTIVITY.replace(':uid', {{$udata}});

                            let STATUS = "{{ route('manager.get.paper-submission-status', [':sid',':uid',':id']) }}";
                            STATUS = STATUS.replace(':id', row.id);
                            STATUS = STATUS.replace(':sid', {{$sdata}});
                            STATUS = STATUS.replace(':uid', {{$udata}});

                            // get Status
                            function generateStatusElement() {
                                let statusElement = '';
                                if (data.status_type_name === 'Approved') {
                                    statusElement += '<a class="ms-2" href="' + STATUS + '"><span class="badge bg-success">' + data.status_type_name + '</span></a>';
                                } else if (data.status_type_name === 'Rejected') {
                                    statusElement += '<a class="ms-2" href="' + STATUS + '"><span class="badge bg-danger">' + data.status_type_name + '</span></a>';
                                } else {
                                    statusElement += '<a class="ms-2" href="' + STATUS + '"><span class="badge bg-secondary">' + data.status_type_name + '</span></a>';
                                }
                                return statusElement;
                            }

                            return '<div class="d-flex">' +
                                @can('manager_registration_paper-submission-show')
                                    '<a class="me-1" href="' + URL + '"><span class="badge bg-success text-dark">Show</span>' +
                                @endcan
                                    @can('manager_registration_paper-submission-edit')
                                    '<a class="me-1" href="' + URL + '/edit"><span class="badge bg-info text-dark">Edit</span></a>' +
                                @endcan
                                    @can('manager_registration_paper-submission-activity-log')
                                    '<a class="me-1" href="' + ACTIVITY + '"><span class="badge bg-warning text-dark">Activity</span></a>' +
                                @endcan
                                    @can('manager_registration_paper-submission-delete')
                                    '<a class="me-1" href="javascript:void(0)"><span type="button" class="badge bg-danger" data-url="' + URL + '" data-coreui-toggle="modal" data-coreui-target="#del-model">Delete</span></a>' +
                                @endcan
                                    '|' +
                                @can('manager_master-data_status-type-status-edit')
                                generateStatusElement() +
                                @endcan
                                    '</div>'

                        }
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
