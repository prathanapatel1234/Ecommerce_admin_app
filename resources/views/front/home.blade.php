
@extends('front.layouts.app')
@section('content')
<section id="home-section" class="hero">
        <div class="home-slider owl-carousel">
          @foreach ($banner as $key=>$val)
          <div class="slider-item" style="background-image: url({{$val->banner}});">
              <div class="overlay"></div>
            <div class="container">
              <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
                <div class="col-md-12 ftco-animate text-center">
                  <h1 class="mb-2"></h1>
                  <h2 class="subheading mb-4"></h2>
                  {{-- <p><a href="#" class="btn btn-primary">View Details</a></p> --}}
                </div>
              </div>
            </div>
          </div>
          @endforeach
      </div>
  </section>

  <section class="ftco-section">
          <div class="container">
              <div class="row no-gutters ftco-services">
        <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
          <div class="media block-6 services mb-md-0 mb-4">
            <div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
                  <span class="flaticon-shipped"></span>
            </div>
            <div class="media-body">
              <h3 class="heading">WHOLESALE QUANTITY</h3>
              <span>MINIMUM ORDER QUANTITY</span>
            </div>
          </div>
        </div>
        <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
          <div class="media block-6 services mb-md-0 mb-4">
            <div class="icon bg-color-2 d-flex justify-content-center align-items-center mb-2">
                  <span class="flaticon-diet"></span>
            </div>
            <div class="media-body">
              <h3 class="heading">DOORSTEP PRICES</h3>
              <span>ALL PRICES EX DELIVERY</span>
            </div>
          </div>
        </div>
        <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
          <div class="media block-6 services mb-md-0 mb-4">
            <div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
                  <span class="flaticon-award"></span>
            </div>
            <div class="media-body">
              <h3 class="heading">TQ QUALITY CERTIFIED</h3>
              <span>100% CERTIFIED PRODUCTS</span>
            </div>
          </div>
        </div>
        <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
          <div class="media block-6 services mb-md-0 mb-4">
            <div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
                  <span class="flaticon-customer-service"></span>
            </div>
            <div class="media-body">
              <h3 class="heading">FINANCE OPTIONS</h3>
              <span>ATTRACTIVE PAYMENT MODES</span>
            </div>
          </div>
        </div>
      </div>
          </div>
      </section>

      <section class="ftco-section ftco-category ftco-no-pt">
          <div class="container">
      <span class="subheading">Categories</span>
             
              <div class="row">
                  <div class="col-md-12">
                      <div class="row">
                          @foreach ($category as $key=>$val)
                          
                              <div class="col-md-4">
                                  <a href="{{route('category-page',$val->title)}}">
                                  <div class="category-wrap ftco-animate img mb-4 d-flex align-items-end" style="background-image: url({{url('/public/'.$val->image)}});">
                                      <div class="text px-3 py-1">
                                      <h2 class="mb-0">{{$val->title}}</h2>
                                      </div>
                                  </div>
                                   </a>
                              </div>
                        
                          @endforeach
                      </div>
                  </div>
              </div>
          </div>
      </section>

  <section class="ftco-section">
      <div class="container">
              <div class="row justify-content-center mb-3 pb-3">
        <div class="col-md-12 heading-section text-center ftco-animate">
            <span class="subheading">Featured Products</span>
                   <p>Premium quality, 100% certified, best brands specially for you</p>
        </div>
      </div>
      </div>
      <div class="container">
          <div class="row">

              @foreach ($ourproduct as $key=>$val)
              <div class="col-md-6 col-lg-3 ftco-animate">
                  <div class="product">
                      @php
                          if(!empty($val->sub_category_name))  $route=route('single-product',['category'=>$val->category_name, 'subcategory'=>$val->sub_category_name,'slug'=>$val->slug]);
                          else                                 $route=route('single-category-product',['category'=>$val->category_name,'slug'=>$val->slug]);
                      @endphp
                  <a href="{{$route}}" class="img-prod">
                      <img class="img-fluid" src="{{url('/public/'.$val->image)}}" alt="{{$val->slug}}" style="height: 200px;width: 200px;">
                         
                          <div class="overlay"></div>
                      </a>
                      <div class="text py-3 pb-4 px-3 text-center">
                         <h3><a href="{{$route}}">{{$val->product_name}}</a></h3>
                          <div class="d-flex">
                              <div class="pricing">
                                  <p class="price"><span class="mr-2 price-dc">{{getSymbol().' '.currencySet($val->prices->product_mrp_price)}}</span><span class="price-sale">{{getSymbol().' '.currencySet($val->prices->product_sell_price)}}</span></p>
                              </div>
                          </div>
                          <div class="bottom-area d-flex px-3">
                              <div class="m-auto d-flex">
                                
                                  <form method="POST" action="{{route('cart.add')}}" class="form-inline my-2 my-lg-0" >
                                      @csrf
                                      <input name="id" type="hidden" value="{{$val->id}}">
                                      <button class="btn btn-success btn-block" type="submit"><i class="ion-ios-cart"></i></button>
                                  </form>
                                
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              @endforeach
          </div>
      </div>
  </section>

      <section class="ftco-section img" style="background-image: url({{url('/public/')}}/images/bg_3.jpg);">
      <div class="container">
              <div class="row justify-content-end">
        <div class="col-md-6 heading-section ftco-animate deal-of-the-day ftco-animate">
            <span class="subheading">Best Price For You</span>
          <h2 class="mb-4">Deal of the day</h2>
          <p>100% vertical natural stone ground aata made from select MP Sarabati Sehor wheat for softer & healthier chapatis</p>
          <h3><a href="#">Hymn Naturals Aata</a></h3>
          <span class="price">Rs 55 / Kg (1+1 Offer on 25 Kg Bag)</span>
     
        </div>
      </div>
      </div>
  </section>

  <section class="ftco-section testimony-section">
    <div class="container">
      <div class="row justify-content-center mb-5 pb-3">
        <div class="col-md-7 heading-section ftco-animate text-center">
            <span class="subheading">Testimony</span>
          <h2 class="mb-4">Our satisfied customer says</h2>
          <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
        </div>
      </div>
      <div class="row ftco-animate">
        <div class="col-md-12">
          <div class="carousel-testimony owl-carousel">
              @foreach ($testimonial as $key=>$val)
              <div class="item">
                  <div class="testimony-wrap p-4 pb-5">
                    <div class="user-img mb-5" style="background-image: url({{url('/public/'.$val->image)}})">
                      <span class="quote d-flex align-items-center justify-content-center">
                        <i class="icon-quote-left"></i>
                      </span>
                    </div>
                    <div class="text text-center">
                      <p class="mb-5 pl-4 line">{{$val->desc}}</p>
                      <p class="name">{{$val->heading}}</p>
                      <span class="position">{{$val->title}}</span>
                    </div>
                  </div>
                </div>
              @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  <hr>

 <!--  <section class="ftco-section ftco-partner">
      <div class="container">
          <h4 class="text-center">OUR SUPPORTERS</h4><br />
          <div class="row">
              <div class="col-sm ftco-animate">
                  <a href="https://tqcert.in/" class="partner">
                      <img src="https://www.krishitrade.com/assets/images/logo.png" class="img-fluid" alt="krishi trade">
                  </a>
              </div>
              <div class="col-sm ftco-animate">
                  <a href="https://paytmmall.com/" class="partner">
                      <img src="https://i0.wp.com/www.lootersclub.com/wp-content/uploads/2019/09/paytmmall-logo.jpg" class="img-fluid" alt="paytm mall">
                  </a>
              </div>
              <div class="col-sm ftco-animate">
                  <a href="https://www.krishitrade.com/#/home" class="partner">
                      <img src="https://www.krishitrade.com/assets/images/supportus/supporter_3.png" class="img-fluid" alt="hymn">
                  </a>
              </div>
              <div class="col-sm ftco-animate">
                  <a href="https://www.krishitrade.com/#" class="partner">
                      <img src="{{url('/public/images/saba.png')}}" class="img-fluid" alt="saba">
                  </a>
              </div>
              <div class="col-sm ftco-animate">
                  <a href="https://www.maharashtra.gov.in/" class="partner">
                      <img style="height: 85px;" src="https://www.krishitrade.com/assets/images/supportus/supporter_6.png" class="img-fluid" alt="Colorlib Template">
                  </a>
              </div>
          </div>
      </div>
  </section>-->

  <!-- The Modal
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header 
      <div class="modal-header">
        <h4 class="modal-title">Select Location</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body
      <div class="modal-body">
          <form action="" method="POST" >
              <div class="row d-inline">
                  <div class="form-group">
                      <label>Location</label>
                      @php $data=session()->all(); @endphp
                          <select id="location"  name="location" onchange="setLocationOfProducts()" class="form-control">
                              <option value="jaipur" @if(isset($data['LOGGED_CITY'])&&$data['LOGGED_CITY']=='Jaipur'){{"selected='selected'"}}@endif>Jaipur</option>
                              <option value="delhi" @if(isset($data['LOGGED_CITY'])&&$data['LOGGED_CITY']=='Delhi'){{"selected='selected'"}}@endif>Delhi</option>
                              <option value="mumbai"  @if(isset($data['LOGGED_CITY'])&&$data['LOGGED_CITY']=='Mumbai'){{"selected='selected'"}}@endif>Mumbai</option>
                          </select>
                  </div>
              </div>
          </form>
      </div>
      <!-- Modal footer 
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-success" >Submit</button>
      </div> --}}
-->
    </div>
  </div>
</div>
@endsection
