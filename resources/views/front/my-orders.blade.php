@extends('front.layouts.app')
  @section('content')
    <div class="hero-wrap hero-bread bg-primary" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-0 bread">My Orders</h1>
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
            <table class="table">
                <thead class="bg-primary text-white">
                  <tr>
                        <th  class="p-2">OrderID</th>
                        <th  class="p-2">Total Amount</th>
                        <th  class="p-2">Order Date</th>
                        <th  class="p-2">Status</th>
                        <th  class="p-2">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($order as $key=>$val)
                    <tr>
                        <td class="p-2" >{{$val->order_id}}</td>
                        <td class="p-2">@if(!empty($val->total_amount)){{getSymbol().' '.$val->total_amount}}@else{{'--'}}@endif</td>
                        <td class="p-2">@if(!empty($val->created_at)){{$val->created_at}}@else{{'--'}}@endif</td>
                        <td class="p-2 text-capitalize">@if(!empty($val->status)){{$val->status}}@else{{'--'}}@endif</td>
                        <td class="p-2 text-capitalize"><a href="{{route('order.details',['orderid'=>$val->order_id])}}">View Details</a></td>
                   </tr>
                    @endforeach
                </tbody>
              </table>
          </div>
        </div>
      </div>
    {{-- </section> <!-- .section --> --}}
@endsection
