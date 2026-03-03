@extends('layouts.main')

@section('main-content')



    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $students }}</h3>

                    <h4>{{ __('lang.students') }}</h4>
                </div>
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <a href="{{ route('students.index') }}" class="small-box-footer">{{ __('lang.more_info') }}<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $groups }}</h3>

                    <h4>{{ __('lang.groups') }}</h4>
                </div>
                <div class="icon">
                    <i class="fas fa-person-booth"></i>
                </div>
                <a href="{{ route('groups.index') }}" class="small-box-footer">{{ __('lang.more_info') }}<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $teachers }}</h3>

                    <h4>{{ __('lang.teachers') }}</h4>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{Auth::user()->role == 1 || Auth::user()->role == 2 ? route('teachers.index') : '#' }}"
                   class="small-box-footer">{{ __('lang.more_info') }}<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-md-6 col-sm-12">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>
                        @if(Auth::user()->role == 1 || Auth::user()->role == 2)
                            {{ number_format($kassas->sum('balance'), 0, ',', '.')  }} SUM
                        @else
                            {{ number_format($kassas, 0, ',', '.')  }} SUM
                        @endif
                    </h3>

                    <h4>{{ __('lang.cashbox') }}</h4>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{Auth::user()->role == 1 || Auth::user()->role == 2 ? route('kassas.index') : '#' }}"
                   class="small-box-footer">{{ __('lang.more_info') }}<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->


    <div class="row">

        <!-- Main content -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-7">
                        <!-- AREA CHART -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('lang.payment_graphics') }}</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col (LEFT) -->
                    <div class="col-md-5">


                        <!-- Calendar -->
                        <div class="card bg-gradient-success">
                            <div class="card-header border-0">

                                <h3 class="card-title">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ __('lang.calendar') }}
                                </h3>
                                <!-- tools card -->
                                <div class="card-tools">
                                    <!-- button with a dropdown -->
{{--                                    <div class="btn-group">--}}
{{--                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">--}}
{{--                                            <i class="fas fa-bars"></i>--}}
{{--                                        </button>--}}
{{--                                        <div class="dropdown-menu" role="menu">--}}
{{--                                            <a href="#" class="dropdown-item">Add new event</a>--}}
{{--                                            <a href="#" class="dropdown-item">Clear events</a>--}}
{{--                                            <div class="dropdown-divider"></div>--}}
{{--                                            <a href="#" class="dropdown-item">View calendar</a>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <!-- /. tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body pt-0">
                                <!--The calendar -->
                                <div id="calendar" style="width: 100%"></div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- Map card -->
                        <div class="card bg-gradient-primary d-none">
                            <div class="card-header border-0">
                                <h3 class="card-title">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    Visitors
                                </h3>
                                <!-- card tools -->
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                                        <i class="far fa-calendar-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <div class="card-body">
                                <div id="world-map" style="height: 250px; width: 100%;"></div>
                            </div>
                            <!-- /.card-body-->
                            <div class="card-footer bg-transparent">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <div id="sparkline-1"></div>
                                        <div class="text-white">Visitors</div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-4 text-center">
                                        <div id="sparkline-2"></div>
                                        <div class="text-white">Online</div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-4 text-center">
                                        <div id="sparkline-3"></div>
                                        <div class="text-white">Sales</div>
                                    </div>
                                    <!-- ./col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col (RIGHT) -->
                </div>
                <!-- /.row -->


                <div class="my-3">
                    <h2 class="text-center">{{ __('lang.daily_timetable') }}</h2>
                </div>

                <div class="row border px-2">
                    @foreach($rooms as $room)
                        @if($room->count > 0)
                            <div class="d-none">{{ date_default_timezone_set('Asia/Tashkent') }}</div>
                            <div class="col-lg-4 col-md-6 col-sm-12  bg-success rounded my-2">
                                <h3 class="text-center">{{ $room->name }}</h3>

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="py-1">{{ __('lang.group') }}</th>
                                        <th class="py-1">{{ __('lang.teacher') }}</th>
                                        @foreach($weekdays as $week)
                                            @if(date( "w", strtotime(date('Y-m-d'))) == $loop->index )
                                                <th class="py-1">{{ $week }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($timetable_groups as $group)
                                        @if($group->room_id == $room->id)
                                            @foreach(explode(',', $group->days) as $wd)
                                                @if($wd == (date( "w", strtotime(date('Y-m-d'))) == 0 ? 7: date( "w", strtotime(date('Y-m-d')))))
                                                    <tr class="
                                                    {{ date('H:i:s') > $group->starts_at && date('H:i:s') < $group->ends_at ? 'bg-danger':'' }}
                                                    ">
                                                        <th class="py-1">
                                                            {{ $group->name }}
                                                        </th>
                                                        <th class="py-1">
                                                            {{ $group->teacher }}
                                                        </th>
                                                        @for($i = 0; $i < count($weekdays);$i++)
                                                            @if(date( "w", strtotime(date('Y-m-d'))) == $i)
                                                                <td class="py-1">
                                                                    @foreach(explode(',', $group->days) as $day)
                                                                        @if($i == $day || $day == 7)
                                                                            {{ $group->starts_at }} -
                                                                            {{ $group->ends_at }}
                                                                            @break
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            @endif
                                                        @endfor
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        @endif
                    @endforeach
                </div>


            </div><!-- /.container-fluid -->
        <!-- /.content -->

    </div>



    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script>
        $(function () {
            // Get context with jQuery - using jQuery's .get() method.

            var months = [];
            var months2 = [{{ $months }}]
            for (i=0;i<months2.length ; i++){
                months.push(moment().month(months2[i]-1).format("MMMM"));
            }

            var areaChartData = {
                labels  : months,
                datasets: [
                    {
                        label               : '{{ __('lang.paid') }}',
                        backgroundColor     : 'rgba(60,141,188,0.9)',
                        borderColor         : 'rgba(60,141,188,0.8)',
                        pointRadius          : false,
                        pointColor          : '#3b8bba',
                        pointStrokeColor    : 'rgba(60,141,188,1)',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data                : [{{ $paid }}]
                    },
                    {
                        label               : '{{ __('lang.remaining') }}',
                        backgroundColor     : 'rgba(210, 214, 222, 1)',
                        borderColor         : 'rgba(210, 214, 222, 1)',
                        pointRadius         : false,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : [{{ $remaining }}]
                    },
                ]
            }


            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = $.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            var temp1 = areaChartData.datasets[1]
            barChartData.datasets[0] = temp1
            barChartData.datasets[1] = temp0

            var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false
            }

            new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })

        })
    </script>
@endsection
