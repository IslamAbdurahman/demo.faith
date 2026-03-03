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
                    <h3 class="card-title">{{ __('lang.cashbox') }}</h3>
                </li>
            </ul>
        </div>
        <!-- /.card-header -->
        <div class="card-body pt-0 row justify-content-around">

                @foreach($kassas as $kassa)

                <div class="col d-flex justify-content-center">
                    @if( Auth::user()->role == 1  || Auth::user()->role == 2)

                        <button type="button" class="card  pb-4" style="outline: none" data-toggle="modal" data-target="#modal{{ $loop->index+1 }}">
                            <div class="rounded-circle text-center" style="width: 18rem;height: 18rem">
                                @if($kassa->is_cash == 1)
                                    <h3>{{ __('lang.cash_cashbox') }}</h3>
                                    <h3>
                                        {{ number_format($kassa->balance , 0, ',', '.')  }} SUM
                                    </h3>
                                    <img src="{{ asset('assets/image/cash_kassa.png') }}"
                                         style="width: 15rem;height: 15rem" class=" card-img-top" alt="Cash Kassa">
                                @elseif ($kassa->is_click == 1)
                                    <h3>{{ __('lang.click_cashbox') }}</h3>
                                    <h3>
                                        {{ number_format($kassa->balance , 0, ',', '.')  }} SUM
                                    </h3>
                                    <img src="{{ asset('assets/image/click_kassa.png') }}"
                                         style="width: 15rem;height: 15rem" class=" card-img-top" alt="Click Kassa">
                                @else
                                    <h3>{{ __('lang.card_cashbox') }}</h3>
                                    <h3>
                                        {{ number_format($kassa->balance , 0, ',', '.')  }} SUM
                                    </h3>
                                    <img src="{{ asset('assets/image/card_kassa.png') }}"
                                         style="width: 15rem;height: 15rem" class=" card-img-top" alt="Card Kassa">
                                @endif
                                <div class="card-body">
                                    {{--                    <a href="#" class=" stretched-link"></a>--}}
                                </div>
                            </div>
                        </button>

                        @if(Auth::user()->role == 1)

                        <div class="modal fade" id="modal{{$loop->index+1}}">
                            <div class="modal-dialog">
                                <div class="modal-content bg-success">
                                    <form action="{{ route('salaries.store') }}" method="post" enctype="multipart/form-data">

                                        <div class="modal-header">
                                            <h4 class="modal-title">{{ __('lang.cashbox') }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body mt-0 pt-0">

                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    {{--                                                    <label for="exampleInputEmail1" class="d-block">Kassas</label>--}}
                                                    <ul class="d-flex justify-content-around p-0">
                                                    @if($kassa->is_cash == 1)
                                                            <li>
                                                                <input name="kassa_id" value="{{$kassa->id}}" type="radio" checked id="cb{{$kassa->id}}1" />
                                                                <label class="label-check" for="cb{{$kassa->id}}1">
                                                                    <img src="{{ asset('assets/image/cash_kassa.png') }}"
                                                                         style="width: 5rem;height: 5rem" class=" card-img-top" alt="Cash Kassa">
                                                                </label>
                                                                <h3>
                                                                    {{ number_format($kassa->balance , 0, ',', '.')  }} SUM
                                                                </h3>
                                                            </li>

                                                    @elseif ($kassa->is_click == 1)
                                                        <li>
                                                            <input name="kassa_id" value="{{$kassa->id}}" type="radio" checked id="cb{{$kassa->id}}1" />
                                                            <label class="label-check" for="cb{{$kassa->id}}1">
                                                                <img src="{{ asset('assets/image/click_kassa.png') }}"
                                                                     style="width: 5rem;height: 5rem" class=" card-img-top" alt="Cash Kassa">
                                                            </label>
                                                            <h3>
                                                                {{ number_format($kassa->balance , 0, ',', '.')  }} SUM
                                                            </h3>
                                                        @else
                                                            <li>
                                                                <input name="kassa_id" value="{{$kassa->id}}" checked type="radio" id="cb{{$kassa->id}}1" />
                                                                <label class="label-check" for="cb{{$kassa->id}}1">
                                                                    <img src="{{ asset('assets/image/card_kassa.png') }}"
                                                                         style="width: 5rem;height: 5rem" class=" card-img-top" alt="Card Kassa">
                                                                </label>
                                                                <h3>
                                                                    {{ number_format($kassa->balance , 0, ',', '.')  }} SUM
                                                                </h3>
                                                            </li>

                                                        @endif
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
                        @endif
                    @endif
                </div>

                @endforeach



        </div>
        <!-- /.card-body -->
@endsection
