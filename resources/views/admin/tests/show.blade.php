@extends('layouts.main')

@section('main-content')


    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <ul class="navbar list-unstyled m-0 p-0">
                <li>
                    <a href="{{ route('tests.index') }}">
                        <i class="fas fa-long-arrow-left bg-gradient-info py-2 px-3 rounded"></i>
                    </a>
                    <a href="{{ route('results.export',$test->id) }}">
                        <i class="fas fa-cloud-download bg-primary py-2 px-3 rounded"></i>
                    </a>
                </li>
                <li>
                    <h3 class="card-title">{{ $test->name }}</h3>
                </li>
                <li>

                    <!-- SEARCH FORM -->
                    <form action="{{ route('tests.show',$test->id) }}" method="get" class="form-inline m-0 ml-md-3">
                        @csrf
                        <div class="input-group input-group-sm">
                            <input name="per_page" id="" value="{{$per_page}}" type="number" class="form-control form-control-navbar" list="per_page">
                            <datalist id="per_page">
                                <option value="10">
                                <option value="20">
                                <option value="50">
                                <option value="100">
                            </datalist>
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
                    <th class="py-1">{{ __('lang.student') }}</th>
                    <th class="py-1">{{ __('lang.test') }}</th>
                    <th class="py-1">{{ __('lang.result') }}</th>
                    <th class="py-1">
                        @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                        <button type="button" class="btn btn-success my-0 py-0 px-1" data-toggle="modal" data-target="#admin_add">
                            <i class="fas fa-calendar-plus m-0 p-0"></i>
                        </button>
                        <div class="modal fade" id="admin_add">
                            <div class="modal-dialog">
                                <div class="modal-content bg-success">
                                    <form action="{{ route('results.store') }}" method="post" enctype="multipart/form-data">

                                        <div class="modal-header">
                                            <h4 class="modal-title">{{ __('lang.add') }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            @csrf
                                            <div class="card-body">
                                                <input type="hidden" name="test_id" value="{{ $test->id }}">

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.student') }}</label>
                                                    <select name="student_id" id="" class="form-control select-search">
                                                        <option value="">{{ __('lang.not_selected') }}</option>
                                                        @foreach($students as $student)
                                                            <option value="{{$student->id}}">{{ $student->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.result') }}</label>
                                                    <input name="result" type="number" class="form-control" value="" id="exampleInputEmail1" placeholder="{{ __('lang.type_result') }}">
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
                @foreach($results as $result)
                <tr>
                    <td class="py-1">
                        {{($results->currentpage()-1)*$results->perpage()+($loop->index+1)}}
                    </td>
                    <td class="py-1">{{ $result->student }}</td>
                    <td class="py-1">{{ $result->test }}</td>
                    <td class="py-1">{{ $result->result }}</td>
                    <td class="py-1">


                        @if( Auth::user()->role == 1 || Auth::user()->role == 2)
                            <button type="button" class="btn btn-info my-0 py-0 px-1" data-toggle="modal" data-target="#modal{{ $loop->index+1 }}">
                                <i class="fas fa-edit m-0 p-0"></i>
                            </button>
                            <div class="modal fade" id="modal{{ $loop->index+1 }}">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-primary">
                                        <form action="{{ route('results.update', $result->id) }}" method="post" enctype="multipart/form-data">

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
                                                        <label for="exampleInputEmail1">{{ __('lang.result') }}</label>
                                                        <input name="result" type="number" class="form-control" value="{{ $result->result }}" id="exampleInputEmail1" placeholder="{{ __('lang.type_result') }}">
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


                            <button type="button" class="btn btn-danger my-0 py-0 px-1" data-toggle="modal" data-target="#modal-danger{{ $result->id }}">
                                <i class="fas fa-trash m-0 p-0"></i>
                            </button>

                            <div class="modal fade" id="modal-danger{{ $result->id }}">
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
                                                <form class="d-inline" action="{{ route('results.destroy',$result->id) }}" method="post">
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
            <div>{{ $results->appends($_GET)->links() }}</div>
        </div>
        <!-- /.card-body -->
@endsection
