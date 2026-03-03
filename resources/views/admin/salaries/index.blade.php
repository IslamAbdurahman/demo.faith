@extends('layouts.main')

@section('main-content')

    <style>
        ul {
            list-style-type: none;
        }

        input[type="radio"][id^="cb"] {
            display: none;
        }

        .label-check {
            border: 1px solid #fff;
            padding: 10px;
            display: block;
            position: relative;
            margin: 10px;
            width: 100px;
            cursor: pointer;
            border-radius: 12px;
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
            display: block;
            border-radius: 50%;
            border: 1px solid grey;
            position: absolute;
            top: -5px;
            left: -5px;
            width: 25px;
            height: 25px;
            text-align: center;
            line-height: 28px;
            transition-duration: 0.4s;
            transform: scale(0);
        }

        .label-check img {
            height: 100px;
            width: 100px;
            transition-duration: 0.2s;
            transform-origin: 50% 50%;
        }

        :checked+.label-check {
            border-color: #ddd;
        }

        :checked+.label-check::before {
            content: "✓";
            background-color: grey;
            transform: scale(1);
        }

    </style>

    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <ul class="navbar list-unstyled m-0 p-0">
                <li>
                    <h3 class="card-title">{{ __('lang.salaries') }}</h3>
                </li>
                <li class="d-flex">
                    <!-- SEARCH FORM -->
                        @csrf
                        <form action="{{ route('salaries.index') }}" method="get" class="form-inline m-0 ml-md-3">
                            @csrf
                            <div class="input-group input-group-sm">
                                <input name="per_page" id="" value="{{$per_page}}" type="number" class="form-control form-control-navbar" list="per_page">
                                <datalist id="per_page">
                                    <option value="10">
                                    <option value="20">
                                    <option value="50">
                                    <option value="100">
                                </datalist>
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
                    <form action="{{ route('salaries.export') }}" method="get" class="form-inline m-0">
                        @csrf
                            <div class="input-group input-group-sm m-0">
                                <input name="from" value="{{ $from }}" class="form-control form-control-navbar" type="hidden" placeholder="Search" aria-label="Search">
                                <input name="to" value="{{ $to }}" class="form-control form-control-navbar" type="hidden" placeholder="Search" aria-label="Search">
                                <input name="search" value="{{ $search }}" class="form-control form-control-navbar" type="hidden" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-cloud-download bg-primary rounded"></i>
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
                    <th class="py-1">{{ __('lang.personal') }}</th>
                    <th class="py-1">{{ __('lang.worker') }}</th>
                    <th class="py-1">{{ __('lang.amount') }}</th>
                    <th class="py-1">{{ __('lang.user') }}</th>
                    <th class="py-1">{{ __('lang.cashbox') }}</th>
                    <th class="py-1">{{ __('lang.date') }}</th>
                    <th class="py-1">{{ __('lang.comment') }}</th>
                    <th class="py-1">
                        @if(Auth::user()->role == 1  || Auth::user()->role == 2)
                            <button type="button" class="btn btn-success my-0 py-0 px-1" data-toggle="modal" data-target="#admin_add">
                                <i class="fas fa-calendar-plus m-0 p-0"></i>
                            </button>
                            <div class="modal fade" id="admin_add">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-success">
                                        <form action="{{ route('salaries.store') }}" method="post" enctype="multipart/form-data">

                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ __('lang.salaries') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body mt-0 pt-0">

                                                @csrf
                                                <div class="card-body">
                                                    <div class="form-group d-flex justify-content-around">
                                                        {{--                                                    <label for="exampleInputEmail1" class="d-block">Kassas</label>--}}
                                                        <ul class="d-flex justify-content-between p-0">
                                                        @foreach($kassas as $kassa)
                                                            @if($kassa->is_cash == 1)
                                                                <li>
                                                                    <input name="kassa_id" value="{{$kassa->id}}" type="radio" id="cb{{$kassa->id}}1" />
                                                                    <label class="label-check" for="cb{{$kassa->id}}1">
                                                                        <img src="{{ asset('assets/image/cash_kassa.png') }}"
                                                                             style="width: 5rem;height: 5rem" class=" card-img-top" alt="Cash Kassa">
                                                                        <h5>
                                                                            {{ number_format($kassa->balance , 0, ',', '.')  }} SUM
                                                                        </h5>
                                                                    </label>

                                                                </li>
                                                                @elseif($kassa->is_click == 1)
                                                                    <li>
                                                                        <input name="kassa_id" value="{{$kassa->id}}" type="radio" id="cb{{$kassa->id}}1" />
                                                                        <label class="label-check" for="cb{{$kassa->id}}1">
                                                                            <img src="{{ asset('assets/image/click_kassa.png') }}"
                                                                                 style="width: 5rem;height: 5rem" class=" card-img-top" alt="Click Kassa">
                                                                            <h5>
                                                                                {{ number_format($kassa->balance , 0, ',', '.')  }} SUM
                                                                            </h5>
                                                                        </label>

                                                                    </li>

                                                            @else
                                                                <li>
                                                                    <input name="kassa_id" value="{{$kassa->id}}" type="radio" id="cb{{$kassa->id}}1" />
                                                                    <label class="label-check" for="cb{{$kassa->id}}1">
                                                                        <img src="{{ asset('assets/image/card_kassa.png') }}"
                                                                             style="width: 5rem;height: 5rem" class=" card-img-top" alt="Card Kassa">

                                                                        <h5 >
                                                                            {{ number_format($kassa->balance , 0, ',', '.')  }} SUM
                                                                        </h5>
                                                                    </label>
                                                                </li>

                                                            @endif
                                                        @endforeach
                                                        </ul>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.workers') }}</label>
                                                        <select required name="worker_id" id="" class="form-control select-search">
                                                            <option value="" selected disabled>{{ __('lang.not_selected') }}</option>
                                                            @foreach($workers as $worker)
                                                                <option value="{{$worker->id}}">
                                                                    {{ number_format($worker->balance , 0, ',', '.')  }} SUM
                                                                    {{ $worker->name.' '.$worker->role_as }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.amount') }}</label>
                                                        <input required type="number" min="1000" name="amount" class="form-control" placeholder="{{ __('lang.type_amount') }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.comment') }}</label>
                                                        <input required type="text" name="comment" class="form-control" placeholder="{{ __('lang.type_comment') }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('lang.personal') }}</label>
                                                        <input required type="text" name="personal" class="form-control" placeholder="{{ __('lang.personal') }}">
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
                @foreach($salaries as $salary)
                <tr>
                    <td class="py-1">
                        {{($salaries->currentpage()-1)*$salaries->perpage()+($loop->index+1)}}
                    </td>
                    <td class="py-1">{{ $salary->personal }}</td>
                    <td class="py-1">{{ $salary->worker }}</td>
                    <td class="py-1">
                        {{ number_format($salary->amount , 0, ',', '.')  }} SUM
                    </td>
                    <td class="py-1">{{ $salary->user }}</td>
                    <td class="py-1">{{ $salary->kassa }}</td>
                    <td class="py-1">{{ $salary->date }}</td>
                    <td class="py-1">{{ $salary->comment }}</td>
                    <td class="py-1">


                        @if( Auth::user()->role == 1  || Auth::user()->role == 2 )

                            <button type="button" class="btn btn-danger my-0 py-0 px-1" data-toggle="modal" data-target="#modal-danger{{ $salary->id }}">
                                <i class="fas fa-trash m-0 p-0"></i>
                            </button>

                            <div class="modal fade" id="modal-danger{{ $salary->id }}">
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
                                                <form class="d-inline" action="{{ route('salaries.destroy',$salary->id) }}" method="post">
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
                        {{ number_format(array_sum(array_column($salaries->items(), 'amount')) , 0, ',', '.') }} SUM
                    </td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                </tr>


                </tbody>
            </table>
            <div>{{ $salaries->appends($_GET)->links() }}</div>
        </div>
        <!-- /.card-body -->
@endsection
