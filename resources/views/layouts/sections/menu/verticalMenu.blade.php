<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <style>
        .loggedProfile img {
            height: 20px;
            width: auto;
            float: left;
        }

        .loggedProfile span {
            margin-left: 30px;
        }

        .loggedProfile {
            padding: 10px;
            color: #fff;
        }

        /* .loggedProfile:hover{
    background: #007bff63;
  } */

        .footerbg-profile:hover {
            background: #007bff63;
        }

        .footerbg-profile {
            background: #97b9d087;
        }
    </style>
    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link d-flex align-items-center">
            <span class="app-brand-logo demo d-flex align-items-center me-2 flex-shrink-0">
                <img src="{{ isset($company) && $company && $company->logo ? asset($company->logo) : asset('assets/img/favicon/ispl_logo.png') }}" alt="Company Logo" class="sidebar-brand-logo">
            </span>
            <span class="app-brand-text demo menu-text fw-bold">{{ isset($company) && $company && $company->name ? $company->name : config('variables.templateName') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-item {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}">
                <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                <div>Dashboard</div>
            </a>
        </li>

        {{-- <li class="menu-item {{ Route::currentRouteName() === 'user' || Route::currentRouteName() === 'user-edit' || Route::currentRouteName() === 'role' || Route::currentRouteName() === 'role-create' || Route::currentRouteName() === 'role-edit' ? 'open' : '' }}"
           >
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div>User Management</div>
            </a>

            <ul class="menu-sub">

                <li class="menu-item ">
                    <a href="{{ route('user') }}"
                        class="menu-link {{ Route::currentRouteName() === 'user' || Route::currentRouteName() === 'user-edit' ? 'active' : '' }}">
                        <div>User</div>
                    </a>
                </li>

                <li class="menu-item ">
                    <a href="{{ route('role') }}"
                        class="menu-link {{ Route::currentRouteName() === 'role' || Route::currentRouteName() === 'role-create' || Route::currentRouteName() === 'role-edit' ? 'active' : '' }}">
                        <div>Role Management</div>
                    </a>
                </li>

            </ul>

        </li> --}}




        {{-- <li class="menu-item {{ Route::currentRouteName() === 'staff' || Route::currentRouteName() === 'staff-create' || Route::currentRouteName() === 'staff-edit' ? 'open' : '' }}"
           >
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-universal-access"></i>
                <div>Staff Management</div>
            </a>

            <ul class="menu-sub">

                <li class="menu-item ">
                    <a href="{{ route('staff') }}"
                        class="menu-link {{ Route::currentRouteName() === 'staff' || Route::currentRouteName() === 'staff-create' || Route::currentRouteName() === 'staff-edit' ? 'active' : '' }}">
                        <div>Staff</div>
                    </a>
                </li>

            </ul>

        </li> --}}

        <li class="menu-item"
           >
            {{-- <a href="javascript:void(0);" class="menu-link menu-toggle {{ Route::currentRouteName() === 'admin-setting'? 'active' : '' }}">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Setting</div>
            </a> --}}

            <ul class="menu-sub {{ Route::currentRouteName() === 'admin-setting'? 'active' : '' }}">

                {{-- <li class="menu-item {{ Route::currentRouteName() === 'admin-setting'? 'active' : '' }}">
                    <a href="{{ route('admin-setting') }}"
                        class="menu-link {{ Route::currentRouteName() === 'admin-setting'? 'active text-primary' : '' }}">
                        <div>Admin Setting</div>
                    </a>
                </li> --}}

                {{-- <li class="menu-item">
                    <a href="{{ route('service') }}"
                        class="menu-link {{ Route::currentRouteName() === 'service' || Route::currentRouteName() === 'service-create' || Route::currentRouteName() === 'service-edit' ? 'active' : '' }}">
                        <div>Services</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('client-type') }}"
                        class="menu-link {{ Route::currentRouteName() === 'client-type' || Route::currentRouteName() === 'client-type-create' || Route::currentRouteName() === 'client-type-edit' ? 'active' : '' }}">
                        <div>Client Type</div>
                    </a>
                </li>

                <li class="menu-item ">
                    <a href="{{ route('client-group') }}"
                        class="menu-link {{ Route::currentRouteName() === 'client-group' || Route::currentRouteName() === 'client-group-create' || Route::currentRouteName() === 'client-group-edit' ? 'active' : '' }}">
                        <div>Client Group</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('machine-type') }}"
                        class="menu-link {{ Route::currentRouteName() === 'machine-type' || Route::currentRouteName() === 'machine-type-create' || Route::currentRouteName() === 'machine-type-edit' ? 'active' : '' }}">
                        <div>Machinery Type</div>
                    </a>
                </li>



                <li class="menu-item">
                    <a href="{{ route('designation') }}"
                        class="menu-link {{ Route::currentRouteName() === 'designation' || Route::currentRouteName() === 'designation-create' || Route::currentRouteName() === 'designation-edit' ? 'active' : '' }}">
                        <div>Designation</div>
                    </a>
                </li>

                <li class="menu-item ">
                    <a href="{{ route('staff') }}"
                        class="menu-link {{ Route::currentRouteName() === 'staff' || Route::currentRouteName() === 'staff-create' || Route::currentRouteName() === 'staff-edit' ? 'active' : '' }}">
                        <div>Staff</div>
                    </a>
                </li>

                <li class="menu-item ">
                    <a href="{{ route('user') }}"
                        class="menu-link {{ Route::currentRouteName() === 'user' || Route::currentRouteName() === 'user-edit' ? 'active' : '' }}">
                        <div>User</div>
                    </a>
                </li>

                <li class="menu-item ">
                    <a href="{{ route('role') }}"
                        class="menu-link {{ Route::currentRouteName() === 'role' || Route::currentRouteName() === 'role-create' || Route::currentRouteName() === 'role-edit' ? 'active' : '' }}">
                        <div>Role Management</div>
                    </a>
                </li> --}}

            </ul>

        </li>

        <li class="menu-item {{ Route::currentRouteName() === 'admin-setting' || Route::currentRouteName() === 'admin.setting.update' ? 'active' : '' }}">
          <a href="{{ route('admin-setting') }}"
              class="menu-link {{ Route::currentRouteName() === 'admin-setting' || Route::currentRouteName() === 'admin.setting.update' ? 'active' : '' }}">
              <i class="menu-icon tf-icons bx bx-cog"></i>
              <div>Admin Setting</div>
          </a>
        </li>

        <li class="menu-item {{ Route::currentRouteName() === 'quiz-type.index' || Route::currentRouteName() === 'quiz-type.create' || Route::currentRouteName() === 'quiz-type.edit' ? 'active' : '' }}">
          <a href="{{ route('quiz-type.index') }}"
              class="menu-link {{ Route::currentRouteName() === 'quiz-type.index' || Route::currentRouteName() === 'quiz-type.create' || Route::currentRouteName() === 'quiz-type.edit' ? 'active' : '' }}">
              <i class="menu-icon tf-icons bx bx-list-ul"></i>
              <div>Quiz Type Master</div>
          </a>
        </li>

        <li class="menu-item {{ Route::currentRouteName() === 'quiz-master.index' || Route::currentRouteName() === 'quiz-master.create' || Route::currentRouteName() === 'quiz-master.edit' || Route::currentRouteName() === 'quiz-master.questions' ? 'active' : '' }}">
          <a href="{{ route('quiz-master.index') }}"
              class="menu-link {{ Route::currentRouteName() === 'quiz-master.index' || Route::currentRouteName() === 'quiz-master.create' || Route::currentRouteName() === 'quiz-master.edit' || Route::currentRouteName() === 'quiz-master.questions' ? 'active' : '' }}">
              <i class="menu-icon tf-icons bx bx-question-mark"></i>
              <div>Quiz Master</div>
          </a>
        </li>

    </ul>


    <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow footerbg-profile" href="javascript:void(0);"
            data-bs-toggle="dropdown">
            <div class="w-full mx-3 loggedProfile">

                @if (auth()->user()->image != null)
                    <img src="{{ URL::to('/') }}/{{ auth()->user()->image }}" alt class="rounded-circle"><span
                        class="fw-medium d-block">{{ auth()->user()->name }}</span>
                @else
                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="rounded-circle"><span
                        class="fw-medium d-block">{{ auth()->user()->name }}</span>
                @endif

            </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            {{-- <li>
                <a class="dropdown-item" href="javascript:void(0);">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar w-full mx-3">
                        @if (auth()->user()->image != null)
                        <img src="{{ URL::to('/') }}/{{ auth()->user()->image }}" alt class="w-px-40 h-auto rounded-circle">
                        @else
                        <img src="{{asset('assets/img/avatars/1.png')}}" alt class="w-px-40 h-auto rounded-circle">
                        @endif

                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-medium d-block">{{ auth()->user()->name }}</span>
                      <small class="text-muted"> @if (auth()->user()->role_id == 1) Admin @endif </small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider"></div>
              </li> --}}
            <li>
                <a class="dropdown-item" href="{{ route('profile') }}">
                    <i class="bx bx-user me-2"></i>
                    <span class="align-middle">My Profile</span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('profile.password') }}">
                    <i class='bx bx-cog me-2'></i>
                    <span class="align-middle">Change Password</span>
                </a>
            </li>
            <li>
                <div class="dropdown-divider"></div>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}">
                    <i class='bx bx-power-off me-2'></i>
                    <span class="align-middle">Log Out</span>
                </a>
            </li>
        </ul>
    </li>

</aside>
