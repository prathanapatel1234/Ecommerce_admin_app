@extends('admin/layouts/default')
@section('title')
<title>HelpIndia | Blog</title>
@stop
@section('inlinecss')

@stop
@section('breadcrum')
<h1 class="page-title">Blog List</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Blog</a></li>
    <li class="breadcrumb-item active" aria-current="page">List</li>
</ol>
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
                        <h3 class="card-title">Blog</h3>
                        <div class="ml-auto pageheader-btn">
								<a href="{{route('blog-create')}}" class="btn btn-success btn-icon text-white mr-2">
									<span>
										<i class="fe fe-plus"></i>
									</span> Add Blog
                                </a>

								<a href="#" class="btn btn-danger btn-icon text-white">
									<span>
										<i class="fe fe-log-in"></i>
									</span> Export
								</a>
							</div>
                    </div>
                    <div class="card-body ">

                    <table class="table table-bordered data-table">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Title</th>
                              <th>Image</th>
                              <th>Created_at</th>
                              <th width="150px">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($blog as $key=>$val)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$val->title}}</td>
                            <td><img src="{{public_path($val->image)}}" alt="Blog Images"></td>
                            <td>{{$val->created_at}}</td>
                            <td width="150px">
                                <a href="{{route('blog-edit', $val->id)}}" class="edit btn btn-primary btn-sm">Edit</a>
                            </td>
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
@stop
