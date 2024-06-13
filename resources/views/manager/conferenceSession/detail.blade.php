@extends('manager.layouts.app')
@section('page_title')
    {{(!empty($page_title) && isset($page_title)) ? $page_title : ''}}
@endsection
@push('head-scripts')
    <link href="{{ asset('manager/select2/dist/css/select2-bootstrap5.min.css') }}" rel="stylesheet"/>
@endpush
@section('content')
<style>

    /*Event Dashboard*/
.event-dashboard-wrapper #attendanceChart {
  width: 100% !important;
  height: 250px !important;
}
.event-dashboard-wrapper #alumniRegistration {
  width: 100% !important;
  height: 250px !important;
}
.event-dashboard-wrapper #feeRegistration {
  width: 100% !important;
  height: 250px !important;
}
.event-dashboard-wrapper .registration-wrapper .sectionClass {
  position: relative;
  display: block;
}
.event-dashboard-wrapper .registration-wrapper .fullWidth {
  width: 100% !important;
  display: table;
  float: none;
  padding: 0;
  min-height: 1px;
  height: 100%;
  position: relative;
}
.event-dashboard-wrapper .registration-wrapper .sectiontitle {
  background-position: center;
  margin: 30px 0 0px;
  text-align: center;
  min-height: 20px;
}
.event-dashboard-wrapper .registration-wrapper .sectiontitle h2 {
  font-size: 30px;
  color: #222;
  margin-bottom: 0px;
  padding-right: 10px;
  padding-left: 10px;
}
.event-dashboard-wrapper .registration-wrapper .headerLine {
  width: 160px;
  height: 2px;
  display: inline-block;
  background: #101F2E;
}
.event-dashboard-wrapper .registration-wrapper .projectFactsWrap {
  display: flex;
  margin-top: 30px;
  flex-direction: row;
  flex-wrap: wrap;
}
.event-dashboard-wrapper .registration-wrapper #projectFacts .fullWidth {
  padding: 0;
}
.event-dashboard-wrapper .registration-wrapper .projectFactsWrap .item {
  width: 33.33%;
  height: 100%;
  padding: 50px 0px;
  text-align: center;
}

.event-dashboard-wrapper .registration-wrapper .projectFactsWrap .item:nth-child(1) {
  background: rgb(16, 31, 46);
}

.event-dashboard-wrapper .registration-wrapper .projectFactsWrap .item:nth-child(2) {
  background: rgb(18, 34, 51);
}

.event-dashboard-wrapper .registration-wrapper .projectFactsWrap .item:nth-child(3) {
  background: rgb(21, 38, 56);
}

.event-dashboard-wrapper .registration-wrapper .projectFactsWrap .item:nth-child(4) {
  background: rgb(23, 44, 66);
}

.event-dashboard-wrapper .registration-wrapper .projectFactsWrap .item p.number {
  font-size: 40px;
  padding: 0;
  font-weight: bold;
}
.event-dashboard-wrapper .registration-wrapper .projectFactsWrap .item p {
  color: rgba(255, 255, 255, 0.8);
  font-size: 18px;
  margin: 0;
  padding: 10px;
  font-family: 'Open Sans';
}
.event-dashboard-wrapper .registration-wrapper .projectFactsWrap .item span {
  width: 60px;
  background: rgba(255, 255, 255, 0.8);
  height: 2px;
  display: block;
  margin: 0 auto;
}
.event-dashboard-wrapper .registration-wrapper .projectFactsWrap .item i {
  vertical-align: middle;
  font-size: 50px;
  color: rgba(255, 255, 255, 0.8);
}
.event-dashboard-wrapper .registration-wrapper .projectFactsWrap .item:hover i, .projectFactsWrap .item:hover p {
  color: white;
}
.event-dashboard-wrapper .registration-wrapper .projectFactsWrap .item:hover span {
  background: white;
}
@media (max-width: 786px) {
  .event-dashboard-wrapper .registration-wrapper .projectFactsWrap .item {
      flex: 0 0 50%;
  }
}
</style>
@include('manager/inc.topHeader')
<div class="card mt-3 event-dashboard-wrapper">
    <div class="row">
                {{-- Candidate Fee Status --}}
                <div class="col-md-6 mt-2">
                    <div class="card-body">
                        {{--Candidate: Page Content--}}
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title mb-0">Candidate Fee Status</h4>
                            </div>
        
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="row pt-2">
                                    <div class="col-md-8">
                                        <canvas id="feeRegistration"></canvas>
                                    </div>
                                    <div class="col-md-4 text-start">
                                        @foreach($userFeeCount as $camCount)
                                            @if($camCount->name == 'Pending')
                                                <a class="text-decoration-none"
                                                   href="">
                                                    <h6 class="mt-2" style="color: #373636">
                                                       Candidates Pending: <b
                                                            class="text-dark">{{$camCount->fee_status_count}}</b>
                                                    </h6>
                                                </a>
                                            @endif
                                            @if($camCount->name == 'Approved')
                                                <a class="text-decoration-none"
                                                   href="">
                                                    <h6 class="mt-2" style="color: #373636">
                                                        Candidates Approved: <b
                                                            class="text-dark">{{$camCount->fee_status_count}}</b>
                                                    </h6>
                                                </a>
                                                @endif
                                                @if($camCount->name == 'Rejected')
                                                <a class="text-decoration-none"
                                                   href="">
                                                    <h6 class="mt-2" style="color: #373636">
                                                        Candidates Rejected: <b
                                                            class="text-dark">{{$camCount->fee_status_count}}</b>
                                                    </h6>
                                                </a>
                                            @endif
                                            @if($camCount->name == 'Not Submitted')
                                            <a class="text-decoration-none"
                                               href="">
                                                <h6 class="mt-2" style="color: #373636">
                                                    Candidates Not Submitted: <b
                                                        class="text-dark">{{$camCount->fee_status_count}}</b>
                                                </h6>
                                            </a>
                                        @endif
                                               
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--Candidate : End--}}
                        {{--End: Page Content--}}
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div class="card-body">
                        {{--Candidate: Page Content--}}
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title mb-0">Registration</h4>
                            </div>
        
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="row pt-2">
                                    <div class="col-md-8">
                                        <canvas id="alumniRegistration"></canvas>
                                    </div>
                                    <div class="col-md-4 text-start">
                                        @foreach($userRegistrationCount as $camCount)
                                            @if($camCount->name == 'Non-Tufians')
                                                <a class="text-decoration-none"
                                                   href="">
                                                    <h6 class="mt-2" style="color: #373636">
                                                       Non-Tufians: <b
                                                            class="text-dark">{{$camCount->registration_count}}</b>
                                                    </h6>
                                                </a>
                                            @endif
                                            @if($camCount->name == 'Tufians')
                                                <a class="text-decoration-none"
                                                   href="">
                                                    <h6 class="mt-2" style="color: #373636">
                                                      Tufians: <b
                                                            class="text-dark">{{$camCount->registration_count}}</b>
                                                    </h6>
                                                </a>
                                            @endif
                                               
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--Candidate : End--}}
                        {{--End: Page Content--}}
                    </div>
                </div>
        <div class="col-md-6 mt-2">
            <div class="card-body">
                {{-- Candidate: Page Content --}}
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title mb-0">Attendance</h4>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-12 ">
                        <div class="row pt-2">
                            <div class="col-md-8">
                                <canvas id="attendanceChart"></canvas>
                            </div>
                            <div class="col-md-4 text-start">
                                {{-- @foreach($attendance_view as $attendance_vu) --}}
                                    <a class="text-decoration-none"
                                       href="#">
                                        <h6 class="mt-2" style="color: #BE992D">
                                            Present Candidate: <b
                                                class="text-dark"></b></h6>
                                    </a>
                                    <a class="text-decoration-none"
                                       href="#">
                                        <h6 class="mt-2" style="color: #CE8585">
                                            Absent Candidate: <b
                                                class="text-dark"></b></h6>
                                    </a>
                                {{-- @endforeach --}}
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Candidate : End --}}
                {{-- End: Page Content --}}
            </div>
        </div>
          {{-- Candidate Paper Submission --}}
          <div class="col-md-6 mt-2">
            <div class="card-body">
                {{--Candidate: Page Content--}}
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title mb-0">Candidate Paper Submission</h4>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="row pt-2">
                            <div class="col-md-8">
                                <canvas id="paperSubmission"></canvas>
                            </div>
                            <div class="col-md-4 text-start">
                                @foreach($userPaperCount as $camCount)
                                    @if($camCount->status_type_name == 'Not Submitted')
                                        <a class="text-decoration-none"
                                           href="">
                                            <h6 class="mt-2" style="color: #373636">
                                               Candidates Paper Not Submitted: <b
                                                    class="text-dark">{{$camCount->count}}</b>
                                            </h6>
                                        </a>
                                    @endif
                                    @if($camCount->status_type_name == 'Pending')
                                    <a class="text-decoration-none"
                                       href="">
                                        <h6 class="mt-2" style="color: #373636">
                                           Candidates Paper Pending: <b
                                                class="text-dark">{{$camCount->count}}</b>
                                        </h6>
                                    </a>
                                @endif
                                    @if($camCount->status_type_name == 'Approved')
                                        <a class="text-decoration-none"
                                           href="">
                                            <h6 class="mt-2" style="color: #373636">
                                                Candidates Paper Approved: <b
                                                    class="text-dark">{{$camCount->count}}</b>
                                            </h6>
                                        </a>
                                        @endif
                                        @if($camCount->status_type_name == 'Rejected')
                                        <a class="text-decoration-none"
                                           href="">
                                            <h6 class="mt-2" style="color: #373636">
                                                Candidates Paper Rejected: <b
                                                    class="text-dark">{{$camCount->count}}</b>
                                            </h6>
                                        </a>
                                    @endif
                                  
                                       
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {{--Candidate : End--}}
                {{--End: Page Content--}}
            </div>
        </div>


    </div>
    <div class="row p-3 registration-wrapper">
        <div id="projectFacts" class="sectionClass">
            <div class="fullWidth eight columns">
                <div class="projectFactsWrap ">
                    <div class="item wow fadeInUpBig animated animated" data-number="{{$registerCount}}"
                    style="visibility: visible;">
                   <i class="fa fa-person"></i>
                   <p id="number1" class="number">{{$registerCount}}</p>
                   <span></span>
                   <p>Total Register Candidates</p>
               </div>
                    <div class="item wow fadeInUpBig animated animated" data-number="{{$tufiansCount}}"
                         style="visibility: visible;">
                        <i class="fa fa-person"></i>
                        <p id="number2" class="number">{{$tufiansCount}}</p>
                        <span></span>
                        <p>Tufians Candidates</p>
                    </div>
                    
                    <div class="item wow fadeInUpBig animated animated" data-number="{{$nontufiansCount}}"
                         style="visibility: visible;">
                        <i class="fa fa-person"></i>
                        <p id="number3" class="number">{{$nontufiansCount}}</p>
                        <span></span>
                        <p>Non-Tufians Candidates</p>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection


@push('footer-scripts')
    {{-- Toastr : Script : Start --}}
    @if(Session::has('messages'))
        <script>
            noti({!! json_encode((Session::get('messages'))) !!});
        </script>
    @endif
    <script>

        $.fn.jQuerySimpleCounter = function (options) {
            var settings = $.extend({
                start: 0,
                end: 100,
                easing: 'swing',
                duration: 400,
                complete: ''
            }, options);

            var thisElement = $(this);

            $({count: settings.start}).animate({count: settings.end}, {
                duration: settings.duration,
                easing: settings.easing,
                step: function () {
                    var mathCount = Math.ceil(this.count);
                    thisElement.text(mathCount);
                },
                complete: settings.complete
            });
        };

        $('#number1').jQuerySimpleCounter({end: {{$registerCount}}, duration: 2000});
        $('#number2').jQuerySimpleCounter({end: {{$tufiansCount}}, duration: 2000});
        $('#number3').jQuerySimpleCounter({end: {{$nontufiansCount}}, duration: 2000});



        /* AUTHOR LINK */
        $('.about-me-img').hover(function () {
            $('.authorWindowWrapper').stop().fadeIn('fast').find('p').addClass('trans');
        }, function () {
            $('.authorWindowWrapper').stop().fadeOut('fast').find('p').removeClass('trans');
        });

    </script>

    {{-- Toastr : Script : End --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx3 = document.getElementById('attendanceChart');
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: '',
                datasets: [{
                    maxBarThickness: 20,
                    label: '# Attendance Detail',
                    data: '',
                    backgroundColor: [
                        'rgb(190,153,45)',
                        'rgb(206,133,133)',
                        'rgb(128,60,74)',
                        'rgb(98,70,48)',
                    ],
                    borderWidth: 1
                }]

            },
            options: {
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        align: 'start',
                        labels: {
                            boxWidth: 20,
                            boxHeight: 20
                        },
                    },
                },

                responsive: true,
                maintainAspectRatio: false
            },
        });
    </script>
   <script>
    const ctx4 = document.getElementById('alumniRegistration');
    new Chart(ctx4, {
        type: 'pie',
        data: {
                labels: {!! $registrationCountNameJs !!},
                datasets: [{
                    label: '# Registration Members Detail',
                    data: {{$registrationCountCountJs}},
                }]
            },
            options: {
                cutout: '0%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        align: 'start',
                        labels: false,
                    },
                },

                responsive: true,
                maintainAspectRatio: false
            },
    });
</script>


<script>
    const ctx5 = document.getElementById('feeRegistration');
    new Chart(ctx5, {
        type: 'pie',
        data: {
                labels: {!! $feeCountNameJs !!},
                datasets: [{
                    label: '# Candidate Fee Status',
                    data: {{$feeCountCountJs}},
                }]
            },
        options: {
                cutout: '0%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        align: 'start',
                        labels: false,
                    },
                },

                responsive: true,
                maintainAspectRatio: false
            },
    });
</script>

<script>
    const ctx6 = document.getElementById('paperSubmission');
    // const labels = {!! json_encode($paperCountNameJs) !!};
    // const data = {!! json_encode($paperCountCountJs) !!};
    new Chart(ctx6, {
        type: 'bar',
        data: {
            labels:["Pending","Approved","Rejected","Not Submitted"],
            datasets: [{
                maxBarThickness: 20,
                label: '# Candidates Paper Submission',
                data: {{$paperCountCountJs}},
                backgroundColor: [
                    'rgb(42,84,176)',
                    'rgb(61,60,60)',
                    'rgb(203,98,14)',
                    'rgb(161,10,33)',
                    'rgb(52,211,83)',
                    'rgb(255,0,0)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            cutout: '75%',
            plugins: {
                legend: {
                    position: 'bottom',
                    align: 'start',
                    labels: {
                        boxWidth: 20,
                        boxHeight: 20,
                    },
                },
            },
            responsive: true,
            maintainAspectRatio: false
        },
    });
</script>
@endpush
