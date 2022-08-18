@extends('admin/layouts/default')
@section('title')
<title>View business </title>
@stop
@section('inlinecss')
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link href="{{ asset('admin/assets/multiselectbox/css/ui.multiselect.css') }}" rel="stylesheet">
@stop
@section('breadcrum')
<h1 class="page-title">View business </h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">business </a></li>
    <li class="breadcrumb-item active" aria-current="page">View</li>
</ol>
@stop
@section('content')
<div class="app-content">
    <div class="side-app">
        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

            @include('admin.alert')
<br />
        <div class="card p-3 pt-3" style="overflow: scroll">
            <h4><b>View  Detail</b></h4>
            <table class="table table-bordered data-table">
                <tbody>

                    <tr>
                       <th>Business Name</th>
                       <td>@if(!empty($business->business_name)){{$business->business_name}}@else{{'--'}}@endif</td>
                     </tr>

                      <tr>
                      <td ><b>STORES</b></td>
                        @foreach($business->store_detail as $key=>$val)
                            <tr >
                                @if($key==0)
                            <td rowspan="{{count($business->store_detail)}}"></td>
                                @endif
                                <td class="text-left">{{++$key}} ) {{$val->store_name}}</td>
                            </tr>
                        @endforeach
                      </tr>

                      <tr>
                        <th>no offers.</th>
                        <td>@if(!empty($business->no_offers)){{number_format($business->no_offers)}}@else{{'--'}}@endif</td>
                      </tr>
                      <tr>
                        <th>Stores Count</th>
                        <td>@if(!empty($business->no_stores)){{number_format($business->no_stores)}}@else{{'--'}}@endif</td>
                      </tr>
                      <tr>
                      <tr>
                        <th>Coupons Count</th>
                        <td>@if(!empty($business->no_coupons)){{number_format($business->no_coupons)}}@else{{'--'}}@endif</td>
                      </tr>
                      <tr>
                        <th>Maximum  Validity</th>
                        <td>@if(!empty($business->validity_offer)){{$business->validity_offer}}@else{{'--'}}@endif</td>
                      </tr>
                      <tr>
                        <th>address</th>
                        <td>@if(!empty($business->address)){{$business->address}}@else{{'--'}}@endif</td>
                      </tr>
                      <tr>
                        <th>status</th>
                        <td>@if(!empty($business->created_detail) && $business->status==1){{'Active'}}@else{{'--'}}@endif</td>
                      </tr>
                      <tr>

                      <tr>
                        <th>Created By</th>
                        <td>@if(!empty($business->created_detail->name)){{$business->created_detail->name}}@else{{'--'}}@endif</td>
                      </tr>
                      <tr>
                        <th>Created AT</th>
                        <td>@if(!empty($business->created_at)){{$business->created_at}}@else{{'--'}}@endif</td>
                      </tr>
                    </tbody>
              </table>
                    </div><!-- CARD FOOTER END -->
                </div>
            </div><!-- COL END -->
        </div>
    </div>
 </div><!-- COL END -->
</div>
</div>

@stop
@section('inlinejs')
@stop
