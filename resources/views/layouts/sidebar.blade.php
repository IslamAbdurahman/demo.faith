<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('assets/image/edu-logo.png') }}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">
            @if(Auth::user()->role == 1)
                Super Admin
            @elseif(Auth::user()->role == 2)
                Admin
            @elseif(Auth::user()->role == 3)
                Manager
            @elseif(Auth::user()->role == 4)
                Teacher
            @endif
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('storage/images/'.Auth::user()->image) }}"
                     class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.edit', Auth::user()->id ) }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{--        <div class="form-inline">--}}
        {{--            <div class="input-group" data-widget="sidebar-search">--}}
        {{--                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">--}}
        {{--                <div class="input-group-append">--}}
        {{--                    <button class="btn btn-sidebar">--}}
        {{--                        <i class="fas fa-search fa-fw"></i>--}}
        {{--                    </button>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                {{--                @if(Auth::user()->role == 1 || Auth::user()->role == 2)--}}
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                       class="nav-link {{ request()->is('admin/dashboard','admin/dashboard/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>
                            {{ __('lang.dashboard') }}
                            <span class="right badge badge-success">Faith</span>
                        </p>
                    </a>
                </li>
                {{--                @endif--}}

                <li class="nav-item  {{ request()->is('admin/admin','admin/buyer','admin/teachers','admin/workers') ? 'menu-open' : '' }}">
                    <a href="#"
                       class="nav-link {{ request()->is('admin/admin','admin/buyer','admin/admin/*/edit','admin/teachers','admin/workers') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{ __('lang.profile') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 1 || \Illuminate\Support\Facades\Auth::user()->role == 2)
                            <li class="nav-item">
                                <a href="{{ route('admin.index')}}"
                                   class="nav-link {{ request()->is('admin/admin') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('lang.admins') }}</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('teachers.index')}}"
                                   class="nav-link {{ request()->is('admin/teachers') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('lang.teachers') }}</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('workers.index')}}"
                                   class="nav-link {{ request()->is('admin/workers') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('lang.workers') }}</p>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a href="{{ route('admin.edit',Auth::user()->id) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('lang.edit_profile') }}</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="far fa-circle nav-icon"></i>
                                {{ __('lang.log_out') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>


                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rooms.index') }}"
                       class="nav-link {{ request()->is('rooms','rooms/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-door-open"></i>
                        <p>
                            {{ __('lang.rooms') }}
                            <span class="right badge badge-success">
                                {{ \App\Models\Room::all()->count() }}
                            </span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sciences.index') }}"
                       class="nav-link {{ request()->is('sciences','sciences/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-flask"></i>
                        <p>
                            {{ __('lang.sciences') }}
                            <span class="right badge badge-success">
                                {{ \App\Models\Science::all()->count() }}
                            </span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('students.index') }}"
                       class="nav-link {{ request()->is('students','students/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            {{ __('lang.students') }}
                            <span class="right badge badge-success">
                                {{ \App\Models\Students::all()->count() }}
                            </span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('courses.index') }}"
                       class="nav-link {{ request()->is('courses','courses/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            {{ __('lang.courses') }}
                            <span class="right badge badge-success">
                                {{ \App\Models\Course::all()->count() }}
                            </span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('groups.index') }}"
                       class="nav-link {{ request()->is('groups','groups/*','admin/attendances/*/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-people-carry"></i>
                        <p>
                            {{ __('lang.groups') }}
                            <span class="right badge badge-success">
                                {{ \Illuminate\Support\Facades\Auth::user()->role == 1 || \Illuminate\Support\Facades\Auth::user()->role ==2 ?
                                       \App\Models\Group::all()->count() : \App\Models\Group::where('teacher_id',
                                       \Illuminate\Support\Facades\Auth::user()->id)->count()}}
                            </span>
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('graphics.index') }}"
                       class="nav-link {{ request()->is('graphics','graphics/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-day"></i>
                        <p>
                            {{ __('lang.graphics') }}
                            <span class="right badge badge-success">
                                {{ \Illuminate\Support\Facades\Auth::user()->role == 1 || \Illuminate\Support\Facades\Auth::user()->role ==2 ?
                                       \App\Models\Graphic::where('remaining_amount','>',0)->get()->count() :
                                        DB::table('graphics as gr')
                                        ->join('groups as g','g.id','=','gr.group_id')
                                        ->where('g.teacher_id','=',Auth::user()->id)
                                        ->where('gr.remaining_amount','>',0)
                                        ->groupBy('gr.id')->get()->count()
                                       }}
                            </span>
                        </p>
                    </a>
                </li>


                @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                    <li class="nav-item">
                        <a href="{{ route('kassas.index') }}"
                           class="nav-link {{ request()->is('admin/kassas','admin/kassas/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cash-register"></i>
                            <p>
                                {{ __('lang.cashbox') }}
                                <span class="right badge badge-success">
                                    {{ number_format(\App\Models\Kassa::all()->sum('balance'), 0, ',', '.') }}
                                </span>
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('payments.index') }}"
                       class="nav-link {{ request()->is('payments','payments/*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-check"></i>
                        <p>
                            {{ __('lang.payments') }}
                            <span class="right badge badge-success">
                                {{ \Illuminate\Support\Facades\Auth::user()->role == 1 || \Illuminate\Support\Facades\Auth::user()->role ==2 ?
                                       \App\Models\Payment::all()->count() :
                                        DB::table('payments as p')
                                        ->leftJoin('graphics as gr','gr.id','=','p.graphic_id')
                                        ->join('groups as g','g.id','=','gr.group_id')
                                        ->where('g.teacher_id','=',Auth::user()->id)
                                        ->groupBy('p.id')->get()->count()
                                       }}
                            </span>
                        </p>
                    </a>
                </li>

                @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                    <li class="nav-item">
                        <a href="{{ route('salaries.index') }}"
                           class="nav-link {{ request()->is('admin/salaries','admin/salaries/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                {{ __('lang.outputs') }}
                                <span class="right badge badge-success">
                                    {{ \App\Models\Salary::all()->count() }}
                                </span>
                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="{{ route('tests.index') }}"
                           class="nav-link {{ request()->is('admin/tests','admin/tests/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-window-restore"></i>
                            <p>
                                {{ __('lang.tests') }}
                                <span class="right badge badge-success">
                                    {{ \App\Models\Test::all()->count() }}
                                </span>
                            </p>
                        </a>
                    </li>
                @endif


                <li class="nav-header">{{ __('lang.developer') }}</li>
                <li class="nav-item">
                    <a href="https://cv.faith.uz/" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>IslamAbdurahman</p>
                    </a>
                </li>


            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

