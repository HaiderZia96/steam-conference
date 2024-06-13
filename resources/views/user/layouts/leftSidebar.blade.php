<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <h5 class="mb-0">{{!empty(session('currentModule.0')) ? ucwords(session('currentModule.0')) : ''}}</h5>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('user/dashboard') ? 'active' : '' }}" href="{{route('user.dashboard')}}">
                <i class="nav-icon cil-speedometer"></i> Dashboard
            </a>
        </li>
        <li class="nav-title">Registration</li>
           @can('user_registration_user-registration-list')
               <li class="nav-item">
                   <a class="nav-link {{ request()->is('user/user-registration*') ? 'active' : '' }}"
                      href="{{route('user.user-registration')}}">
                       <i class="nav-icon cil-cursor"></i>Registration
                   </a>
               </li>
           @endcan
           @can('user_registration_paper-submission-list')
                          <li class="nav-item">
                              <a class="nav-link {{ request()->is('user/paper-submission*') ? 'active' : '' }}"
                                 href="{{route('user.paper-submission.index')}}">
                                  <i class="nav-icon cil-cursor"></i> Paper Submission
                              </a>
                          </li>
                      @endcan
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
