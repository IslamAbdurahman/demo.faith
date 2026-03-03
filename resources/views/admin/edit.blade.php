@extends('layouts.main')
@section('main-content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header d-flex justify-content-around">
            <h3 class="card-title">{{ __('lang.update') }}</h3>
            <h3 class="card-title">
                {{ number_format(Auth::user()->balance , 0, ',', '.')  }} SUM
            </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('admin.update', Auth::user()->id) }}" method="post" enctype="multipart/form-data">
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
                                    <input name="image" id="imgInp" onchange="preview(frame)" type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">{{ __('lang.select') }}</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ __('lang.image') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="mb-2" for="rasm"><b>{{ __('lang.image') }}</b></label>
                        <img id="frame" class="ml-2" src="{{asset('storage/images/'.$admin->image)}}" width="100px" height="100px" alt="{{ __('lang.image') }}"/>
                    </div>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                    <label class="form-check-label" for="exampleCheck1">{{ __('lang.checking') }}</label>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
@endsection
