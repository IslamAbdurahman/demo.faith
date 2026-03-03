@extends('layouts.main')

@section('main-content')

    <div class="card">
        <div class="card-header">
            <ul class="navbar list-unstyled m-0 p-0">
                @if(\Illuminate\Support\Facades\Auth::user()->role == 1 ||
                    \Illuminate\Support\Facades\Auth::user()->role == 2)
                    <li>
                        <a class="btn btn-primary my-0 py-0 px-1"
                           href="{{ route('student.export') }}?search={{$search}}&group={{$group}}&group_route={{$group_route}}">
                            <i class="fas fa-cloud-download"></i>
                        </a>

                        <button type="button" class="btn btn-warning my-0 py-0 px-1" data-toggle="modal"
                                data-target="#upload_excel">
                            <i class="fas fa-cloud-upload m-0 p-0"></i>
                        </button>

                        <div class="modal fade" id="upload_excel">
                            <div class="modal-dialog">
                                <div class="modal-content bg-info">
                                    <form action="{{ route('student.import') }}" method="post"
                                          enctype="multipart/form-data">

                                        <div class="modal-header">
                                            <h4 class="modal-title">{{ __('lang.upload_excel') }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            @csrf
                                            @method('post')
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label
                                                        for="exampleInputEmail1">{{ __('lang.upload_excel') }}</label>
                                                    <input type="file" name="file_excel" class="form-control">
                                                </div>

                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                                           required>
                                                    <label class="form-check-label"
                                                           for="exampleCheck1">{{ __('lang.checking') }}</label>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-outline-light"
                                                    data-dismiss="modal">{{ __('lang.close') }}</button>
                                            <button type="submit" class="btn btn-light">{{ __('lang.save') }}</button>
                                        </div>

                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->

                        <button type="button" class="btn btn-success my-0 py-0 px-2" data-toggle="modal"
                                data-target="#group_sms">
                            <i class="fas fa-sms m-0 p-0"></i>
                        </button>

                        <div class="modal fade" id="group_sms">
                            <div class="modal-dialog">
                                <div class="modal-content bg-primary">
                                    <form action="{{ route('students.sms') }}" method="post"
                                          enctype="multipart/form-data">

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
                                                    <textarea placeholder="{{ __('lang.type_sms') }}" name="sms"
                                                              class="form-control"></textarea>
                                                </div>

                                                <input type="hidden" name="search" value="{{$search}}">
                                                <input type="hidden" name="group" value="{{$group}}">

                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                                           required>
                                                    <label class="form-check-label"
                                                           for="exampleCheck1">{{ __('lang.checking') }}</label>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-outline-light"
                                                    data-dismiss="modal">{{ __('lang.close') }}</button>
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
                @endif
                <li>
                    <h3 class="card-title">{{ __('lang.students') }}</h3>
                </li>
                <li>

                    <!-- SEARCH FORM -->
                    <form action="{{ route('students.index') }}" method="get" class="form-inline m-0 ml-md-3">
                        @csrf
                        <div class="input-group input-group-sm">
                            <input name="per_page" id="" value="{{$per_page}}" type="number"
                                   class="form-control form-control-navbar" list="per_page">
                            <datalist id="per_page">
                                <option value="10">
                                <option value="20">
                                <option value="50">
                                <option value="100">
                            </datalist>
                            <select name="group" id="" class="form-control form-control-navbar">
                                <option
                                    {{ $group == 'name' ? 'selected':'' }} value="name">{{ __('lang.name') }}</option>
                                <option
                                    {{ $group == 'gender' ? 'selected':'' }}  value="gender">{{ __('lang.gender') }}</option>
                                <option
                                    {{ $group == 'birth_date' ? 'selected':'' }}  value="birth_date">{{ __('lang.birthday') }}</option>
                                <option
                                    {{ $group == 'discount_education' ? 'selected':'' }}  value="discount_education">{{ __('lang.discount_education') }}</option>
                                <option
                                    {{ $group == 'group_names' ? 'selected':'' }}  value="group_names">{{ __('lang.group') }}</option>
                            </select>
                            <select name="group_route" id="" class="form-control form-control-navbar">
                                <option
                                    {{ $group_route == 'asc' ? 'selected':'' }} value="asc">{{ __('lang.a_z') }}</option>
                                <option
                                    {{ $group_route == 'desc' ? 'selected':'' }}  value="desc">{{ __('lang.z_a') }}</option>
                            </select>
                            <input name="search" value="{{ $search }}" class="form-control form-control-navbar"
                                   type="search" placeholder="{{ __('lang.search') }}" aria-label="Search">
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
                    <th class="py-1">{{ __('lang.phone') }}</th>
                    <th class="py-1">{{ __('lang.parent_phone') }}</th>
                    <th class="py-1">{{ __('lang.discount_education') }}</th>
                    <th class="py-1">{{ __('lang.groups') }}</th>
                    <th class="py-1">
                        @if(Auth::user()->role == 1  || Auth::user()->role == 2)
                            <button type="button" class="btn btn-success my-0 py-0 px-1" data-toggle="modal"
                                    data-target="#admin_add">
                                <i class="fas fa-calendar-plus m-0 p-0"></i>
                            </button>
                            <div class="modal fade" id="admin_add">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-success">
                                        <form action="{{ route('students.store') }}" method="post"
                                              enctype="multipart/form-data">

                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ __('lang.add') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.name') }}</label>
                                                        <input name="name" type="text" class="form-control" value=""
                                                               id="exampleInputEmail1"
                                                               placeholder="{{ __('lang.type_name') }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.gender') }}</label>
                                                        <select name="gender" id="" class="form-control">
                                                            <option value="" selected
                                                                    disabled>{{ __('lang.select_gender') }}</option>
                                                            <option value="male">{{ __('lang.male') }}</option>
                                                            <option value="female">{{ __('lang.female') }}</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            for="exampleInputEmail1">{{ __('lang.birthday') }}</label>
                                                        <input name="birth_date" type="date" class="form-control"
                                                               value="">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.phone') }}</label>
                                                        <input name="phone" type="number" class="form-control" value=""
                                                               id="exampleInputEmail1"
                                                               placeholder="{{ __('lang.type_phone') }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            for="exampleInputEmail1">{{ __('lang.parent_phone') }}</label>
                                                        <input name="parent_phone" type="number" class="form-control"
                                                               value="" id="exampleInputEmail1"
                                                               placeholder="{{ __('lang.type_parent_phone') }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label
                                                            for="exampleInputEmail1">{{ __('lang.discount') }}</label>
                                                        <input name="discount_education" type="number" min="0" max="100"
                                                               class="form-control" value="0" id="exampleInputEmail1"
                                                               placeholder="{{ __('lang.percent') }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.groups') }}</label>
                                                        <select name="group_id" id=""
                                                                class="form-control select-search">
                                                            <option value="" selected
                                                                    disabled>{{ __('lang.select_group') }}</option>
                                                            @foreach($groups as $group)
                                                                <option
                                                                    value="{{$group->id}}">{{ $group->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.lids') }}</label>
                                                        <select name="lid_id" id="" class="form-control select-search">
                                                            <option value="" selected
                                                                    disabled>{{ __('lang.select_lid') }}</option>
                                                            @foreach($lids as $lid)
                                                                <option value="{{$lid->id}}">{{ $lid->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.comment') }}</label>
                                                        <input name="comment" type="text" class="form-control"
                                                               value="Comment" id="exampleInputEmail1"
                                                               placeholder="{{ __('lang.type_comment') }}">
                                                    </div>

                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input"
                                                               id="exampleCheck1" required>
                                                        <label class="form-check-label"
                                                               for="exampleCheck1">{{ __('lang.checking') }}</label>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-outline-light"
                                                        data-dismiss="modal">{{ __('lang.close') }}</button>
                                                <button type="submit"
                                                        class="btn btn-outline-light">{{ __('lang.save') }}</button>
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
                @foreach($students as $student)
                    <tr>
                        <td class="py-1">
                            {{($students->currentpage()-1)*$students->perpage()+($loop->index+1)}}
                        </td>
                        <td class="py-1">{{ $student->name }}</td>
                        <td class="py-1">
                            {{ $student->gender == 'male'? __('lang.male'):__('lang.female') }}
                        </td>
                        <td class="py-1">{{ $student->birth_date }}</td>
                        <td class="py-1">{{ $student->phone }}</td>
                        <td class="py-1">{{ $student->parent_phone }}</td>
                        <td class="py-1">{{ $student->discount_education }}</td>
                        <td class="py-1">{{ $student->group_names }}</td>
                        <td class="py-1">


                            @if( Auth::user()->role == 1  || Auth::user()->role == 2)
                                <button type="button" class="btn btn-info  my-0 py-0 px-1" data-toggle="modal"
                                        data-target="#modal{{ $loop->index+1 }}">
                                    <i class="fas fa-edit m-0 p-0"></i>
                                </button>
                                <div class="modal fade" id="modal{{ $loop->index+1 }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-primary">
                                            <form action="{{ route('students.update', $student->id) }}" method="post"
                                                  enctype="multipart/form-data">

                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{ __('lang.update') }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    @csrf
                                                    @method('PUT')
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ __('lang.name') }}</label>
                                                            <input name="name" type="text" class="form-control"
                                                                   value="{{ $student->name }}" id="exampleInputEmail1"
                                                                   placeholder="{{ __('lang.type_name') }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ __('lang.gender') }}</label>
                                                            <select name="gender" id="" class="form-control">
                                                                <option
                                                                    value="male" {{ $student->gender == 'male'? 'selected':'' }}>{{ __('lang.male') }}</option>
                                                                <option
                                                                    value="female" {{ $student->gender == 'female'? 'selected':'' }}>{{ __('lang.female') }}</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ __('lang.birthday') }}</label>
                                                            <input name="birth_date" type="date" class="form-control"
                                                                   value="{{ $student->birth_date }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ __('lang.phone') }}</label>
                                                            <input name="phone" type="number" class="form-control"
                                                                   value="{{ $student->phone }}" id="exampleInputEmail1"
                                                                   placeholder="{{ __('lang.type_phone') }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ __('lang.parent_phone') }}</label>
                                                            <input name="parent_phone" type="number"
                                                                   class="form-control"
                                                                   value="{{ $student->parent_phone }}"
                                                                   id="exampleInputEmail1"
                                                                   placeholder="{{ __('lang.type_parent_phone') }}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label
                                                                for="exampleInputEmail1">{{ __('lang.discount_education') }}</label>
                                                            <input name="discount_education" min="0" max="100"
                                                                   type="number" class="form-control"
                                                                   value="{{ $student->discount_education }}"
                                                                   id="exampleInputEmail1"
                                                                   placeholder="{{ __('lang.percent') }}">
                                                        </div>


                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input"
                                                                   id="exampleCheck1" required>
                                                            <label class="form-check-label"
                                                                   for="exampleCheck1">{{ __('lang.checking') }}</label>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-outline-light"
                                                            data-dismiss="modal">{{ __('lang.close') }}</button>
                                                    <button type="submit"
                                                            class="btn btn-outline-light">{{ __('lang.save') }}</button>
                                                </div>

                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->


                                <button type="button" class="btn btn-danger my-0 py-0 px-1" data-toggle="modal"
                                        data-target="#modal-danger{{ $student->id }}">
                                    <i class="fas fa-trash m-0 p-0"></i>
                                </button>

                                <div class="modal fade" id="modal-danger{{ $student->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-danger">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ __('lang.delete') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>{{ __('lang.delete_message') }}</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-outline-light"
                                                        data-dismiss="modal">{{ __('lang.close') }}</button>
                                                <form class="d-inline"
                                                      action="{{ route('students.destroy',$student->id) }}"
                                                      method="post">
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
