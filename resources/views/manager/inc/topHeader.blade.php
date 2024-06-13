<nav class="navbar navbar-expand-lg navbar-light bg-white navbar-white rounded shadow p-2">
    <div class="container-fluid">
        <a class="navbar-brand text-capitalize"
           href="{{route('manager.session-detail',$session->id)}}">{{(!empty($s_title) && isset($s_title)) ? $s_title : ''}}
        </a>
        <input type="hidden" value="{{$session->id}}" id="session_id">
        <button class="navbar-toggler collapsed" type="button" data-coreui-toggle="collapse"
                data-coreui-target="#navbar-content">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-content">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @canany(['manager_reports_candidate-entrance','manager_reports_guest-entrance'])
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold py-1" href="#" data-coreui-toggle="dropdown"
                           data-coreui-auto-close="outside"><i class="cil-walk"></i> Entrance </a>
                        {{-- <ul class="dropdown-menu shadow">
                            @canany(['manager_reports_candidate-entrance'])
                                <li><a class="dropdown-item"
                                       href="{{route('manager.report.candidate-entrance',$session->id)}}">
                                        <i class="cil-people"></i> Candidate</a></li>
                            @endcanany
                            @canany(['manager_reports_guest-entrance'])
                                <li><a class="dropdown-item"
                                       href="{{route('manager.report.guest-entrance',$session->id)}}">
                                        <i class="cil-people"></i> Guest</a></li>
                            @endcanany
                        </ul> --}}
                    </li>
                @endcanany
                

                {{-- @canany(['manager_session-settings_session-date-list','manager_session-settings_session-date-create','manager_session-settings_registration-date-list',
                            'manager_session-settings_registration-date-create','manager_session-settings_voucher-date-list','manager_session-settings_voucher-date-create',
                            'manager_session-settings_candidate-fee-create','manager_session-settings_candidate-fee-list','manager_session-settings_guest-fee-create','manager_session-settings_guest-fee-list',
                            'manager_session-settings_event-config-create','manager_session-settings_event-config-list',
                            'manager_session-settings_venue-create','manager_session-settings_venue-list'])
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold py-1" href="#" data-coreui-toggle="dropdown"
                           data-coreui-auto-close="outside"><i class="nav-icon text-dark cil-settings"></i> Setting</a>
                        <ul class="dropdown-menu shadow">
                            @canany(['manager_session-settings_venue-create','manager_session-settings_venue-list'])
                                <li><a class="dropdown-item"
                                       href="{{route('manager.convocation-session.venue.index',$session->id)}}"> <i
                                            class="cil-map"></i> Venue</a>
                                </li>
                            @endcanany

                            @canany(['manager_session-settings_event-config-create','manager_session-settings_event-config-list'])
                                <li><a class="dropdown-item"
                                       href="{{route('manager.convocation-session.event-config.index',$session->id)}}">
                                        <i class="cil-library"></i> Config</a>
                                </li>
                            @endcanany

                            @canany(['manager_session-settings_candidate-fee-create','manager_session-settings_candidate-fee-list','manager_session-settings_guest-fee-create','manager_session-settings_guest-fee-list'])
                                <li class="dropend">
                                    <a href="#" class="dropdown-item dropdown-toggle" data-coreui-toggle="dropdown"
                                       data-coreui-auto-close="outside"><i class="cil-credit-card"></i> Fee</a>
                                    <ul class="dropdown-menu shadow">
                                        @canany(['manager_session-settings_candidate-fee-create','manager_session-settings_candidate-fee-list'])
                                            <li><a class="dropdown-item"
                                                   href="{{route('manager.convocation-session.candidate-fee.index',$session->id)}}">
                                                    @if(isset($isPaid))
                                                        Candidate Fee
                                                    @else
                                                        No of Guest
                                                    @endif
                                                </a>
                                            </li>
                                        @endcanany
                                        @if(isset($isPaid))
                                            @canany(['manager_session-settings_guest-fee-create','manager_session-settings_guest-fee-list'])
                                                <li><a class="dropdown-item"
                                                       href="{{route('manager.convocation-session.guest-fee.index',$session->id)}}">
                                                        Guest Fee</a></li>
                                            @endcanany
                                        @endif
                                    </ul>
                                </li>
                            @endcanany
                            @if(isset($isPaid))
                                @canany(['manager_session_session-campus-create','manager_session_session-campus-list'])
                                    <li><a class="dropdown-item"
                                           href="{{route('manager.convocation-session.campus-map.index',$session->id)}}">
                                            <i
                                                class="cil-bank"></i> Campus/Bank</a>
                                    </li>
                                @endcanany
                            @endif
                            @canany(['manager_session-settings_session-date-list','manager_session-settings_session-date-create','manager_session-settings_registration-date-list','manager_session-settings_registration-date-create','manager_session-settings_voucher-date-list','manager_session-settings_voucher-date-create'])
                                <li class="dropend">
                                    <a href="#" class="dropdown-item dropdown-toggle" data-coreui-toggle="dropdown"
                                       data-coreui-auto-close="outside"><i class="cil-object-ungroup"></i> Misc</a>
                                    <ul class="dropdown-menu shadow">
                                        @canany(['manager_session-settings_session-date-list','manager_session-settings_session-date-create'])
                                            <li><a class="dropdown-item"
                                                   href="{{route('manager.convocation-session.session-date.index',$session->id)}}">Event
                                                    Date</a></li>
                                        @endcanany

                                        @if(isset($isPaid))
                                            @canany(['manager_session-settings_registration-date-list','manager_session-settings_registration-date-create'])
                                                <li><a class="dropdown-item"
                                                       href="{{route('manager.convocation-session.registration-date.index',$session->id)}}">Registration
                                                        Date</a></li>
                                            @endcanany

                                            @canany(['manager_session-settings_voucher-date-list','manager_session-settings_voucher-date-create'])
                                                <li><a class="dropdown-item"
                                                       href="{{route('manager.convocation-session.voucher-date.index',$session->id)}}">Voucher
                                                        Date</a></li>
                                            @endcanany
                                        @endif
                                    </ul>
                                </li>
                            @endcanany
                        </ul>
                    </li>
                @endcanany --}}
                @canany(['manager_reports_candidate-detail','manager_reports_registration'])
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold py-1" href="#" data-coreui-toggle="dropdown"
                           data-coreui-auto-close="outside"><i class="cil-apps-settings text-dark"></i> Reports</a>
                        <ul class="dropdown-menu shadow">
                            @canany(['manager_reports_candidate-detail'])
                                <li><a class="dropdown-item"
                                       href="{{route('manager.report.candidate-detail',$session->id)}}">
                                        <i class="cil-command"></i> Candidate Detail</a></li>
                            @endcanany
                            @canany(['manager_reports_registration'])
                                    <li><a class="dropdown-item"
                                           href="{{route('manager.report.registration',$session->id)}}">
                                            <i class="cil-command"></i> Registration Report</a></li>
                            @endcanany
                        </ul>
                    </li>
                @endcanany
                @canany(['manager_registration_user-registration-list'])
                    <li>
                        <a href="{{route('manager.conference-year.user-registration.index',$session->id)}}"
                           class="btn btn-dark text-white btn-sm p-1 m-1"><i class="cil-playlist-add"></i> Registration</a>
                    </li>

                @endcanany
                @canany(['manager_event_settings-venue-list'])
                <li><a class="btn btn-dark text-white btn-sm p-1 m-1"
                    href="{{route('manager.conference-year.venue.index',$session->id)}}"> <i
                            class="cil-map"></i> Venue</a>
                </li>
                @endcanany
                 
               
                     

            </ul>

        </div>
    </div>
</nav>


@push('JS')
    <script>
        document.addEventListener('click', function (e) {
            // Hamburger menu
            if (e.target.classList.contains('hamburger-toggle')) {
                e.target.children[0].classList.toggle('active');
            }
        })
    </script>
@endpush
