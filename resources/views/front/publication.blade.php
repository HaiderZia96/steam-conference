@section('title', 'Publications | TUF STEAM Advance Education')
@section('description', 'Explore publications at TUF STEAM Advance Education. Elevate your knowledge with insightful articles and research in science, technology, and more. Visit now!')
@section('keywords', 'Publications')
@extends('front.layouts.app')
@push('head-scripts')
    <link rel="stylesheet" type="text/css" href="{{ asset('front/datatable/datatables.css') }}">
@endpush
@section('content')
    <div class="container publication-section">
        <h1 class="title mb-4">
            Publications
        </h1>
        <div class="row mt-2 mb-4">
            <div class="col-lg-3 col-md-4">
                <select class="form-select form-control form-control-sm" id="pubType">
                    <option value="">Publication Type</option>
                    @foreach($publicationTypes as $pubType)
                        <option value="{{$pubType->id}}">{{$pubType->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 col-md-4">
                <select class="form-select form-control form-control-sm" id="dptID">
                    <option value="">Department</option>
                    @foreach ($departments as $dpt)
                        <option value="{{$dpt->id}}">{{$dpt->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="table-responsive mb-5">
            <table class="table table-striped table-bordered dataTable">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Publication Type</th>
                    <th scope="col">Department</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('footer-scripts')
    <script src="{{ asset('front/datatable/datatables.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#pubType").change(function () {
                selectRange()
            });
            $("#dptID").change(function () {
                selectRange()
            });
            $(function () {
                var t = $('.dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    order: [[0, 'desc']],
                    ajax: {
                        "type": "GET",
                        "url": "{{route('get.publication')}}",
                        "data": function (d) {
                            d.pubType = document.getElementById('pubType').value;
                            d.dptID = document.getElementById('dptID').value;
                        }
                    },
                    columns: [
                        {data: 'id', orderable: false},
                        {data: 'title'},
                        {data: 'author'},
                        {data: 'publication_type', orderable: false},
                        {data: 'department', orderable: false},
                        {data: null},
                    ],
                    columnDefs: [
                        {
                            render: function (data, type, row, meta, name) {
                                return meta.row + meta.settings._iDisplayStart + 1;

                            },
                            searchable: false,
                            orderable: true,
                            targets: 0
                        },
                        {
                            targets: -1,
                            searchable: false,
                            orderable: false,
                            render: function (data, type, row, meta) {

                                let src = '{{ asset('front/publication')}}/' + row.doc_file;

                                return '<div class="d-flex">' +
                                    '<a href="' + src + '" class="me-1" data-toggle="tooltip" data-placement="bottom" title="View File">' +
                                    '<span class="badge bg-dark">Read More>></i></span>' +
                                    '</a>' +
                                    '</div>'

                            }
                        }
                    ]

                });
            });

            function selectRange() {
                $('.dataTable').DataTable().ajax.reload()
            }
        });
    </script>
@endpush
