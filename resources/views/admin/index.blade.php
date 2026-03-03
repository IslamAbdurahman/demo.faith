@extends('layouts.main')

@section('main-content')
    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <ul class="navbar list-unstyled m-0 p-0">
                <li>
                    <h3 class="card-title">{{ __('lang.admins') }}</h3>
                </li>
                <li>
                    <!-- SEARCH FORM -->
                    <form action="{{ route('admin.index') }}" method="get" class="form-inline m-0 ml-md-3">
                        @csrf
                        <div class="input-group input-group-sm">
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
                    <th class="py-1">{{ __('lang.phone') }}</th>
                    <th class="py-1">{{ __('lang.email') }}</th>
                    <th class="py-1">{{ __('lang.image') }}</th>
                    <th class="py-1">{{ __('lang.role') }}</th>
                    <th class="py-1">
                        @if(Auth::user()->role == 1)
                        <button type="button" class="btn btn-success my-0 py-0 px-1" data-toggle="modal" data-target="#admin_add">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                                <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        </button>
                        <div class="modal fade" id="admin_add">
                            <div class="modal-dialog">
                                <div class="modal-content bg-primary">
                                    <form action="{{ route('admin.store') }}" method="post" enctype="multipart/form-data">

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
                                                    <label for="exampleInputEmail1">{{ __('lang.name') }}</label>
                                                    <input name="name" type="text" class="form-control" value="" id="exampleInputEmail1" placeholder="{{ __('lang.type_name') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.phone') }}</label>
                                                    <input name="phone" type="number" class="form-control" value="" id="exampleInputEmail1" placeholder="{{ __('lang.type_phone') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.email') }}</label>
                                                    <input name="email" type="email" class="form-control" value="" id="exampleInputEmail1" placeholder="{{ __('lang.type_email') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">{{ __('lang.password') }}</label>
                                                    <input name="password" type="text" class="form-control" id="exampleInputPassword1" placeholder="{{ __('lang.type_password') }}" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputFile">{{ __('lang.image') }}</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input name="image" id="imgInp" onchange="preview(admin_image)" type="file" class="custom-file-input" id="exampleInputFile">
                                                                    <label class="custom-file-label" for="exampleInputFile">{{ __('lang.select') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="mb-2" for="image"><b>{{ __('lang.image') }}</b></label>
                                                        <img id="admin_image" class="ml-2" src="" width="100px" height="100px" alt="Image"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleSelectBorder">{{ __('lang.role') }}</label>
                                                    <select name="role" class="custom-select form-control-border" id="exampleSelectBorder">
                                                        @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" >{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
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
                @foreach($admins as $admin)
                <tr>
                    <td class="py-1">{{ $loop->index+1 }}</td>
                    <td class="py-1">{{ $admin->name }}</td>
                    <td class="py-1">{{ $admin->phone }}</td>
                    <td class="py-1">{{ $admin->email }}</td>
                    <td class="py-1">
                        <div class="image">
                            @if($admin->image != 'noimage')
                            <img src="{{ asset('storage/images/'.$admin->image) }}" class="img-circle elevation-2" height="30px" alt="User Image">
                            @endif
                        </div>
                    </td>
                    <td class="py-1">
                        @foreach($roles as $role)

                        @if($admin->role == $role->id)
                            <h6>{{ $role->name }}</h6>
                        @endif

                        @endforeach
                    </td>
                    <td class="py-1">


                        @if(Auth::user()->id != $admin->id && Auth::user()->role == 1)
                            <button type="button" class="btn btn-info my-0 py-0 px-1" data-toggle="modal" data-target="#modal{{ $loop->index+1 }}">
                                <i class="fas fa-edit m-0 p-0"></i>
                            </button>
                            <div class="modal fade" id="modal{{ $loop->index+1 }}">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-primary">
                                        <form action="{{ route('admin.update', $admin->id) }}" method="post" enctype="multipart/form-data">

                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ __('lang.admin_update') }}</h4>
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
                                                        <input name="name" type="text" class="form-control" value="{{ $admin->name }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_name') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.phone') }}</label>
                                                        <input name="phone" type="number" class="form-control" value="{{ $admin->phone }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_phone') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.email') }}</label>
                                                        <input name="email" type="email" class="form-control" value="{{ $admin->email }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_email') }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">{{ __('lang.password') }}</label>
                                                        <input name="password" type="text" class="form-control" id="exampleInputPassword1" placeholder="{{ __('lang.type_password') }}" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputFile">{{ __('lang.image') }}</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input name="image" id="imgInp" onchange="preview(frame{{ $loop->index+1 }})" type="file" class="custom-file-input" id="exampleInputFile">
                                                                        <label class="custom-file-label" for="exampleInputFile">{{ __('lang.select') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="mb-2" for="image"><b>{{ __('lang.image') }}</b></label>
                                                            <img id="frame{{ $loop->index+1 }}" class="ml-2" src="{{asset('storage/images/'.$admin->image)}}" width="100px" height="100px" alt="Image"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleSelectBorder">{{ __('lang.role') }}</label>
                                                        <select name="role" class="custom-select form-control-border" id="exampleSelectBorder">
                                                            @foreach($roles as $role)
                                                            <option value="{{ $role->id }}" {{ $admin->role_as == $role->name ? 'selected':'' }}>{{ $role->name }}</option>
                                                            @endforeach

                                                        </select>
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


                            <button type="button" class="btn btn-danger my-0 py-0 px-1" data-toggle="modal" data-target="#modal-danger{{ $admin->id }}">
                                <i class="fas fa-trash m-0 p-0"></i>
                            </button>

                            <div class="modal fade" id="modal-danger{{ $admin->id }}">
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
                                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                <form class="d-inline" action="{{ route('admin.destroy',$admin->id) }}" method="post">
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


                            @elseif(Auth::user()->id == $admin->id)
                                <h6>{{ __('lang.your_profile') }}</h6>
                            @elseif(Auth::user()->role == 3)
                                <h6>{{ __('lang.read_only') }}</h6>
                            @elseif(Auth::user()->role == $admin->role || $admin->role == 1)
                                <h6>{{ __('lang.read_only') }}</h6>
                            @elseif(Auth::user()->role == 2 && $admin->role != 1)
                                <button type="button" class="btn btn-info my-0 py-0 px-1" data-toggle="modal" data-target="#modal{{ $loop->index+1 }}">
                                    <i class="fas fa-edit m-0 p-0"></i>
                                </button>
                                <div class="modal fade" id="modal{{ $loop->index+1 }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-primary">
                                            <form action="{{ route('admin.update', $admin->id) }}" method="post" enctype="multipart/form-data">

                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{ __('lang.admin_update') }}</h4>
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
                                                            <input name="name" type="text" class="form-control" value="{{ $admin->name }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_name') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">{{ __('lang.phone') }}</label>
                                                            <input name="phone" type="text" class="form-control" value="{{ $admin->phone }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_phone') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">{{ __('lang.email') }}</label>
                                                            <input name="email" type="email" class="form-control" value="{{ $admin->email }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_email') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">{{ __('lang.password') }}</label>
                                                            <input name="password" type="text" class="form-control" id="exampleInputPassword1" placeholder="{{ __('lang.type_password') }}" required>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="exampleInputFile">{{ __('lang.image') }}</label>
                                                                    <div class="input-group">
                                                                        <div class="custom-file">
                                                                            <input name="image" id="imgInp" onchange="preview(frame{{ $loop->index+1 }})" type="file" class="custom-file-input" id="exampleInputFile">
                                                                            <label class="custom-file-label" for="exampleInputFile">{{ __('lang.select') }}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="mb-2" for="image"><b>{{ __('lang.image') }}</b></label>
                                                                <img id="frame{{ $loop->index+1 }}" class="ml-2" src="{{asset('storage/images/'.$admin->image)}}" width="100px" height="100px" alt="Image"/>
                                                            </div>
                                                        </div>

                                                            <input type="hidden" name="role" value="{{ $admin->role }}">

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
                            @endif

                    </td>
                </tr>

                @endforeach


                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
