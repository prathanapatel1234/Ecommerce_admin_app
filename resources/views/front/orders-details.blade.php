@extends('front.layouts.app')
  @section('content')
  <style>
.table thead th ,td  {
    vertical-align: bottom;
    text-align:left;
    border: 1px solid bisque !important;
    border-top: 1px solid bisque !important;
}
  </style>
    <div class="hero-wrap hero-bread bg-primary" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-0 bread">Order Details</h1>
          </div>
        </div>
      </div>
    </div><br />
    @include('alert')
    {{-- <section class="ftco-section"> --}}
      <div class="container-fluid">
        <div class="row ">
          <div class="col-xl-2 ftco-animate">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action bg-primary active  ">Dashboard</a>
                <a href="{{route('my.orders')}}" class="list-group-item list-group-item-action ">My Orders</a>
                <a href="{{route('my.profile')}}" class="list-group-item list-group-item-action">My Profile</a>
                <a href="#" class="list-group-item list-group-item-action disabled">Payment History</a>
              </div>
          </div> <!-- .col-md-8 -->
          <div class="col-xl-10">
            {{-- <a href="{{ route('pdfview',['download'=>'pdf']) }}">Download PDF</a> --}}
            <table class="table" id="example">
                <thead class="bg-white  text-black">
                    <tr >
                        <th ><b>Order ID</b></th>
                        <td colspan="12">@if(!empty($orderDetails[0]->order_id)){{$orderDetails[0]->order_id}}@else{{'--'}}@endif</td>
                    </tr>

                         <tr>
                            <th>Customer Name</th>
                            <td colspan="12" class="text-capitalize">
                                @if(!empty($orderDetails[0]->userdetails->first_name)){{$orderDetails[0]->userdetails->first_name.' '.$orderDetails[0]->userdetails->last_name}}@else{{'--'}}@endif
                            </td>
                          </tr>

                          <tr>
                            <th>Mobile No.</th>
                            <td colspan="12">@if(!empty($orderDetails[0]->userdetails->mobile_no)){{$orderDetails[0]->userdetails->mobile_no}}@else{{'--'}}@endif</td>
                          </tr>

                          <tr>
                            <th>E-mail</th>
                            <td colspan="12">@if(!empty($orderDetails[0]->userdetails->email)){{$orderDetails[0]->userdetails->email}}@else{{'--'}}@endif</td>
                          </tr>

                          <tr>
                            <th>Payment Type</th>
                            <td colspan="12">
                                @if(!empty($orderDetails[0]->userdetails->pay_type))
                                    @php
                                    $type='';
                                    if($orderDetails[0]->userdetails->pay_type==1) $type='Online Payment';
                                    else $type='COD (Cash on Delivery)';
                                    @endphp
                                    {{$type}}
                                @else{{'--'}}
                                @endif
                            </td>
                          </tr>


                            <tr>
                                <td style="width:7%;"><b>PRODUCTS</b></td>
                                <td class="text-left"  style="width:7%;">Name</td>
                                <td class="text-center" style="width:7%;">Quantity</td>
                                <td  class="text-right" style="width:7%;">Price</td>
                                <td  class="text-right" style="width:7%;">Total Amount</td>

                                @php $sum=0; @endphp
                                @foreach($orderDetails[0]->orderproducts as $key=>$val)
                                  <tr>
                                      @if($key==0)
                                      <td rowspan="{{count($orderDetails[0]->orderproducts)+1}}"></td>
                                      @endif
                                      <td class="text-left" style="width:7%;">{{$val->product_name}}</td>
                                      <td class="text-center" style="width:7%;">{{$val->quantity}}</td>
                                      <td class="text-right" style="width:7%;"> {{getSymbol($orderDetails[0]->currency_type).' '.$val->price}}</td>
                                      <td class="text-right" style="width:7%;">@php $sum+=$val->total_price; @endphp {{getSymbol($orderDetails[0]->currency_type).' '.number_format($val->total_price)}}</td>
                                  </tr>
                                  @if($key==count($orderDetails[0]->orderproducts)-1)
                                  <td ></td>
                                  <td ></td>
                                  <td class="text-right">Total : </td>
                                  <td class="text-right" >{{getSymbol($orderDetails[0]->currency_type).' '.number_format($sum)}}</td>
                                  @endif
                              @endforeach
                             </tr>

                             <tr>
                                <th>State.</th>
                                <td colspan="12">@if(!empty($orderDetails[0]->userdetails->state)){{$orderDetails[0]->userdetails->state}}@else{{'--'}}@endif</td>
                              </tr>
                              <tr>
                                <th>city</th>
                                <td colspan="12">@if(!empty($orderDetails[0]->userdetails->city)){{$orderDetails[0]->userdetails->city}}@else{{'--'}}@endif</td>
                              </tr>
                              <tr>
                              <tr>
                                <th>address</th>
                                <td colspan="12">@if(!empty($orderDetails[0]->userdetails->address)){{$orderDetails[0]->userdetails->address}}@else{{'--'}}@endif</td>
                              </tr>
                              <tr>
                                <th>zipcode</th>
                                <td colspan="12">@if(!empty($orderDetails[0]->userdetails->zipcode)){{$orderDetails[0]->userdetails->zipcode}}@else{{'--'}}@endif</td>
                              </tr>
                              <tr>
                                <th>Created AT</th>
                                <td colspan="12">@if(!empty($orderDetails[0]->created_at)){{$orderDetails[0]->created_at}}@else{{'--'}}@endif</td>
                              </tr>
                              <tr>

                         <tr>
                            <th><b>Payment ID</b></th>
                            <td  colspan="12">@if(!empty($orderDetails[0]->payment_id)){{$orderDetails[0]->payment_id}}@else{{'--'}}@endif</td>
                         </tr>

                         <tr>
                            <th><b>Currency</b></th>
                            <td  colspan="12">@if(!empty($orderDetails[0]->currency_type)){{$orderDetails[0]->currency_type}}@else{{'--'}}@endif</td>
                         </tr>

                         <tr>
                            <th><b>Status</b></th>
                            <td  colspan="12" class="text-capitalize">@if(!empty($orderDetails[0]->status)){{$orderDetails[0]->status}}@else{{'--'}}@endif</td>
                         </tr>

                </thead>
                    <tbody>

                </tbody>
              </table>
          </div>
        </div>
      </div>
    {{-- </section> <!-- .section --> --}}

    @endsection

