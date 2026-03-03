@extends('layouts.main')

@section('main-content')


    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <ul class="navbar list-unstyled m-0 p-0">
                <li>
                    <h3 class="card-title">{{ __('lang.sms') }}</h3>
                </li>
                <li>

                    <!-- SEARCH FORM -->
                    <form action="{{ route('sms.index') }}" method="get" class="form-inline m-0 ml-md-3">
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
                    <th class="py-1">{{ __('lang.user') }}</th>
                    <th class="py-1">{{ __('lang.text') }}</th>
                    <th class="py-1">{{ __('lang.date') }}</th>
                    <th class="py-1">{{ __('lang.service') }}</th>
                    <th class="py-1">{{ __('lang.status') }}</th>
                    <td class="py-1">{{ __('lang.rights') }}</td>
                </tr>
                </thead>
                <tbody>
                @foreach($sms as $s)
                <tr>
                    <td class="py-1">
                        {{($sms->currentpage()-1)*$sms->perpage()+($loop->index+1)}}
                    </td>
                    <td class="py-1">{{ $s->student->name }}</td>
                    <td class="py-1">{{ $s->user->name }}</td>
                    <td class="py-1">{{ $s->text }}</td>
                    <td class="py-1">{{ $s->date }}</td>
                    <td class="py-1">{{ $s->service ? $s->service->name: '' }}</td>
                    <td class="py-1">{{ $s->status }}</td>
                    <td class="py-1">


                        @if( Auth::user()->role == 1 )

                            <button type="button" class="btn btn-danger my-0 py-0 px-1" data-toggle="modal" data-target="#modal-danger{{ $s->id }}">
                                <i class="fas fa-trash m-0 p-0"></i>
                            </button>

                            <div class="modal fade" id="modal-danger{{ $s->id }}">
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
                                                <form class="d-inline" action="{{ route('sms.destroy',$s->id) }}" method="post">
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
            <div>{{ $sms->appends($_GET)->links() }}</div>
        </div>
        <!-- /.card-body -->
@endsection
