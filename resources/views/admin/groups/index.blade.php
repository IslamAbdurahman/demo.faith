@extends('layouts.main')

@section('main-content')

    <style>
        ul {
            list-style-type: none;
        }

        input[type="checkbox"][id^="cb"] {
            display: none;
        }

        .label-check {
            border: 1px solid #fff;
            padding: 10px;
            display: block;
            position: relative;
            margin: 10px;
            width: 100px;
            cursor: pointer;
            border-radius: 12px;
            text-align: center;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .label-check::before {
            background-color: white;
            color: white;
            content: " ";
            display: block;
            border-radius: 50%;
            border: 1px solid grey;
            position: absolute;
            top: -5px;
            left: -5px;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 28px;
            transition-duration: 0.4s;
            transform: scale(0);
        }

        .label-check img {
            height: 100px;
            width: 100px;
            transition-duration: 0.2s;
            transform-origin: 50% 50%;
        }

        :checked+.label-check {
            border-color: #ddd;
        }

        :checked+.label-check::before {
            content: "✓";
            background-color: grey;
            transform: scale(1);
        }

    </style>

    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <ul class="navbar list-unstyled m-0 p-0">
                <li>
                    <h3 class="card-title">{{ __('lang.groups') }}</h3>
                </li>
                <li>

                    <!-- SEARCH FORM -->
                    <form action="{{ route('groups.index') }}" method="get" class="form-inline m-0 ml-md-3">
                        @csrf
                        <div class="input-group input-group-sm">
                            <select name="per_page" id="" class="form-control form-control-navbar">
                                <option {{ $per_page == 10 ? 'selected':'' }} value="10">10</option>
                                <option {{ $per_page == 20 ? 'selected':'' }}  value="20">20</option>
                                <option {{ $per_page == 50 ? 'selected':'' }}  value="50">50</option>
                                <option {{ $per_page == 100 ? 'selected':'' }}  value="100">100</option>
                            </select>
                            <select name="group_page" id="" class="form-control form-control-navbar">
                                <option {{ $group_page == 'name' ? 'selected':'' }} value="name">{{ __('lang.name') }}</option>
                                <option {{ $group_page == 'level' ? 'selected':'' }}  value="level">{{ __('lang.level') }}</option>
                                <option {{ $group_page == 'amount' ? 'selected':'' }}  value="amount">{{ __('lang.amount') }}</option>
                                <option {{ $group_page == 'teacher' ? 'selected':'' }}  value="teacher">{{ __('lang.teacher') }}</option>
                                <option {{ $group_page == 'room' ? 'selected':'' }}  value="room">{{ __('lang.room') }}</option>
                                <option {{ $group_page == 'students' ? 'selected':'' }}  value="students">{{ __('lang.students') }}</option>
                                <option {{ $group_page == 'percent' ? 'selected':'' }}  value="percent">{{ __('lang.percent') }}</option>
                            </select>
                            <select name="group_route" id="" class="form-control form-control-navbar">
                                <option {{ $group_route == 'asc' ? 'selected':'' }} value="asc">{{ __('lang.a_z') }}</option>
                                <option {{ $group_route == 'desc' ? 'selected':'' }}  value="desc">{{ __('lang.z_a') }}</option>
                            </select>
                                <input name="search" value="{{ $search }}" class="form-control form-control-navbar" type="search" placeholder="{{ __('lang.search') }}" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
        <!-- /.card-header -->
        <div class="card-body pt-0 table-responsive">
            <table id="example1" class="table table-bordered table-striped ">
                <thead>
                <tr>
                    <th class="py-1">N</th>
                    <th class="py-1">{{ __('lang.name') }}</th>
                    <th class="py-1">{{ __('lang.level') }}</th>
                    <th class="py-1">{{ __('lang.amount') }}</th>
                    <th class="py-1">{{ __('lang.teacher') }}</th>
                    <th class="py-1">{{ __('lang.course') }}</th>
                    <th class="py-1">{{ __('lang.room') }}</th>
                    <th class="py-1">{{ __('lang.students') }}</th>
                    <th class="py-1">{{ __('lang.days') }}</th>
                    <th class="py-1">{{ __('lang.percent') }}</th>
                    <th class="py-1">{{ __('lang.start') }}</th>
                    <th class="py-1">{{ __('lang.end') }}</th>
                    <th class="py-1">
                        @if(Auth::user()->role == 1  || Auth::user()->role == 2)
                        <button type="button" class="btn btn-success my-0 py-0 px-1" data-toggle="modal" data-target="#admin_add">
                            <i class="fas fa-calendar-plus m-0 p-0"></i>
                        </button>
                        <div class="modal fade" id="admin_add">
                            <div class="modal-dialog">
                                <div class="modal-content bg-success">
                                    <form action="{{ route('groups.store') }}" method="post" enctype="multipart/form-data">

                                        <div class="modal-header">
                                            <h4 class="modal-title">{{ __('lang.add') }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body py-0">

                                            @csrf
                                            <div class="card-body py-0">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.name') }}</label>
                                                    <input name="name" type="text" class="form-control" value="" id="exampleInputEmail1" placeholder="{{ __('lang.type_name') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.level') }}</label>
                                                    <input name="level" type="text" class="form-control" value="" id="exampleInputEmail1" placeholder="{{ __('lang.type_level') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.amount') }}</label>
                                                    <input name="amount" type="number" class="form-control" value="" id="exampleInputEmail1" placeholder="{{ __('lang.type_amount') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.teacher') }}</label>
                                                    <select name="teacher_id" id="" class="form-control select-search">
                                                        <option value="" selected disabled>{{ __('lang.not_selected') }}</option>
                                                        @foreach($teachers as $teacher)
                                                            <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.course') }}</label>
                                                    <select name="course_id" id="" class="form-control select-search">
                                                        <option value="" selected disabled>{{ __('lang.not_selected') }}</option>
                                                        @foreach($courses as $course)
                                                            <option value="{{$course->id}}">{{$course->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.room') }}</label>
                                                    <select name="room_id" id="" class="form-control select-search">
                                                        <option value="" selected disabled>{{ __('lang.not_selected') }}</option>
                                                        @foreach($rooms as $room)
                                                            <option value="{{$room->id}}">{{$room->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">

                                                    <div>
                                                        <ul class="px-4">
                                                            <li class="d-inline-block">
                                                                <input name="days[]" value="1" type="checkbox" id="cb1" />
                                                                <label class="label-check" for="cb1">{{ __('lang.monday') }}</label>
                                                            </li>
                                                            <li class="d-inline-block">
                                                                <input name="days[]" value="2" type="checkbox" id="cb2" />
                                                                <label class="label-check" for="cb2">{{ __('lang.tuesday') }}</label>
                                                            </li>
                                                            <li class="d-inline-block">
                                                                <input name="days[]" value="3" type="checkbox" id="cb3" />
                                                                <label class="label-check px-0" for="cb3">{{ __('lang.wednesday') }}</label>
                                                            </li>
                                                            <li class="d-inline-block">
                                                                <input name="days[]" value="4" type="checkbox" id="cb4" />
                                                                <label class="label-check" for="cb4">{{ __('lang.thursday') }}</label>
                                                            </li>
                                                            <li class="d-inline-block">
                                                                <input name="days[]" value="5" type="checkbox" id="cb5" />
                                                                <label class="label-check "  for="cb5">{{ __('lang.friday') }}</label>
                                                            </li>
                                                            <li class="d-inline-block">
                                                                <input name="days[]" value="6" type="checkbox" id="cb6" />
                                                                <label class="label-check" for="cb6">{{ __('lang.saturday') }}</label>
                                                            </li>
                                                            <li class="d-flex justify-content-center">
                                                                <input name="days[]" value="7" type="checkbox" id="cb7" />
                                                                <label class="label-check" for="cb7">{{ __('lang.sunday') }}</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.teacher_percent') }}</label>
                                                    <input name="percent" type="number" min="0" max="100" class="form-control" value="" id="exampleInputEmail1" placeholder="{{ __('lang.percent') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.start') }}</label>
                                                    <input name="starts_at" type="time" class="form-control" value="" id="exampleInputEmail1">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.end') }}</label>
                                                    <input name="ends_at" type="time" class="form-control" value="" id="exampleInputEmail1">
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                                    <label class="form-check-label" for="exampleCheck1">{{ __('lang.checking') }}</label>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{ __('lang.close') }}</button>
                                            <button type="submit" class="btn btn-outline-light">{{ __('lang.save') }}</button>
                                        </div>

                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->


                        @else
                            {{ __('lang.rights') }}
                        @endif

                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <a href="{{ route('groups.show',$group->id) }}">
                    </a>
                <tr>
                    <td class="py-1">
                        {{($groups->currentpage()-1)*$groups->perpage()+($loop->index+1)}}
                    </td>
                    <td class="py-1">
                        <a href="{{ route('groups.show',$group->id) }}">
                            {{ $group->name }}
                        </a>
                     </td>
                    <td class="py-1">{{ $group->level }}</td>
                    <td class="py-1">
                        {{ number_format($group->amount , 0, ',', '.')  }} SUM
                    </td>
                    <td class="py-1">{{ $group->teacher }}</td>
                    <td class="py-1">{{ $group->course }}</td>
                    <td class="py-1">{{ $group->room }}</td>
                    <td class="py-1">{{ $group->students }}</td>
                    <td class="py-1">
                        @foreach(explode(',', $group->days) as $day)
                            {{ $weekdays[$day] }},
                        @endforeach
                    </td>
                    <td class="py-1">{{ $group->percent }} %</td>
                    <td class="py-1">{{ $group->starts_at }}</td>
                    <td class="py-1">{{ $group->ends_at }}</td>
                    <td class="py-1">


                        @if( Auth::user()->role == 1  || Auth::user()->role == 2)
                            <button type="button" class="btn btn-info my-0 py-0 px-1" data-toggle="modal" data-target="#modal{{ $loop->index+1 }}">
                                <i class="fas fa-edit m-0 p-0"></i>
                            </button>
                            <div class="modal fade" id="modal{{ $loop->index+1 }}">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-primary">
                                        <form action="{{ route('groups.update', $group->id) }}" method="post" enctype="multipart/form-data">

                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ __('lang.update') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                @method('PUT')
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.name') }}</label>
                                                        <input name="name" type="text" class="form-control" value="{{ $group->name }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_name') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.level') }}</label>
                                                        <input name="level" type="text" class="form-control" value="{{ $group->level }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_level') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.amount') }}</label>
                                                        <input name="amount" type="number" class="form-control" value="{{ $group->amount }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_amount') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.teacher') }}</label>
                                                        <select name="teacher_id" id="" class="form-control select-search">
                                                            @foreach($teachers as $teacher)
                                                                <option {{ $group->teacher_id == $teacher->id? 'selected':'' }}
                                                                        value="{{$teacher->id}}">{{$teacher->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.course') }}</label>
                                                        <select name="course_id" id="" class="form-control select-search">
                                                            @foreach($courses as $course)
                                                                <option {{ $group->course_id == $course->id? 'selected':'' }}
                                                                    value="{{$course->id}}">{{$course->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.room') }}</label>
                                                        <select name="room_id" id="" class="form-control select-search">
                                                            @foreach($rooms as $room)
                                                                <option {{ $group->room_id == $room->id? 'selected':'' }}
                                                                        value="{{$room->id}}">{{$room->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <div>
                                                            <ul class="px-4">

                                                                @foreach($weekdays as $weekday)
                                                                    <div class="d-none">{{ $s = 0 }}</div>

                                                                    @for($i=0;$i<count(explode(',',$group->days));$i++)
                                                                        @if(explode(',',$group->days)[$i] == $loop->index+1)
                                                                            <div class="d-none">{{ $s = 1 }}</div>
                                                                        <li class="d-inline-block">
                                                                            <input name="days[]" checked value="{{ $loop->index+1 }}" type="checkbox" id="cb{{ $group->id.$loop->index+10 }}" />
                                                                            <label class="label-check px-0" for="cb{{ $group->id.$loop->index+10 }}">{{ $weekday }}</label>
                                                                        </li>
                                                                        @endif
                                                                    @endfor

                                                                    @if($s == 0)
                                                                        <li class="d-inline-block">
                                                                            <input name="days[]" value="{{ $loop->index+1 }}" type="checkbox" id="cb{{ $group->id.$loop->index+10 }}" />
                                                                            <label class="label-check px-0" for="cb{{ $group->id.$loop->index+10 }}">{{ $weekday }}</label>
                                                                        </li>
                                                                    @endif

                                                                @endforeach

                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.teacher_percent') }}</label>
                                                        <input name="percent" type="number" min="0" max="100" class="form-control" value="{{ $group->percent }}" id="exampleInputEmail1" placeholder="{{ __('lang.percent') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.start') }}</label>
                                                        <input name="starts_at" type="time" class="form-control" value="{{ $group->starts_at }}" id="exampleInputEmail1">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.end') }}</label>
                                                        <input name="ends_at" type="time" class="form-control" value="{{ $group->ends_at }}" id="exampleInputEmail1">
                                                    </div>

                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                                        <label class="form-check-label" for="exampleCheck1">{{ __('lang.checking') }}</label>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{ __('lang.close') }}</button>
                                                <button type="submit" class="btn btn-outline-light">{{ __('lang.save') }}</button>
                                            </div>

                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->


                            <button type="button" class="btn btn-danger my-0 py-0 px-1" data-toggle="modal" data-target="#modal-danger{{ $group->id }}">
                                <i class="fas fa-trash m-0 p-0"></i>
                            </button>

                            <div class="modal fade" id="modal-danger{{ $group->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-danger">
                                        <div class="modal-header">
                                            <h4 class="modal-title">{{ __('lang.delete') }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ __('lang.delete_message') }}</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{ __('lang.close') }}</button>
                                                <form class="d-inline" action="{{ route('groups.destroy',$group->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-light">
                                                        {{ __('lang.delete') }}
                                                    </button>
                                                </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->


                            @endif




                            <button type="button" class="btn btn-success my-0 py-0 px-1" data-toggle="modal" data-target="#graphics_{{ $group->id }}">
                                <i class="fas fa-hamburger m-0 p-0"></i>
                            </button>
                            <div class="modal fade" id="graphics_{{ $group->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-success">
                                        <form action="{{ route('graphics.store') }}" method="post" enctype="multipart/form-data">

                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ __('lang.add_graphics') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body py-0">

                                                @csrf
                                                <div class="card-body py-0">
                                                    <div class="form-group">
                                                        <input name="group_id" type="hidden" class="form-control" value="{{ $group->id }}" >
                                                    </div>

                                                    <div class="form-group text-center">
                                                        <label class="text-center">{{ __('lang.select_year') }}</label>
                                                        <div class="d-flex justify-content-center">
                                                            <input type="number" name="year" class="d-block text-center form-control w-50" min="1900" max="2099" step="1" value="{{ date('Y') }}" />
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <ul class="px-4">
                                                            @foreach($months as $month)
                                                                <li class="d-inline-block">
                                                                    <input
                                                                           {{ date('m',strtotime(date('Y-m-d')))> date('m',strtotime($month))? 'disabled': 'name=month_list[]' }}
                                                                           value="{{ date('m',strtotime($month)) }}" type="checkbox" id="cb{{$group->id.$month}}" />
                                                                    <label class="label-check" for="cb{{$group->id.$month}}">
                                                                        {{ \Illuminate\Support\Carbon::parse(\Illuminate\Support\Carbon::create()->day(1)->month($loop->index+1))->translatedFormat('F') }}
                                                                    </label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                    <div>
                                                        <ul class="px-4" >
                                                            <li class="d-inline-block">
                                                                <input name="education" checked type="checkbox" id="cb{{$group->id}}edu" />
                                                                <label class="label-check bg-primary" for="cb{{$group->id}}edu">{{ __('lang.education') }}</label>
                                                            </li>
                                                            <li class="d-inline-block">
                                                                <input name="kitchen" type="checkbox" id="cb{{$group->id}}kitchen" />
                                                                <label class="label-check bg-primary" for="cb{{$group->id}}kitchen">{{ __('lang.kitchen') }}</label>
                                                            </li>
                                                            <li class="d-inline-block">
                                                                <input name="bedroom" type="checkbox" id="cb{{$group->id}}bedroom" />
                                                                <label class="label-check bg-primary" for="cb{{$group->id}}bedroom">{{ __('lang.bedroom') }}</label>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                                        <label class="form-check-label" for="exampleCheck1">{{ __('lang.checking') }}</label>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{ __('lang.close') }}</button>
                                                <button type="submit" class="btn btn-outline-light">{{ __('lang.save') }}</button>
                                            </div>

                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->


                            @if(\Illuminate\Support\Facades\Auth::user()->role == 1)
                                @if($group->status == 1)
                                    <a class="btn btn-primary my-0 py-0 px-1" href="{{ route('status.group',$group->id) }}?per_page={{ $per_page }}">
                                        <i class="fa fa-check-circle"></i>
                                    </a>
                                @else
                                    <a class="btn btn-danger my-0 py-0 px-1" href="{{ route('status.group',$group->id) }}?per_page={{ $per_page }}">
                                        <i class= "fa fa-minus-circle"></i>
                                    </a>
                                @endif
                            @endif

                    </td>
                </tr>

                @endforeach


                </tbody>
            </table>
            <div>{{ $groups->appends($_GET)->links() }}</div>
        </div>


        <!-- /.card-body -->
@endsection
