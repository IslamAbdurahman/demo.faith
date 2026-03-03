@extends('layouts.main')

@section('main-content')


    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <ul class="navbar list-unstyled m-0 p-0">
                <li>
                    <a href="{{ route('rooms.index') }}">
                        <i class="fas fa-long-arrow-left bg-gradient-info p-2 px-3 rounded"></i>
                    </a>
                </li>
                <li>
                    <h3 class="card-title">{{ __('lang.room') }} : {{ $room->name }}</h3>
                </li>
                <li>

                    <!-- SEARCH FORM -->
                    <form action="{{ route('rooms.show',$room->id) }}" method="get" class="form-inline m-0 ml-md-3">
                        @csrf
                        <div class="input-group input-group-sm">
                            <select name="per_page" id="" class="form-control form-control-navbar">
                                <option {{ $per_page == 10 ? 'selected':'' }} value="10">10</option>
                                <option {{ $per_page == 20 ? 'selected':'' }}  value="20">20</option>
                                <option {{ $per_page == 50 ? 'selected':'' }}  value="50">50</option>
                                <option {{ $per_page == 100 ? 'selected':'' }}  value="100">100</option>
                            </select>
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
                    <th>{{ __('lang.group') }}</th>
                    <th>{{ __('lang.teacher') }}</th>
                    @foreach($weekdays as $week)
                        <th class="py-1">{{ $week }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        <th class="py-1">
                            {{ $group->name }}
                        </th>
                        <th class="py-1">
                            {{ $group->teacher }}
                        </th>
                        @for($i = 1; $i <= count($weekdays);$i++)
                        <td class="py-1">
                                @foreach(explode(',', $group->days) as $day)
                                    @if($i == $day)

                                    {{ $group->starts_at }} -
                                    {{ $group->ends_at }}
                                    @endif
                                @endforeach
                        </td>
                        @endfor
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>





{{--        <div class="card-body pt-0 table-responsive">--}}
{{--            <table id="example1" class="table table-bordered table-striped ">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th class="py-1">N</th>--}}
{{--                    <th class="py-1">Name</th>--}}
{{--                    <th class="py-1">Teacher</th>--}}
{{--                    <th class="py-1">Days</th>--}}
{{--                    <th class="py-1">Starts</th>--}}
{{--                    <th class="py-1">Ends</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach($groups as $group)--}}
{{--                <tr>--}}
{{--                    <td class="py-1">--}}
{{--                        {{($groups->currentpage()-1)*$groups->perpage()+($loop->index+1)}}--}}
{{--                    </td>--}}
{{--                    <td class="py-1">{{ $group->name }}</td>--}}
{{--                    <td class="py-1">{{ $group->teacher }}</td>--}}
{{--                    <td class="py-1">--}}
{{--                        @foreach(explode(',', $group->days) as $day)--}}
{{--                            {{ $weekdays[$day] }},--}}
{{--                        @endforeach--}}
{{--                    </td>--}}
{{--                    <td class="py-1">{{ $group->starts_at }}</td>--}}
{{--                    <td class="py-1">{{ $group->ends_at }}</td>--}}
{{--                </tr>--}}

{{--                @endforeach--}}


{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}


        <div>{{ $groups->appends($_GET)->links() }}</div>
        <!-- /.card-body -->
@endsection
