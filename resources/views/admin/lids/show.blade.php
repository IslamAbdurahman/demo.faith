@extends('layouts.main')

@section('main-content')


    <div class="card">
        <div class="card-header">
            <ul class="navbar list-unstyled m-0 p-0">
                <li>
                    <a href="{{ route('lids.index') }}">
                        <i class="fas fa-long-arrow-left bg-gradient-info p-2 px-3 rounded"></i>
                    </a>
                </li>
                <li>
                    <h3 class="card-title">{{ $lid->name }} Students</h3>
                </li>
                <li>

                    <!-- SEARCH FORM -->
                    <form action="{{ route('students.index') }}" method="get" class="form-inline m-0 ml-md-3">
                        @csrf
                        <div class="input-group input-group-sm">
                            <select name="per_page" id="" class="form-control form-control-navbar">
                                <option {{ $per_page == 10 ? 'selected':'' }} value="10">10</option>
                                <option {{ $per_page == 20 ? 'selected':'' }}  value="20">20</option>
                                <option {{ $per_page == 50 ? 'selected':'' }}  value="50">50</option>
                                <option {{ $per_page == 100 ? 'selected':'' }}  value="100">100</option>
                            </select>
                            <input name="search" value="{{ $search }}" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
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
                    <th class="py-1">Name</th>
                    <th class="py-1">Phone</th>
                    <th class="py-1">Parent phone</th>
                    <th class="py-1">Discount</th>
                    <th class="py-1">Groups</th>
                    <th class="py-1">Comment</th>
                    <th class="py-1">
                            Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($students as $student)
                <tr>
                    <td class="py-1">
                        {{($students->currentpage()-1)*$students->perpage()+($loop->index+1)}}
                    </td>
                    <td class="py-1">{{ $student->name }}</td>
                    <td class="py-1">{{ $student->phone }}</td>
                    <td class="py-1">{{ $student->parent_phone }}</td>
                    <td class="py-1">{{ $student->discount_education }}</td>
                    <td class="py-1">{{ $student->count }}</td>
                    <td class="py-1">{{ $student->comment }}</td>
                    <td class="py-1">


                        @if(\Illuminate\Support\Facades\Auth::user()->role == 1 ||
                            \Illuminate\Support\Facades\Auth::user()->role == 2)

                            <button type="button" class="btn btn-danger my-0 py-0 px-1" data-toggle="modal" data-target="#modal-danger{{ $student->id }}">
                                <i class="fas fa-trash m-0 p-0"></i>
                            </button>

                            <div class="modal fade" id="modal-danger{{ $student->id }}">
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
                                                <form class="d-inline" action="{{ route('lid_students.destroy',$student->ls_id) }}" method="post">
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
            <div>{{ $students->appends($_GET)->links() }}</div>
        </div>
        <!-- /.card-body -->
@endsection
