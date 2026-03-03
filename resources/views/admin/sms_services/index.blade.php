@extends('layouts.main')

@section('main-content')


    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <ul class="navbar list-unstyled m-0 p-0">
                <li>
                    <h3 class="card-title">{{ __('lang.sms') }}</h3>
                </li>
            </ul>
        </div>
        <!-- /.card-header -->
        <div class="card-body pt-0 table-responsive">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="py-1">N</th>
                    <th class="py-1">{{ __('lang.name') }}</th>
                    <th class="py-1">{{ __('lang.nickname') }}</th>
                    <th class="py-1">{{ __('lang.key') }}</th>
                    <th class="py-1">{{ __('lang.secret') }}</th>
                    <th class="py-1">{{ __('lang.token') }}</th>
                    <th class="py-1">{{ __('lang.status') }}</th>
                    <td class="py-1">{{ __('lang.rights') }}</td>
                </tr>
                </thead>
                <tbody>
                @foreach($sms_services as $s)
                <tr>
                    <td class="py-1">
                        {{ ($loop->index+1) }}
                    </td>
                    <td class="py-1">{{ $s->name }}</td>
                    <td class="py-1">{{ $s->nickname }}</td>
                    <td class="py-1">{{ $s->key }}</td>
                    <td class="py-1">{{ $s->secret }}</td>
                    <td class="py-1">{{ $s->token }}</td>
                    <td class="py-1">
                        @if($s->status == 1)
                            <i class="fas fa-check-circle btn-sm btn-success rounded-circle"></i>
                        @else
                            <i class="fas fa-minus-circle btn-sm btn-danger"></i>
                        @endif
                    </td>
                    <td class="py-1">


                        @if( Auth::user()->role == 1 )

                            <button type="button" class="btn btn-info  my-0 py-0 px-1" data-toggle="modal" data-target="#modal{{ $loop->index+1 }}">
                                <i class="fas fa-edit m-0 p-0"></i>
                            </button>
                            <div class="modal fade" id="modal{{ $loop->index+1 }}">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-primary">
                                        <form action="{{ route('sms_services.update', $s->id) }}" method="post" enctype="multipart/form-data">

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
                                                        <label for="exampleInputEmail1">{{ __('lang.nickname') }}</label>
                                                        <input name="nickname" type="text" class="form-control" value="{{ $s->nickname }}" placeholder="{{ __('lang.type_nickname') }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.key') }}</label>
                                                        <input name="key" type="text" class="form-control" value="{{ $s->key }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_key') }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.secret') }}</label>
                                                        <input name="secret" type="text" class="form-control" value="{{ $s->secret }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_secret') }}">
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.token') }}</label>
                                                        <input name="token" type="text" class="form-control" value="{{ $s->token }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_token') }}">
                                                    </div>

                                                    <div class="icheck-success d-inline">
                                                        <input name="status" type="checkbox" id="checkboxPrimary{{$s->id}}" checked>
                                                        <label for="checkboxPrimary{{$s->id}}">
                                                            {{ __('lang.status') }}
                                                        </label>
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
@endsection
