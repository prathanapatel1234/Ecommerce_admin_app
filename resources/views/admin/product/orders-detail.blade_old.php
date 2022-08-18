@extends('admin/layouts/default')
@section('title')
<title>View Orders </title>
@stop
@section('inlinecss')
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link href="{{ asset('admin/assets/multiselectbox/css/ui.multiselect.css') }}" rel="stylesheet">
@stop
@section('breadcrum')
<h1 class="page-title">View Orders </h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Orders </a></li>
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
                       <th>Order Id</th>
                       <td colspan="12">@if(!empty($orders[0]->order_id)) <b style="font-weight: 1000;">{{$orders[0]->order_id}}</b>@else{{'--'}}@endif</td>
                     </tr>

                     <tr>
                        <th>Customer Name</th>
                        <td colspan="12" class="text-capitalize">
                            @if(!empty($orders[0]->userdetails->first_name)){{$orders[0]->userdetails->first_name.' '.$orders[0]->userdetails->last_name}}@else{{'--'}}@endif
                        </td>
                      </tr>

                      <tr>
                        <th>Mobile No.</th>
                        <td colspan="12">@if(!empty($orders[0]->userdetails->mobile_no)){{$orders[0]->userdetails->mobile_no}}@else{{'--'}}@endif</td>
                      </tr>

                      <tr>
                        <th>E-mail</th>
                        <td colspan="12">@if(!empty($orders[0]->userdetails->email)){{$orders[0]->userdetails->email}}@else{{'--'}}@endif</td>
                      </tr>

                      <tr>
                        <th>Payment Type</th>
                        <td colspan="12">
                            @if(!empty($orders[0]->userdetails->pay_type))
                                @php
                                $type='';
                                if($orders[0]->userdetails->pay_type==1) $type='Online Payment';
                                else $type='COD (Cash on Delivery)';
                                @endphp
                                {{$type}}
                            @else{{'--'}}
                            @endif
                        </td>
                      </tr>

                        <tr>
                            <td style="width:7%;"><b>PRODUCTS</b></td>
                            <td style="width:7%;">Name</td>
                            <td style="width:7%;">Quantity</td>
                            <td style="width:7%;">Price</td>
                            <td style="width:7%;">Total Amount</td>

                            @php $sum=0; @endphp
                            @foreach($orders[0]->orderproducts as $key=>$val)
                              <tr>
                                  @if($key==0)
                                  <td rowspan="{{count($orders[0]->orderproducts)+1}}"></td>
                                  @endif
                                  <td class="text-left" style="width:7%;">{{$val->product_name}}</td>
                                  <td class="text-left" style="width:7%;">{{$val->quantity}}</td>
                                  <td class="text-left" style="width:7%;"> {{AdmingetSymbol($orders[0]->currency_type).' '.$val->price}}</td>
                                  <td class="text-left" style="width:7%;">@php $sum+=$val->total_price; @endphp {{AdmingetSymbol($orders[0]->currency_type).' '.$val->total_price}}</td>
                              </tr>
                              @if($key==count($orderDetails[0]->orderproducts))
                                    <td ></td>
                                    <td ></td>
                                    <td class="text-right">Total : </td>
                                    <td>{{AdmingetSymbol($orders[0]->currency_type).' '.$sum}}</td>
                                    @endif
                                @endforeach
                       </tr>


                      <tr>
                        <th>State.</th>
                        <td colspan="12">@if(!empty($orders[0]->userdetails->state)){{$orders[0]->userdetails->state}}@else{{'--'}}@endif</td>
                      </tr>
                      <tr>
                        <th>city</th>
                        <td colspan="12">@if(!empty($orders[0]->userdetails->city)){{$orders[0]->userdetails->city}}@else{{'--'}}@endif</td>
                      </tr>
                      <tr>
                      <tr>
                        <th>address</th>
                        <td colspan="12">@if(!empty($orders[0]->userdetails->address)){{$orders[0]->userdetails->address}}@else{{'--'}}@endif</td>
                      </tr>
                      <tr>
                        <th>zipcode</th>
                        <td colspan="12">@if(!empty($orders[0]->userdetails->zipcode)){{$orders[0]->userdetails->zipcode}}@else{{'--'}}@endif</td>
                      </tr>
                      <tr>
                        <th>Created AT</th>
                        <td colspan="12">@if(!empty($orders[0]->created_at)){{$orders[0]->created_at}}@else{{'--'}}@endif</td>
                      </tr>
                      <tr>
                      <form id="submitForm" action="{{route('update-order-status',$orders[0]->id)}}" method="post" >
                        @csrf
                                <th>Status</th>
                                <td style="width: 12%;">
                                    <select name="status" id="status" class="form-control">
                                        <option value="order recieved" @if(!empty($orders[0]->status) && $orders[0]->status=='order recieved'){{'selected'}}@endif>Order Recieved</option>
                                        <option value="shipped" @if(!empty($orders[0]->status) && $orders[0]->status=='shipped'){{'selected'}}@endif>Shipped</option>
                                        <option value="delivered" @if(!empty($orders[0]->status) && $orders[0]->status=='delivered'){{'selected'}}@endif>Delivered</option>
                                    </select>
                                </td>
                                <td colspan="3" >
                                    <button class="btn btn-primary float-right">
                                        Update
                                    </button>
                                </td>
                            </form>
                      </tr>
                    </tbody>
              </table>
              <div class="container ">

              </div>
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
<script>
     $(function () {

$('#submitForm').submit(function(){
 var $this = $('#submitButton');
 buttonLoading('loading', $this);
 $('.is-invalid').removeClass('is-invalid state-invalid');
 $('.invalid-feedback').remove();
 $.ajax({
     url: $('#submitForm').attr('action'),
     type: "POST",
     processData: false,  // Important!
     contentType: false,
     cache: false,
     data: new FormData($('#submitForm')[0]),
     success: function(data) {
         if(data.status){
             var btn = '<a href="#" class="btn btn-info btn-sm">GoTo List</a>';
             successMsg('Edit Order', data.msg, btn);
             $('#submitForm')[0].reset();

         }else{

             $.each(data.errors, function(fieldName, field){
                 $.each(field, function(index, msg){
                     $('#'+fieldName).addClass('is-invalid state-invalid');
                    errorDiv = $('#'+fieldName).parent('div');
                    errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                 });
             });
             errorMsg('Edit Order', 'Input Error');
         }
         buttonLoading('reset', $this);

     },
     error: function() {
         errorMsg('Edit Story', 'There has been an error, please alert us immediately');
         buttonLoading('reset', $this);
     }

 });

 return false;
});

});
</script>
@stop
