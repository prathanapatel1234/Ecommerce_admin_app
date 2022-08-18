@extends('admin/layouts/default')
@section('title')
<title>Admin</title>
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
                        <h3 class="card-title">Promocode</h3>
                        <div class="ml-auto pageheader-btn">
                            @can('Banner Create')
							<div class="form-group pull-left" style="margin-right: 10px;"></div>
								<a href="{{ route('offer-create') }}" class="btn btn-success btn-icon text-white mr-2 create-link">
									<span>
										<i class="fe fe-plus"></i>
									</span> Add promocode
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

                    <table class="table table-bordered data-table w-100">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Promocode Name</th>
                              <th>Promocode Desc</th>
                              <th>Promocode Type</th>
                              <th>Off / %</th>
                              <th width="100px" class="text-center">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($offer as $key=>$val)
                        @php
                        $ctype='';
                        $amtper='';
                            if($val->coupon_type==1)
                            {
                             $ctype='Flat off';
                             $amtper=$val->discount_amountoff.' Rs.';
                            }
                            else{
                                $ctype='% off';
                                $amtper=$val->discount_percentage.' %';
                            }
                        @endphp
                        <tr>
                            <td>{{++$key}}</td>
                            <td>@if(!empty($val->offer_name)){{$val->offer_name}}@endif</td>
                            <td>@if(!empty($val->offer_desc)){{$val->offer_desc}}@else{{'--'}}@endif</td>
                            <td>{{$ctype}}</td>
                            <td>{{$amtper}}</td>
                            <td  class="text-center" >
                            <a href="{{route('offer-edit',$val->id)}}" class="btn btn-primary">Edit</a>
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
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $.fn.dataTable.ext.errMode = 'none';
            var table = $('.data-table').DataTable();
        });
    </script>
@stop
