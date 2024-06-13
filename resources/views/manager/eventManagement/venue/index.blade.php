@extends('manager.layouts.app')
@section('page_title')
    {{(!empty($page_title) && isset($page_title)) ? $page_title : ''}}
@endsection
@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('manager/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('manager/select2/dist/css/select2-bootstrap5.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('manager/datatable/datatables.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    @include('manager/inc.topHeader')
    <div class="card mt-3">
        <div class="card-body">
            {{-- Start: Page Content --}}
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">{{(!empty($p_title) && isset($p_title)) ? $p_title : ''}}</h4>
                    <div class="small text-medium-emphasis">{{(!empty($p_summary) && isset($p_summary)) ? $p_summary : ''}}</div>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    @can('manager_event_settings-venue-create')
                        <a href="{{(!empty($url) && isset($url)) ? $url : ''}}" class="btn btn-sm btn-primary">{{(!empty($url_text) && isset($url_text)) ? $url_text : ''}}</a>
                    @endcan
                    @can('manager_event_settings-venue-activity-log-trash')
                        <a href="{{(!empty($trash) && isset($trash)) ? $trash : ''}}" class="btn btn-sm btn-danger">{{(!empty($trash_text) && isset($trash_text)) ? $trash_text : ''}}</a>
                    @endcan
                </div>
            </div>
            <hr>
            {{-- Datatatble : Start --}}
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="indextable" class="table table-bordered table-striped table-hover table-responsive w-100 pt-1">
                            <thead class="table-dark">
                            <th>#</th>
                            <th>Title</th>
                            <th>Start Time</th>
                            <th>Event Date</th>
                            <th>Location</th>
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
                                <button type="button" class="btn-close shadow-none" data-coreui-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="font-weight-bold mb-2"> Are you sure you wanna delete this ?</p>
                                <p class="text-muted "> This item will be deleted immediately. You can't undo this action.</p>
                            </div>
                            <div class="modal-footer">
                                <form method="POST" id="del-form">
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <button type="button" class="btn btn-light" data-coreui-dismiss="modal">Cancel</button>
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
            {{-- End: Page Content --}}
        </div>
    </div>
@endsection
@push('footer-scripts')

    <script type="text/javascript" src="{{ asset('manager/datatable/datatables.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            let URL = "{{ route('manager.get.venue', ':id') }}";
            URL = URL.replace(':id', {{$session->id}});
            //Datatable
            $('#indextable').DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                order: [[ 0, "desc" ]],
                ajax: {
                    "type":"GET",
                    "url":URL,
                },
                columns: [
                    { data: 'id', orderable: false},
                    { data: 'title' },
                    { data: 'start_time' },
                    { data: 'event_date' },
                    { data: 'location' },
                    { data: null},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        orderable: false,
                        searchable: false,
                        width: '20px',
                        render: function ( data, type, row, meta ) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        targets: 1,
                        width: '15%'
                    },
                    {
    targets: -1,
    searchable: false,
    orderable: false,
    render: function (data, type, row, meta) {
        let show = "{{ route('manager.conference-year.venue.show', [':yid', ':id']) }}";
        show = show.replace(':yid', {{$session->id}});
        show = show.replace(':id', row.id);
// console.log(show);
        let edit = "{{ route('manager.conference-year.venue.edit', [':yid', ':id']) }}";
        edit = edit.replace(':yid', {{$session->id}});
        edit = edit.replace(':id', row.id);

        let del = "{{ route('manager.conference-year.venue.destroy', [':yid', ':id']) }}";
        del = del.replace(':yid', {{$session->id}});
        del = del.replace(':id', row.id);

        let ACTIVITY = "{{ route('manager.get.venue-activity', [':yid', ':id']) }}";
        ACTIVITY = ACTIVITY.replace(':yid', {{$session->id}});
        ACTIVITY = ACTIVITY.replace(':id', row.id);

        return '<div class="d-flex">' +
            @can('manager_event_settings-venue-show')
            '<a class="me-1" href="' + show + '"><span class="badge bg-success text-dark">Show</span></a>' +
            @endcan

            @can('manager_event_settings-venue-edit')
            '<a class="me-1" href="' + edit + '"><span class="badge bg-info text-dark">Edit</span></a>' +
            @endcan

            @can('manager_event_settings-venue-delete')
            '<a class="me-1" href="javascript:void(0)"><span type="button" class="badge bg-danger" data-url="' + del + '" data-coreui-toggle="modal" data-coreui-target="#del-model">Delete</span></a>' +
            @endcan

            @can('manager_event_settings-venue-activity-log')
            '<a class="me-1" href="' + ACTIVITY + '"><span class="badge bg-warning text-dark">Activity</span></a>' +
            @endcan

            '</div>';
    }
}

                ]
            });
        });
        function selectRange(){
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
