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
            <div class="row">
                <div class="col-lg-4 col-md-12 d-flex justify-content-between">
                    <h3 class="card-title">{{ __('lang.payments') }}</h3>
                    @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                        <div>
                            <form action="{{ route('payment.export') }}" method="get" class="form-inline m-0">
                                @csrf
                                <div class="input-group input-group-sm m-0">
                                    <input name="from" value="{{ $from }}" class="form-control form-control-navbar" type="hidden">
                                    <input name="to" value="{{ $to }}" class="form-control form-control-navbar" type="hidden">
                                    <input name="search" value="{{ $search }}" class="form-control form-control-navbar" type="hidden">

                                    <input name="student_id" value="{{ $student_id }}" class="form-control form-control-navbar" type="hidden">
                                    <input name="group_id" value="{{ $group_id }}" class="form-control form-control-navbar" type="hidden">
                                    <input name="teacher_id" value="{{ $teacher_id }}" class="form-control form-control-navbar" type="hidden">

                                    <div class="input-group p-0">
                                        <button class="btn btn-primary px-1 py-0" type="submit">
                                            <i class="fas fa-cloud-download bg-primary rounded"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
                <div class="col-lg-8 col-md-12">

                    <form action="{{ route('payments.index') }}" method="get" class=" m-0 ml-md-3">
                        @csrf
                        <div class="input-group input-group-sm">
                            <input name="per_page" id="" value="{{$per_page}}" type="number" class="form-control form-control-navbar" list="per_page">
                            <datalist id="per_page">
                                <option value="10">
                                <option value="20">
                                <option value="50">
                                <option value="100">
                            </datalist>

                            <input name="from" value="{{ $from }}" class="form-control form-control-navbar" type="date" aria-label="Search">
                            <input name="to" value="{{ $to }}" class="form-control form-control-navbar" type="date" aria-label="Search">

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
                            <select name="teacher_id" id="" class="form-control select-search form-control-navbar">
                                <option value="" selected >{{ __('lang.teacher') }}</option>
                                @foreach($teachers as $teacher)
                                    <option {{ $teacher->id == $teacher_id ? 'selected':'' }} value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            {{--                                <input name="search" value="{{ $search }}" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">--}}
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
                    <th class="py-1">{{ __('lang.month') }}</th>
                    <th class="py-1">{{ __('lang.amount') }}</th>
                    <th class="py-1">{{ __('lang.discount_education') }}</th>
                    <th class="py-1">{{ __('lang.kitchen') }}</th>
                    <th class="py-1">{{ __('lang.bedroom') }}</th>
                    <th class="py-1">{{ __('lang.education') }}</th>
                    <th class="py-1">{{ __('lang.date') }}</th>
                    <th class="py-1">{{ __('lang.student') }}</th>
                    <th class="py-1">{{ __('lang.teacher') }}</th>
                    <th class="py-1">{{ __('lang.group') }}</th>
                    <th class="py-1">{{ __('lang.cashbox') }}</th>
                    <th class="py-1">
                        @if(Auth::user()->role == 1  || Auth::user()->role == 2)
                        <button type="button" class="btn btn-success my-0 py-0 px-1" data-toggle="modal" data-target="#admin_add">
                            <i class="fas fa-calendar-plus m-0 p-0"></i>
                        </button>
                        <div class="modal fade" id="admin_add">
                            <div class="modal-dialog">
                                <div class="modal-content bg-success">
                                    <form action="{{ route('payments.store') }}" method="post" enctype="multipart/form-data">

                                        <div class="modal-header">
                                            <h4 class="modal-title">{{ __('lang.payments') }}</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group d-flex justify-content-around">
{{--                                                    <label for="exampleInputEmail1" class="d-block">Kassas</label>--}}
                                                    <ul class="d-flex justify-content-between p-0">
                                                    @foreach($kassas as $kassa)
                                                            @if($kassa->is_cash == 1 && $kassa->is_click == 0)
                                                            <li>
                                                                <input name="kassa_id" value="{{$kassa->id}}" type="radio" id="cb{{$kassa->id}}1" />
                                                                <label class="label-check" for="cb{{$kassa->id}}1">
                                                                    <img src="{{ asset('assets/image/cash_kassa.png') }}"
                                                                         style="width: 5rem;height: 5rem" class=" card-img-top" alt="Cash Kassa">
                                                                </label>
                                                            </li>

                                                            @elseif ( $kassa->is_click == 1)
                                                            <li>
                                                                <input name="kassa_id" value="{{$kassa->id}}" type="radio" id="cb{{$kassa->id}}1" />
                                                                <label class="label-check" for="cb{{$kassa->id}}1">
                                                                    <img src="{{ asset('assets/image/click_kassa.png') }}"
                                                                         style="width: 5rem;height: 5rem" class=" card-img-top" alt="Click Kassa">
                                                                </label>
                                                            </li>

                                                        @else
                                                            <li>
                                                                <input name="kassa_id" value="{{$kassa->id}}" type="radio" id="cb{{$kassa->id}}1" />
                                                                <label class="label-check" for="cb{{$kassa->id}}1">
                                                                    <img src="{{ asset('assets/image/card_kassa.png') }}"
                                                                         style="width: 5rem;height: 5rem" class=" card-img-top" alt="Card Kassa">
                                                                </label>
                                                            </li>
                                                            @endif
                                                    @endforeach
                                                    </ul>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.graphics') }}</label>
                                                    <select required name="graphic_id" id="" class="form-control select-search">
                                                        <option value="" selected disabled>{{ __('lang.not_selected') }}</option>
                                                        @foreach($graphics as $graphic)
                                                            <option value="{{$graphic->id}}">
                                                                {{ number_format($graphic->remaining_amount , 0, ',', '.')  }} SUM
                                                                {{ \Illuminate\Support\Carbon::parse(date('Y-m',strtotime($graphic->month)))->translatedFormat('Y F') }}
                                                                {{ $graphic->student }}
                                                                {{ $graphic->group }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.amount') }}</label>
                                                    <input required type="number" name="amount" class="form-control" placeholder="{{ __('lang.type_amount') }}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">{{ __('lang.discount') }}</label>
                                                    <input required type="number" value="0" name="discount" class="form-control" placeholder="{{ __('lang.type_discount') }}">
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
                @foreach($payments as $payment)
                <tr>
                    <td class="py-1">
                        {{($payments->currentpage()-1)*$payments->perpage()+($loop->index+1)}}
                    </td>
                    <td class="py-1">
                        {{ \Illuminate\Support\Carbon::parse(date('Y-m',strtotime($payment->month)))->translatedFormat('Y F') }}
                    </td>
                    <td class="py-1">
                        {{ number_format($payment->amount , 0, ',', '.')  }} SUM
                    </td>
                    <td class="py-1">
                        {{ number_format($payment->discount , 0, ',', '.')  }} SUM
                    </td>
                    <td class="py-1">@if($payment->kitchen == 1) &#9989; @else &#10060; @endif</td>
                    <td class="py-1">@if($payment->bedroom == 1) &#9989; @else &#10060; @endif</td>
                    <td class="py-1">@if($payment->education == 1) &#9989; @else &#10060; @endif</td>
                    <td class="py-1">{{ $payment->date }}</td>
                    <td class="py-1">{{ $payment->student }}</td>
                    <td class="py-1">{{ $payment->teacher }}</td>
                    <td class="py-1">{{ $payment->group }}</td>
                    <td class="py-1">{{ $payment->kassa }}</td>
                    <td class="py-1">


                        <script>
                            function printDiv(id) {
                                var divToPrint = document.getElementById(id);
                                var newWin = window.open('', 'Print-Window');
                                newWin.document.open();
                                newWin.document.write(`
            <html>
            <head>
                <style>
                    /* CSS for print styling */
                    @media print {
                        .print-container {
                            width: 250px; /* Fixed width of the check */
                            height: auto; /* Adjust height dynamically */
                            font-family: Arial, sans-serif;
                            margin: 0 auto; /* Center on the page */
                            overflow: hidden;
                        }
                        /* Disable page breaks to fit content on one page */
                        @page {
                            margin: 0; /* Remove page margins */
                        }
                    }
                </style>
            </head>
            <body onload="window.print()">
                <div class="print-container">${divToPrint.innerHTML}</div>
            </body>
            </html>
        `);
                                newWin.document.close();
                                setTimeout(function () { newWin.close(); }, 10);
                            }
                        </script>

                        @if( Auth::user()->role == 1  || Auth::user()->role == 2)

                            <button type="button" onclick="printDiv('{{ 'print_item'.$payment->id }}')"
                                    class="btn btn-info my-0 py-0 px-1">
                                <i class="fas fa-print m-0 p-0"></i>
                            </button>

                            <div class="d-none" id="print_item{{$payment->id}}">
                                <div style="font-family: Arial, sans-serif; width: 250px">
                                    <p>****************************************</p>
                                    <p style="
                                            text-align: center;
                                            ">
                                        <img
                                            src="{{ asset('storage/images/'.\App\Models\User::where('role','=',1)->first()->image) }}"
                                            style="height: 100px"
                                            alt="">
                                    </p>
                                    <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;line-height: 1px">
                                        <p>{{ __('lang.month') }} :</p>
                                        <p>{{ $payment->month }}</p>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;line-height: 1px">
                                        <p>{{ __('lang.amount') }}:</p>
                                        <p>{{ number_format($payment->amount , 0, ',', '.')  }} SUM</p>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;line-height: 1px">
                                        <p>{{ __('lang.discount') }} :</p>
                                        <p>{{ number_format($payment->discount , 0, ',', '.')  }} SUM</p>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;line-height: 1px">
                                        <p>{{ __('lang.date') }} :</p>
                                        <p>{{ $payment->date }}</p>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;">
                                        <p>{{ __('lang.student') }} :</p>
                                        <p>{{ $payment->student }}</p>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;">
                                        <p>{{ __('lang.teacher') }}:</p>
                                        <p style="text-align: right">{{ $payment->teacher }}</p>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;">
                                        <p>{{ __('lang.group') }}:</p>
                                        <p style="text-align: right">{{ $payment->group }}</p>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;line-height: 1px">
                                        <p>{{ __('lang.cashbox') }} :</p>
                                        <p>{{ $payment->kassa }}</p>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;">
                                        <p>Kassir:</p>
                                        <p style="text-align: right">{{ \App\Models\User::find($payment->user_id)->name }}</p>
                                    </div>
                                    <div style="text-align: center">
                                        <img src="https://quickchart.io/qr?text={{
                                            route("payment_check",$payment->id)
                                            }}">
                                    </div>
                                    <p>****************************************</p>
                                </div>
                            </div>


                            <button type="button" class="btn btn-danger my-0 py-0 px-1" data-toggle="modal" data-target="#modal-danger{{ $payment->id }}">
                                <i class="fas fa-trash m-0 p-0"></i>
                            </button>

                            <div class="modal fade" id="modal-danger{{ $payment->id }}">
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
                                                <form class="d-inline" action="{{ route('payments.destroy',$payment->id) }}" method="post">
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
                    <td class="py-1 bg-success text-bold">
                        {{ number_format(array_sum(array_column($payments->items(), 'amount')) , 0, ',', '.') }} SUM
                    </td>
                    <td class="py-1 bg-info text-bold">
                        {{ number_format(array_sum(array_column($payments->items(), 'discount')) , 0, ',', '.') }} SUM
                    </td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                    <td class="py-1"></td>
                </tr>

                </tbody>
            </table>
            <div>{{ $payments->appends($_GET)->links() }}</div>
        </div>
        <!-- /.card-body -->
@endsection
