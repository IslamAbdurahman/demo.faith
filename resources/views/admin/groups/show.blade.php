@extends('layouts.main')

@section('main-content')

    <style>

        .select2-selection__choice__display{
            color: #1f1a1a;
        }
        /*ul {*/
        /*    list-style-type: none;*/
        /*}*/

        /*li {*/
        /*    display: inline-block;*/
        /*}*/

        input[type="checkbox"][id^="cb"] {
            display: none;
        }

        .label-check {
            border: 1px solid #fff;
            /*padding: 5px 0;*/
            display: block;
            position: relative;
            /*margin: 5px 0;*/
            width: 25px;
            height: 25px;
            cursor: pointer;
            border-radius: 6px;
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
            display: inline;
            border-radius: 50%;
            border: 1px solid grey;
            position: absolute;
            top: -5px;
            left: -5px;
            width: 15px;
            height: 15px;
            text-align: center;
            line-height: 7px;
            transition-duration: 0.4s;
            transform: scale(0);
        }


        :checked+.label-check {
            border-color: #ddd;
        }

        :checked+.label-check::before {
            content: "-";
            font-size: 32px;
            background-color: red;
            border-color: white;
            transform: scale(1);
        }

    </style>

<style>
    .modal {
        padding: 0 !important; // override inline padding-right added from js
    }
    .modal-dialog-fullscreen {
        width: 100%;
        max-width: none;
        /*height: 100%;*/
        margin: 0;
    }
    .modal-content-fullscreen {
        height: 100%;
        border: 0;
        border-radius: 0;
    }
    .modal-body-fullscreen {
        overflow-y: auto;
        height: 650px;
    }
</style>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <div class="card">
        <div class="card-header">
            <ul class="navbar list-unstyled m-0 p-0">
                <li>
                    <a href="{{ route('groups.index') }}">
                        <i class="fas fa-long-arrow-left bg-gradient-info p-2 px-3 rounded"></i>
                    </a>
                </li>
                <li>
                    <a class="btn btn-primary my-0 py-0 px-1" href="{{ route('group.export',$group->id) }}?group_route={{$group_route}}">
                        <i class="fas fa-cloud-download"></i>
                    </a>
                    <button type="button" class="btn btn-success my-0 py-0 px-2" data-toggle="modal" data-target="#group_sms">
                        <i class="fas fa-sms m-0 p-0"></i>
                    </button>
                    <div class="modal fade" id="group_sms">
                        <div class="modal-dialog">
                            <div class="modal-content bg-primary">
                                <form action="{{ route('group.sms') }}" method="post" enctype="multipart/form-data">

                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('lang.send_sms_all_students') }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        @csrf
                                        @method('post')
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{ __('lang.sms') }}</label>
                                                <textarea name="sms" class="form-control"></textarea>
                                            </div>

                                            <input type="hidden" name="group_id" value="{{$group->id}}">


                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                                <label class="form-check-label" for="exampleCheck1">{{ __('lang.checking') }}</label>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{ __('lang.close') }}</button>
                                        <button type="submit" class="btn btn-light">{{ __('lang.send') }}</button>
                                    </div>

                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                </li>
                <li>
                    <h3 class="card-title">Group {{ $group->name }}</h3>
                </li>
                <li>

                    <!-- SEARCH FORM -->
                    <form action="{{ route('groups.show',$group->id) }}" method="get" class="form-inline m-0 ml-md-3">
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
                                <option {{ $group_page == 'gender' ? 'selected':'' }}  value="gender">{{ __('lang.gender') }}</option>
                                <option {{ $group_page == 'birth_date' ? 'selected':'' }}  value="birth_date">{{ __('lang.birthday') }}</option>
                                <option {{ $group_page == 'date' ? 'selected':'' }}  value="count">{{ __('lang.added_date') }}</option>
                                <option {{ $group_page == 'discount_education' ? 'selected':'' }}  value="discount_education">{{ __('lang.discount_education') }}</option>
                                <option {{ $group_page == 'missed' ? 'selected':'' }}  value="missed">{{ __('lang.missed') }}</option>
                            </select>
                            <select name="group_route" id="" class="form-control form-control-navbar">
                                <option {{ $group_route == 'asc' ? 'selected':'' }} value="asc">{{ __('lang.a_z') }}</option>
                                <option {{ $group_route == 'desc' ? 'selected':'' }}  value="desc">{{ __('lang.z_a') }}</option>
                            </select>
                            <input name="search" value="{{ $search }}" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
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
                    <th class="py-1">{{ __('lang.gender') }}</th>
                    <th class="py-1">{{ __('lang.birthday') }}</th>
                    <th class="py-1">{{ __('lang.added_date') }}</th>
                    <th class="py-1">{{ __('lang.discount_education') }}</th>
                    <th class="py-1">{{ __('lang.missed') }}</th>
                    <th class="py-1">
                        @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                            <button type="button" class="btn btn-success my-0 py-0 px-1" data-toggle="modal" data-target="#admin_add">
                                <i class="fas fa-calendar-plus m-0 p-0"></i>
                            </button>
                            <div class="modal fade" id="admin_add">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-success">
                                        <form action="{{ route('student_groups.store') }}" method="post" enctype="multipart/form-data">

                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ __('lang.add') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                <div class="card-body">

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.students') }}</label>
                                                        <select name="student_id[]" id="" class="form-control js-example-basic-multiple"
                                                                multiple="multiple"
                                                                style="width: 100%; display: block"
                                                        >
{{--                                                            <option value="" selected disabled>{{ __('lang.not_selected') }}</option>--}}
                                                        @foreach($students_all as $student)
                                                            <option value="{{$student->id}}">{{ $student->name }}</option>
                                                        @endforeach
                                                        </select>

                                                        <script>
                                                            $(document).ready(function() {
                                                                $('.js-example-basic-multiple').select2();
                                                            });
                                                        </script>

                                                        <input type="hidden" name="group_id" value="{{$group->id}}">

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

                            <button type="button" class="btn btn-success my-0 py-0 px-1" data-toggle="modal" data-target="#attend">
                                <i class="fas fa-th m-0 p-0"></i>
                            </button>
                            <div class="modal fade" id="attend">
                                <div class="modal-dialog modal-dialog-fullscreen">
                                    <div class="modal-content modal-content-fullscreen">
                                        <form action="{{ route('attendances.store') }}" method="post" enctype="multipart/form-data">

                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ __('lang.group') }} : {{ $group->name }} {{ __('lang.attendance') }} {{ date('F') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body modal-body-fullscreen">

                                                @csrf
                                                <div class="card-body" >

                                                    <div class="table table-responsive">

                                                        <table class="table table-striped">
                                                            <thead>
                                                            <tr>
                                                                <th class="py-1">N</th>
                                                                <th class="py-1">{{ __('lang.name') }}</th>
                                                                @foreach($lessons as $lesson)
                                                                    <th class="py-1 {{ intval(date('d')) == $lesson? 'bg-info':'' }} ">{{ $lesson }}</th>
                                                                @endforeach
                                                                <th class="missed-col p-1">{{ __('lang.missed') }}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($students as $student)
                                                                <tr>
                                                                    <td  class="py-1 ">
                                                                        {{($students->currentpage()-1)*$students->perpage()+($loop->index+1)}}
                                                                    </td>
                                                                    <td  class="py-1">{{ $student->name }}</td>
                                                                    @foreach($lessons as $lesson)
                                                                        @if(intval(date('d')) > $lesson)
                                                                            <div class="d-none">{{ $k = 0 }}</div>

                                                                            @foreach($attendances as $attendance)
                                                                                @if(date('Y-m-d',strtotime(date('Y-m').'-'.$lesson)) == date('Y-m-d',strtotime($attendance->date)) && $student->id == $attendance->student_id)
                                                                                    <div class="d-none">{{ $k = 1 }}</div>

                                                                                    <td class="py-1">
                                                                                        <div class="d-flex justify-content-around">
                                                                                            <input type="checkbox" id="cb{{$student->id.'-'.$lesson}}0" checked>
                                                                                            <label for="cb{{$student->id.'-'.$lesson}}0"
                                                                                                   class="label-check  {{ $attendance->status == 0? 'bg-danger':'bg-primary' }}" for="cb1">
                                                                                                {{ $attendance->status == 0? __('lang.absent'): __('lang.reason') }}
                                                                                            </label>
                                                                                        </div>
                                                                                    </td>
                                                                                @endif
                                                                            @endforeach
                                                                            @if($k == 0)
                                                                                <td class="py-1">
                                                                                    <div class="d-flex justify-content-around">
                                                                                        <input type="checkbox" id="cb{{$student->id.'-'.$lesson}}0">
                                                                                        <label for="cb{{$student->id.'-'.$lesson}}0"
                                                                                               class="label-check bg-success" for="cb1">{{__('lang.came')}}</label>
                                                                                    </div>
                                                                                </td>
                                                                            @endif
                                                                            @elseif (intval(date('d')) == $lesson)
                                                                            <div class="d-none">{{ $t = 0 }}</div>

                                                                            @foreach($attendances as $attendance)
                                                                                @if(date('Y-m-d',strtotime(date('Y-m').'-'.$lesson)) == date('Y-m-d',strtotime($attendance->date)) && $student->id == $attendance->student_id)
                                                                                    <div class="d-none">{{ $t = 1 }}</div>
                                                                                    <td class="py-1">
                                                                                        <div class="d-flex justify-content-around">
                                                                                            <input type="checkbox" id="cb{{$student->id.'-'.$lesson}}0" {{ $attendance->status == 0? 'checked':'' }}
                                                                                                   name="status[]" value="0,{{$student->id.','.$group->id.','.date('Y-m').'-'.$lesson}}">
                                                                                            <label for="cb{{$student->id.'-'.$lesson}}0" class="label-check bg-danger" for="cb1">{{__('lang.absent')}}</label>
                                                                                            <input type="checkbox" id="cb{{$student->id.'-'.$lesson}}1" {{ $attendance->status == 1? 'checked':'' }}
                                                                                                   name="status[]" value="1,{{$student->id.','.$group->id.','.date('Y-m').'-'.$lesson}}">
                                                                                            <label for="cb{{$student->id.'-'.$lesson}}1" class="label-check bg-primary" for="cb1">{{__('lang.reason')}}</label>
                                                                                        </div>
                                                                                    </td>
                                                                                @endif
                                                                            @endforeach
                                                                            @if($t == 0)
                                                                                <td class="py-1">
                                                                                    <div class="d-flex justify-content-around">
                                                                                        <input type="checkbox" id="cb{{$student->id.'-'.$lesson}}0" name="status[]" value="0,{{$student->id.','.$group->id.','.date('Y-m').'-'.$lesson}}">
                                                                                        <label for="cb{{$student->id.'-'.$lesson}}0" class="label-check bg-danger" for="cb1">{{__('lang.absent')}}</label>
                                                                                        <input type="checkbox" id="cb{{$student->id.'-'.$lesson}}1" name="status[]" value="1,{{$student->id.','.$group->id.','.date('Y-m').'-'.$lesson}}">
                                                                                        <label for="cb{{$student->id.'-'.$lesson}}1" class="label-check bg-primary" for="cb1">{{__('lang.reason')}}</label>
                                                                                    </div>
                                                                                </td>
                                                                            @endif
                                                                            @else
                                                                        <td class="py-1">

                                                                        </td>
                                                                        @endif
                                                                    @endforeach
                                                                    <td class="missed-col py-1">{{ $student->missed }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        <div class="text-right">
                                                                <div class="form-check btn btn-info btn-sm pl-4">
                                                                    <input class="form-check-input" type="checkbox" id="check1" name="sms">
                                                                    <label class="form-check-label" for="check1">{{ __('lang.send_sms') }}</label>
                                                                </div>
                                                        </div>
                                                    </div>


                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('lang.close') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
                                            </div>

                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>

                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                    <tr>
                        <td class="py-1">
                            {{($students->currentpage()-1)*$students->perpage()+($loop->index+1)}}
                        </td>
                        <td class="py-1">
                            <a href="{{ route('attendances.show_two',[$student->id,$group->id]) }}">
                                {{ $student->name }}
                            </a>
                        </td>
                        <td class="py-1">{{ $student->gender }}</td>
                        <td class="py-1">{{ $student->birth_date }}</td>
                        <td class="py-1">{{ $student->date }}</td>
                        <td class="py-1">{{ $student->discount_education }}</td>
                        <td class="py-1">{{ $student->missed }}</td>
                        <td class="py-1">

                            <button type="button" class="btn btn-info my-0 py-0 px-1" data-toggle="modal" data-target="#modal{{ $loop->index+1 }}">
                                <i class="fas fa-sms m-0 p-0"></i>
                            </button>
                            <div class="modal fade" id="modal{{ $loop->index+1 }}">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-primary">
                                        <form action="{{ route('student_groups.update', $student->id) }}" method="post" enctype="multipart/form-data">

                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ __('lang.send_sms') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                @method('PUT')
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.sms') }}</label>
                                                        <textarea name="sms" class="form-control"></textarea>
{{--                                                        <input name="sms" type="text" class="form-control" id="exampleInputEmail1" placeholder="Type sms">--}}
                                                    </div>

                                                    <input type="hidden" name="group_id" value="{{$group->id}}">


                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                                        <label class="form-check-label" for="exampleCheck1">{{ __('lang.checking') }}</label>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">{{ __('lang.close') }}</button>
                                                <button type="submit" class="btn btn-light">{{ __('lang.send') }}</button>
                                            </div>

                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                            @if( Auth::user()->role == 1 || Auth::user()->role == 2)




                                <button type="button" class="btn btn-danger my-0 py-0 px-1" data-toggle="modal" data-target="#modal-danger{{ $student->id }}">
                                    <i class="fas fa-trash m-0 p-0"></i>
                                </button>

                                <div class="modal fade" id="modal-danger{{ $student->id }}">
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
                                                <form class="d-inline" action="{{ route('student_groups.destroy',$student->sg_id) }}" method="post">
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

                        </td>
                    </tr>

                @endforeach


                </tbody>
            </table>
            <div>{{ $students->appends($_GET)->links() }}</div>
        </div>
        <!-- /.card-body -->
@endsection
