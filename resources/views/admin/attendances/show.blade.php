@extends('layouts.main')

@section('main-content')


    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <ul class="navbar list-unstyled m-0 p-0">
                <li>
                    <a href="{{ route('groups.show',$group->id) }}">
                        <i class="fas fa-long-arrow-left bg-gradient-info p-2 px-3 rounded"></i>
                    </a>
                </li>
                <li>
                    <h3 class="card-title">{{ __('lang.attendance') }} {{ $group->name.' '.$student->name }}</h3>
                </li>
                <li>

                    <!-- SEARCH FORM -->
                    <form action="{{ route('attendances.show_two',[$student->id,$group->id]) }}" method="get" class="form-inline m-0 ml-md-3">
                        @csrf
                        <div class="input-group input-group-sm">
                            <select name="per_page" id="" class="form-control form-control-navbar">
                                <option {{ $per_page == 10 ? 'selected':'' }} value="10">10</option>
                                <option {{ $per_page == 20 ? 'selected':'' }}  value="20">20</option>
                                <option {{ $per_page == 50 ? 'selected':'' }}  value="50">50</option>
                                <option {{ $per_page == 100 ? 'selected':'' }}  value="100">100</option>
                            </select>
                            <input name="from" value="{{ $from }}" class="form-control form-control-navbar" type="date" placeholder="Search" aria-label="Search">
                            <input name="to" value="{{ $to }}" class="form-control form-control-navbar" type="date" placeholder="Search" aria-label="Search">
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
                    <th class="py-1">{{ __('lang.date') }}</th>
                    <th class="py-1">{{ __('lang.status') }}</th>
                    <th class="py-1">
                        {{ __('lang.rights') }}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($attendances as $attendance)
                <tr>
                    <td class="py-1">
                        {{($attendances->currentpage()-1)*$attendances->perpage()+($loop->index+1)}}
                    </td>
                    <td class="py-1">{{ $attendance->name }}</td>
                    <td class="py-1">{{ $attendance->date }}</td>
                    <td class="py-1">
                        @if($attendance->status == 1)
                            <span class="badge badge-primary">{{ __('lang.reason_text') }}</span>
                        @else
                            <span class="badge badge-warning">{{ __('lang.absent_text') }}</span>
                        @endif
                    </td>
                    <td class="py-1">


                        @if( Auth::user()->role == 1 || Auth::user()->role == 2)

                            <button type="button" class="btn btn-danger my-0 py-0 px-1" data-toggle="modal" data-target="#modal-danger{{ $attendance->id }}">
                                <i class="fas fa-trash m-0 p-0"></i>
                            </button>

                            <div class="modal fade" id="modal-danger{{ $attendance->id }}">
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
                                                <form class="d-inline" action="{{ route('attendances.destroy',$attendance->id) }}" method="post">
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

                        @elseif(date('Y-m-d') == date('Y-m-d',strtotime($attendance->date)))
                            <button type="button" class="btn btn-danger my-0 py-0 px-1" data-toggle="modal" data-target="#modal-danger{{ $attendance->id }}">
                                <i class="fas fa-trash m-0 p-0"></i>
                            </button>

                            <div class="modal fade" id="modal-danger{{ $attendance->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-danger">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure?</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                            <form class="d-inline" action="{{ route('attendances.destroy',$attendance->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-light">
                                                    Delete
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
            <div>{{ $attendances->appends($_GET)->links() }}</div>
        </div>
        <!-- /.card-body -->
@endsection
