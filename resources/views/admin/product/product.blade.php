@extends('admin/layouts/default')
@section('title')
<title>product</title>
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
                        <h3 class="card-title">product</h3>
                        <div class="ml-auto pageheader-btn">

                            @can('product Create')
								<a href="{{ route('product-create') }}" class="btn btn-success btn-icon text-white mr-2">
									<span>
										<i class="fe fe-plus"></i>
									</span> Add product
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
                              <th>ID</th>
                              <th>Name</th>
                              <th>Category</th>
                              <th>Sub Category</th>
                              <th>Price</th>
                              <th>Location</th>
                              <th>Status</th>
                              <th width="100px">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($product as $key=>$val)
                          <tr>
                            <td>{{++$key}}</td>
                            <td>{{$val->product_name}}</td>
                            <td>{{$val->category_name}}</td>
                            <td>{{$val->sub_category_name}}</td>
                            <td>Rs. {{$val->price}}</td>
                            <td>{{$val->location}}</td>
                          <td class="text-capitalize"><div class="">{{$val->status}} </div></td>
                            <td width="150px">
                                <a href="{{route('product-edit', $val->id)}}" class="edit btn btn-primary btn-sm">Edit</a>
                                                                <a href="{{route('product-delete', $val->id)}}" class="edit btn btn-danger btn-sm">Delete</a>

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

    <!-- View MODAL -->
<div class="modal fade" id="viewDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Details</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
</div>
<!-- View CLOSED -->

</div>
@stop
@section('inlinejs')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
   <script type="text/javascript"> $('.data-table').DataTable();</script>
@stop
