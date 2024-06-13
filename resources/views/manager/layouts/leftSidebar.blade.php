<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <h5 class="mb-0">{{!empty(session('currentModule.0')) ? ucwords(session('currentModule.0')) : ''}}</h5>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('manager/dashboard') ? 'active' : '' }}"
               href="{{route('manager.dashboard')}}">
                <i class="nav-icon cil-speedometer"></i> Dashboard
            </a>
        </li>
        @canany(['manager_master-data_conference-year-list'])
            <li class="nav-title">Transaction</li>
            @can('manager_master-data_conference-year-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/conference-year*') ? 'active' : '' }}"
                       href="{{route('manager.conference-year.index')}}">
                        <i class="nav-icon cil-cursor"></i> Conference Year
                    </a>
                </li>
            @endcan
        @endcanany
        @canany(['manager_master-data_payment-type-list','manager_master-data_registration-type-list','manager_master-data_registration-fee-list','manager_master-data_status-type-list','manager_master-data_faculty-list','manager_master-data_department-list'])
            <li class="nav-title">Master Data</li>
            @can('manager_master-data_payment-type-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/payment-type*') ? 'active' : '' }}"
                       href="{{route('manager.payment-type.index')}}">
                        <i class="nav-icon cil-cursor"></i> Payment Type
                    </a>
                </li>
            @endcan
            @can('manager_master-data_registration-type-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/registration-type*') ? 'active' : '' }}"
                       href="{{route('manager.registration-type.index')}}">
                        <i class="nav-icon cil-cursor"></i> Registration Type
                    </a>
                </li>
            @endcan
            @can('manager_master-data_status-type-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/status-type*') ? 'active' : '' }}"
                       href="{{route('manager.status-type.index')}}">
                        <i class="nav-icon cil-cursor"></i> Status Type
                    </a>
                </li>
            @endcan
            @can('manager_master-data_faculty-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/faculty*') ? 'active' : '' }}"
                       href="{{route('manager.faculty.index')}}">
                        <i class="nav-icon cil-cursor"></i> Faculty
                    </a>
                </li>
            @endcan
            @can('manager_master-data_department-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/department*') ? 'active' : '' }}"
                       href="{{route('manager.department.index')}}">
                        <i class="nav-icon cil-cursor"></i> Department
                    </a>
                </li>
            @endcan
        @endcanany
        @canany(['manager_steam-publication_publication-type-list', 'manager_steam-publication_publication-list'])
            <li class="nav-title">Steam Publication</li>
            @can('manager_steam-publication_publication-type-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/publication-type*') ? 'active' : '' }}"
                       href="{{route('manager.publication-type.index')}}">
                        <i class="nav-icon cil-cursor"></i> Publication Type
                    </a>
                </li>
            @endcan
            @can('manager_steam-publication_publication-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/publication*') ? 'active' : '' }}"
                       href="{{route('manager.publication.index')}}">
                        <i class="nav-icon cil-cursor"></i> Publication
                    </a>
                </li>
            @endcan
        @endcanany
        @canany(['manager_glimpse_glimpse-category-list', 'manager_glimpse_glimpse-year-list','manager_glimpse_glimpse-day-list'])
            <li class="nav-title">Highlights & Glimpses</li>
            @can('manager_glimpse_glimpse-category-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/glimpse-category*') ? 'active' : '' }}"
                       href="{{route('manager.glimpse-category.index')}}">
                        <i class="nav-icon cil-cursor"></i> Glimpse Category
                    </a>
                </li>
            @endcan
            @can('manager_glimpse_glimpse-year-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/glimpse-year*') ? 'active' : '' }}"
                       href="{{route('manager.glimpse-year.index')}}">
                        <i class="nav-icon cil-cursor"></i> Glimpse Year
                    </a>
                </li>
            @endcan
            @can('manager_glimpse_glimpse-day-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/glimpse-day*') ? 'active' : '' }}"
                       href="{{route('manager.glimpse-day.index')}}">
                        <i class="nav-icon cil-cursor"></i> Glimpse Day
                    </a>
                </li>
            @endcan
            @can('manager_glimpse_glimpse-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('manager/glimpse*') ? 'active' : '' }}"
                       href="{{route('manager.glimpse.index')}}">
                        <i class="nav-icon cil-cursor"></i> Glimpse
                    </a>
                </li>
            @endcan
        @endcanany
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
