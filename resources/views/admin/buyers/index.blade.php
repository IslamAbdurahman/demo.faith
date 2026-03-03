@extends('layouts.main')

@section('main-content')
    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <ul class="navbar list-unstyled m-0 p-0">
                <li>
                    <h3 class="card-title">Haridorlar</h3>
                </li>
                <li>
                    <!-- SEARCH FORM -->
                    <form action="{{ route('buyer.index') }}" method="get" class="form-inline m-0 ml-md-3">
                        @csrf
                        <div class="input-group input-group-sm">
                                <input name="search" value="{{ $search }}" class="form-control form-control-navbar" type="search" placeholder="Qidirish" aria-label="Search">
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
                    <th>N</th>
                    <th>Ism</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Rasm</th>
                    <th>Role</th>
                    <th>
                        @if(Auth::user()->role == 1)
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#admin_add">
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
                                            <h4 class="modal-title">Add Admin</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Name</label>
                                                    <input name="name" type="text" class="form-control" value="" id="exampleInputEmail1" placeholder="Ism kiriting">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email address</label>
                                                    <input name="email" type="email" class="form-control" value="" id="exampleInputEmail1" placeholder="Email kiriting">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <input name="password" type="text" class="form-control" id="exampleInputPassword1" placeholder="Yangi parol" required>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputFile">File image</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input name="image" id="imgInp" onchange="preview(admin_image)" type="file" class="custom-file-input" id="exampleInputFile">
                                                                    <label class="custom-file-label" for="exampleInputFile">Tanlang</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="mb-2" for="image"><b>Rasm</b></label>
                                                        <img id="admin_image" class="ml-2" src="" width="100px" height="100px" alt="Image"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleSelectBorder">Huquq</label>
                                                    <select name="role" class="custom-select form-control-border" id="exampleSelectBorder">
                                                        @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" >{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                                    <label class="form-check-label" for="exampleCheck1">Tekshirish</label>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-outline-light">Saqlash</button>
                                        </div>

                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        @else
                            Action
                        @endif

                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($buyers as $buyer)
                <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $buyer->name }}</td>
                    <td>{{ $buyer->phone }}</td>
                    <td>{{ $buyer->email }}</td>
                    <td>
                        <div class="image">
                            @if($buyer->image != 'noimage')
                            <img src="{{ asset('public/storage/images/'.$buyer->image) }}" class="img-circle elevation-2" height="30px" alt="User Image">
                            @endif
                        </div>
                    </td>
                    <td>
                        @foreach($roles as $role)

                        @if($buyer->role == $role->id)
                            <h6>{{ $role->name }}</h6>
                        @endif

                        @endforeach
                    </td>
                    <td>


                        @if(Auth::user()->id != $buyer->id && Auth::user()->role == 1)
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal{{ $loop->index+1 }}">
                                <i class="fas fa-edit m-0 p-0"></i>
                            </button>
                            <div class="modal fade" id="modal{{ $loop->index+1 }}">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-primary">
                                        <form action="{{ route('admin.update', $buyer->id) }}" method="post" enctype="multipart/form-data">

                                            <div class="modal-header">
                                                <h4 class="modal-title">Admin Update</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                @csrf
                                                @method('PUT')
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Ism</label>
                                                        <input name="name" type="text" class="form-control" value="{{ $buyer->name }}" id="exampleInputEmail1" placeholder="Ism kiriting">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Email address</label>
                                                        <input name="email" type="email" class="form-control" value="{{ $buyer->email }}" id="exampleInputEmail1" placeholder="Email kiriting">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Password</label>
                                                        <input name="password" type="text" class="form-control" id="exampleInputPassword1" placeholder="yangi parol" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="exampleInputFile">File image</label>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input name="image" id="imgInp" onchange="preview(frame{{ $loop->index+1 }})" type="file" class="custom-file-input" id="exampleInputFile">
                                                                        <label class="custom-file-label" for="exampleInputFile">Tanlang</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="mb-2" for="image"><b>Rasm</b></label>
                                                            <img id="frame{{ $loop->index+1 }}" class="ml-2" src="{{asset('public/storage/images/'.$buyer->image)}}" width="100px" height="100px" alt="Image"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleSelectBorder">Huquq</label>
                                                        <select name="role" class="custom-select form-control-border" id="exampleSelectBorder">
                                                            @foreach($roles as $role)
                                                            <option value="{{ $role->id }}" {{ $buyer->role_as == $role->name ? 'selected':'' }}>{{ $role->name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                                        <label class="form-check-label" for="exampleCheck1">Tekshirish</label>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-outline-light">Saqlash</button>
                                            </div>

                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->


                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger{{ $buyer->id }}">
                                <i class="fas fa-trash m-0 p-0"></i>
                            </button>

                            <div class="modal fade" id="modal-danger{{ $buyer->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-danger">
                                        <div class="modal-header">
                                            <h4 class="modal-title">O'chirish</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>O'chirishni xohlaysizmi?</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                <form class="d-inline" action="{{ route('admin.destroy',$buyer->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-light">
                                                        O'chirish
                                                    </button>
                                                </form>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->


                            @elseif(Auth::user()->id == $buyer->id)
                                <h6>Profilingiz</h6>
                            @elseif(Auth::user()->role == 3)
                                <h6>Faqat o'qish</h6>
                            @elseif(Auth::user()->role == $buyer->role || $buyer->role == 1)
                                <h6>Faqat o'qish</h6>
                            @elseif(Auth::user()->role == 2 && $buyer->role != 1)
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal{{ $loop->index+1 }}">
                                    <i class="fas fa-edit m-0 p-0"></i>
                                </button>
                                <div class="modal fade" id="modal{{ $loop->index+1 }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-primary">
                                            <form action="{{ route('admin.update', $buyer->id) }}" method="post" enctype="multipart/form-data">

                                                <div class="modal-header">
                                                    <h4 class="modal-title">Tahrirlash</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    @csrf
                                                    @method('PUT')
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Name</label>
                                                            <input name="name" type="text" class="form-control" value="{{ $buyer->name }}" id="exampleInputEmail1" placeholder="Ism kiriting">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Email address</label>
                                                            <input name="email" type="email" class="form-control" value="{{ $buyer->email }}" id="exampleInputEmail1" placeholder="Email kiriting">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Password</label>
                                                            <input name="password" type="text" class="form-control" id="exampleInputPassword1" placeholder="Yangi parol" required>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label for="exampleInputFile">Rasm</label>
                                                                    <div class="input-group">
                                                                        <div class="custom-file">
                                                                            <input name="image" id="imgInp" onchange="preview(frame{{ $loop->index+1 }})" type="file" class="custom-file-input" id="exampleInputFile">
                                                                            <label class="custom-file-label" for="exampleInputFile">Tanlang</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="mb-2" for="image"><b>Rasm</b></label>
                                                                <img id="frame{{ $loop->index+1 }}" class="ml-2" src="{{asset('public/storage/images/'.$buyer->image)}}" width="100px" height="100px" alt="Image"/>
                                                            </div>
                                                        </div>

                                                            <input type="hidden" name="role" value="{{ $buyer->role }}">

                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                                                            <label class="form-check-label" for="exampleCheck1">Tekshirish</label>
                                                        </div>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-outline-light">Saqlash</button>
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
                <tfoot>
                <tr>
                    <th>N</th>
                    <th>Ism</th>
                    <th>Email</th>
                    <th>Rasm</th>
                    <th>Role</th>
                    <th>Huquq</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection
