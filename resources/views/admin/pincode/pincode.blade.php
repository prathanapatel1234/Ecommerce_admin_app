@extends('admin/layouts/default')
@section('title')
<title>Pincode</title>
@stop
@section('inlinecss')
@stop
@section('breadcrum')
<h1 class="page-title">Pincode List</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Pincode</a></li>
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
                        <h3 class="card-title">Pincode</h3>
                        <div class="ml-auto pageheader-btn">
								<a href="{{route('pincode-create')}}" class="btn btn-success btn-icon text-white mr-2">
									<span>
										<i class="fe fe-plus"></i>
									</span> Add Pincode
                                </a>
							</div>
                    </div>
                    <div class="card-body ">

                    <table class="table table-bordered data-table">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Pincode</th>
                              <th>Created_at</th>
                              <!-- <th>Email</th> -->
                              <th width="150px">Action</th>
                          </tr>
                      </thead>
                      <tbody>
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

    <script type="text/javascript">
        $(function () {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('pincode-list') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'pincode', name: 'pincode'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

			$(document).on('click','.deleteButton', function(){
				row = $(this).closest('tr');
                url = $(this).attr('data-url');
				var $this = $(this);
				buttonLoading('loading', $this);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data){
						row.remove();
                    }
                });
            });

        });
    </script>
@stop
