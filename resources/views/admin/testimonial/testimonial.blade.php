@extends('admin/layouts/default')
@section('title')
<title>Testimonial</title>
@stop
@section('inlinecss')

@stop
@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 OPEN -->
        <div class="col-12">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Testimonial</h3>
                        <div class="ml-auto pageheader-btn">

                            @can('Testimonial Create')
								<a href="{{ route('testimonial-create') }}" class="btn btn-success btn-icon text-white mr-2">
									<span>
										<i class="fe fe-plus"></i>
									</span> Add testimonial
								</a>
								<a href="#" class="btn btn-danger btn-icon text-white">
									<span>
										<i class="fe fe-log-in"></i>
									</span> Export
                                </a>
                            @endcan
							</div>
                    </div>
                    <div class="card-body ">

                    <table class="table table-bordered data-table">
                      <thead>
                          <tr>
                              <th>Sort Order</th>
                              <th>Heading</th>
                              <th>Title</th>
                              <th width="100px">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($testimonial as $key=>$val)
                          <tr>
                          <td>{{++$key}}</td>
                            <td>{{$val->heading}}</td>
                            <td>{{$val->title}}</td>
                            <td><a href="{{route('testimonial-edit', $val->id)}}" class="edit btn btn-primary btn-sm">Edit</a></td>
                        </tr>
                          @endforeach
                      </tbody>
                  </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- ROW-1 CLOSED -->
    </div>

</div>
@stop
@section('inlinejs')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stop
