@extends('layouts.main')

@section('main-content')


    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-6 col-md-12 d-flex justify-content-between">
                    @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                        <ul class="navbar list-unstyled m-0 p-0">
                            <li>
                                <button type="button" class="btn btn-success my-0 py-0 px-2" data-toggle="modal" data-target="#group_sms">
                                    <i class="fas fa-sms m-0 p-0"></i>
                                </button>
                                <div class="modal fade" id="group_sms">
                                    <div class="modal-dialog">
                                        <div class="modal-content bg-primary">
                                            <form action="{{ route('graphic_full.sms') }}" method="get" enctype="multipart/form-data">

                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{ __('lang.group_graphic_title') }}
                                                        <b>
                                                            {{\App\Models\Group::find($group_id) ?\App\Models\Group::find($group_id)->name:''}}
                                                        </b></h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    @csrf
                                                    @method('get')
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <b>{{ __('lang.group_graphic_text') }}</b>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="group_id" value="{{$group_id}}">
                                                    <input type="hidden" name="month" value="{{$month}}">
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
                            </li>
                            <li>
                                <form action="{{ route('graphics.export') }}" method="get" class="form-inline mx-1">
                                    @csrf
                                    <div class="input-group input-group-sm m-0">
                                        <input name="finish" value="{{ $finish }}" class="form-control form-control-navbar" type="hidden" placeholder="Search" aria-label="Search">
                                        <input name="month" value="{{ $month }}" class="form-control form-control-navbar" type="hidden" placeholder="Search" aria-label="Search">
                                        <input name="student_id" value="{{ $student_id }}" class="form-control form-control-navbar" type="hidden" placeholder="Search" aria-label="Search">
                                        <input name="group_id" value="{{ $group_id }}" class="form-control form-control-navbar" type="hidden" placeholder="Search" aria-label="Search">

                                        <div class="input-group p-0">
                                            <button class="btn btn-primary my-0 py-0 px-1" type="submit">
                                                <i class="fas fa-cloud-download bg-primary rounded"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    @endif
                        <h3 class="card-title">{{ __('lang.graphics') }}</h3>

                </div>
                <div class="col-lg-6 col-md-12">
                    <form action="{{ route('graphics.index') }}" method="get" class=" m-0 ml-md-6">
                        @csrf
                        <div class="input-group input-group-sm">
                            <select name="finish" id="" class="form-control form-control-navbar">
                                <option value="">{{ __('lang.unfinished') }}</option>
                                <option {{ $finish == 1? 'selected':'' }} value="1">{{ __('lang.finished') }}</option>
                            </select>

                            <input name="per_page" id="" value="{{$per_page}}" type="number" class="form-control form-control-navbar" list="per_page">
                            <datalist id="per_page">
                                <option value="10">
                                <option value="20">
                                <option value="50">
                                <option value="100">
                            </datalist>

                            <input name="month" value="{{ $month }}" type="month" class="form-control form-control-navbar">

                            <select name="student_id" id="" class="form-control select-search form-control-navbar">
                                <option value="" selected >{{ __('lang.student') }}</option>
                                @foreach($students as $student)
                                    <option {{ $student->id == $student_id ? 'selected':'' }} value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                            <select name="group_id" id="" class="form-control select-search form-control-navbar">
                                <option value="" selected >{{ __('lang.group') }}</option>
                                @foreach($groups as $group)
                                    <option {{ $group->id == $group_id ? 'selected':'' }} value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body pt-0 table-responsive">
            <table id="example1" class="table table-bordered table-striped ">
                <thead>
                <tr>
                    <th class="py-1">N</th>
                    <th class="py-1">{{ __('lang.graph') }}</th>
                    <th class="py-1">{{ __('lang.month') }}</th>
                    <th class="py-1">{{ __('lang.amount') }}</th>
                    <th class="py-1">{{ __('lang.paid') }}</th>
                    <th class="py-1">{{ __('lang.unpaid') }}</th>
                    <th class="py-1">{{ __('lang.education') }}</th>
                    <th class="py-1">{{ __('lang.kitchen') }}</th>
                    <th class="py-1">{{ __('lang.bedroom') }}</th>
                    <th class="py-1">{{ __('lang.student') }}</th>
                    <th class="py-1">{{ __('lang.group') }}</th>
                    <th class="py-1">
                        {{ __('lang.rights') }}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($graphics as $graphic)
                <tr>
                    <td class="py-1">
                        {{($graphics->currentpage()-1)*$graphics->perpage()+($loop->index+1)}}
                    </td>
                    <td>{{ $graphic->id }}</td>
                    <td class="py-1">
                        {{ \Illuminate\Support\Carbon::parse(date('Y-m',strtotime($graphic->month)))->translatedFormat('Y F') }}
                    </td>
                    <td class="py-1">
                        {{ number_format($graphic->amount , 0, ',', '.')  }} SUM
                    </td>
                    <td class="py-1">
                        {{ number_format($graphic->paid_amount , 0, ',', '.')  }} SUM
                    </td>
                    <td class="py-1">
                        {{ number_format($graphic->remaining_amount , 0, ',', '.')  }} SUM
                    </td>
                    <td class="py-1">@if($graphic->education == 1) &#9989; @else &#10060; @endif</td>
                    <td class="py-1">@if($graphic->kitchen == 1) &#9989; @else &#10060; @endif</td>
                    <td class="py-1">@if($graphic->bedroom == 1) &#9989; @else &#10060; @endif</td>
                    <td class="py-1">{{ $graphic->student  }} @if($graphic->phone) {{ "| $graphic->phone" }} @endif</td>
                    <td class="py-1">{{ $graphic->group }}</td>
                    <td class="py-1">


                        @if( Auth::user()->role == 1  || Auth::user()->role == 2)

                            <button type="button" class="btn btn-info my-0 py-0 px-1" data-toggle="modal" data-target="#sms{{ $loop->index+1 }}">
                                <i class="fas fa-sms m-0 p-0"></i>
                            </button>
                            <div class="modal fade" id="sms{{ $loop->index+1 }}">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-primary">
                                        <form action="{{ route('graphic.sms', $graphic->id) }}" method="post" enctype="multipart/form-data">

                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ __('lang.send_sms') }}</h4>
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
                                                        <textarea name="sms" class="form-control">{{ \Illuminate\Support\Facades\Auth::user()->name." : "
                                                            ."O'quvchi ".$graphic->student." -> "
                                                            .date("Y", strtotime($graphic->month))." ".date("F", strtotime($graphic->month))
                                                            ." oyi "
                                                            ." ".$graphic->group." guruh uchun "
                                                             .number_format($graphic->remaining_amount , 0, ",",)
                                                             .". SUM to`lanmagan. Iltimos to`lovni amalga oshiring. Tel : "
                                                             .\Illuminate\Support\Facades\Auth::user()->phone}}
                                                        </textarea>
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
                                                <button type="submit" class="btn btn-light">{{ __('lang.send') }}</button>
                                            </div>

                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->


                           <button type="button" class="btn btn-danger my-0 py-0 px-1" data-toggle="modal" data-target="#modal-danger{{ $graphic->id }}">
                                <i class="fas fa-trash m-0 p-0"></i>
                            </button>

                            <div class="modal fade" id="modal-danger{{ $graphic->id }}">
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
                                                <form class="d-inline" action="{{ route('graphics.destroy',$graphic->id) }}" method="post">
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

                <tr>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1 bg-success text-bold">
                        {{ number_format(array_sum(array_column($graphics->items(), 'amount')) , 0, ',', '.') }} SUM
                    </td>
                    <td class="py-1 bg-success text-bold">
                        {{ number_format(array_sum(array_column($graphics->items(), 'paid_amount')) , 0, ',', '.') }} SUM
                    </td>
                    <td class="py-1 bg-danger text-bold">
                        {{ number_format(array_sum(array_column($graphics->items(), 'remaining_amount')) , 0, ',', '.') }} SUM
                    </td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                </tr>


                </tbody>
            </table>
            <div>{{ $graphics->appends($_GET)->links() }}</div>
        </div>
        <!-- /.card-body -->
@endsection
