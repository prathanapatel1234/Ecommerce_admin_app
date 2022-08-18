@extends('admin/layouts/default')
@section('title')
<title>Aamod-Dashboard</title>
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
                        <h3 class="card-title">Users Enquiry</h3>
                    </div>
                    <div class="card-body ">

                    <table class="table table-bordered data-table">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Mobile</th>
                              <th>Created AT</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($contact_us as $key=>$val)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$val->name}}</td>
                            <td>{{$val->email}}</td>
                            <td>{{$val->mobno}}</td>
                            <td>{{$val->created_at}}</td>
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
@stop
