@extends('front.layouts.app')
  @section('content')
   @include('alert')
    <div class="hero-wrap hero-bread bg-primary" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-0 bread">Dashboard</h1>
          </div>
        </div>
      </div>
    </div><br />
   
    {{-- <section class="ftco-section"> --}}
      <div class="container-fluid">
          <div id="result" >

          </div>
        <div class="row ">
          <div class="col-xl-2 ftco-animate">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action bg-primary active  ">Dashboard</a>
                <a href="{{route('my.orders')}}" class="list-group-item list-group-item-action ">My Orders</a>
                <a href="{{route('my.profile')}}" class="list-group-item list-group-item-action">My Profile</a>
                <a href="#" class="list-group-item list-group-item-action disabled">Payment History</a>
              </div>
          </div> <!-- .col-md-8 -->
        </div>
      </div>
    {{-- </section> <!-- .section --> --}}
@endsection
