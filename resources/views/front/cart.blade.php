@extends('front.layouts.app')
  @section('content')
    <div class="hero-wrap hero-bread" style="background-image: url({{url('/public/')}}/images/bg_1.jpg);">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          <p class="breadcrumbs"><span class="mr-2"><a href="{{route('home')}}">Home</a></span> <span>Cart</span></p>
            <h1 class="mb-0 bread">My Cart</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-cart">
			<div class="container">
                @include('messages')
				<div class="row">
    			<div class="col-md-12 ftco-animate">
                    <form method="POST" action="{{route('cart.update')}}" class="" >
                        @csrf
                        <div class="cart-list table-responsive">
                            <table class="table ">
                                <thead class="thead-primary">
                                <tr class="text-center">
                                    <th>&nbsp;</th>
                                    <th style="width: 5%;">&nbsp;</th>
                                    <th>Product name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Update</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                              @if(count(Cart::getContent())>0)
                                @foreach(Cart::getContent() as $product)
						      <tr class="text-center">
                                <td class="product-remove">
                                    <a href="{{route('remove',$product->id)}}">
                                        <span class="ion-ios-close"></span>
                                    </a>
                                </td>
						        <td class="image-prod"><div class="img" style="background-image:url({{url('/public/'.$product->image)}});"></div></td>
						        <td class="product-name">
						        	<h3>{{$product->name}}</h3>
						        </td>
                                <td class="price">{{getSymbol().' '.currencySet($product->price)}}</td>
						         <td class="quantity">
						        	<div class="input-group mb-3">
                                        {{-- <span class="input-group-btn mr-2">
                                            <button type="button" class="quantity-left-minus{{$product->id}} btn"  onclick="QuantityMinus({{$product->id}})">
                                           <i class="ion-ios-remove"></i>
                                            </button>
                                            </span> --}}
                                            <button type="button" class="btn btn-primary quantity-right-plus{{$product->id}} btn-sm"  onclick="QuantityMinus({{$product->id}})" style="width: 26%;border-radius: 0px;">
                                                <i class="ion-ios-remove text-white " style="font-size: 23px;"></i>
                                             </button>
                                         <input type="text" name="quantity[{{$product->id}}][]" id="quantity{{$product->id}}" onkeyup="setQty(this,{{$product->id}})" class="quantity form-control input-number" value="{{$product->quantity}}" >
                                         <button type="button" class="btn btn-primary btn-sm quantity-right-plus{{$product->id}}"  onclick="QuantityPlus({{$product->id}})" style="width: 26%;border-radius: 0px;">
                                            <i class="ion-ios-add text-white " style="font-size:23px;"></i>
                                         </button>
                                         {{-- <span class="input-group-btn ml-2">
                                            <button type="button" class="quantity-right-plus{{$product->id}} btn btn-primary" onclick="QuantityPlus({{$product->id}})">

                                             </button>
                                         </span> --}}
					          	    </div>
					             </td>
                              <td>
                            </td>
                            <td class="total">{{getSymbol().' '.currencySet($product->price*$product->quantity)}}</td>
						      </tr><!-- END TR-->
                              @endforeach
                         @else
                            <td >Cart is Empty</td>
                         @endif
						      </tr><!-- END TR-->
						    </tbody>
                          </table>
                      </div>
                      <input class="btn btn-success  text-white float-right p-3 mt-4" style="border-radius: 4px;" type="submit" style="color:white!important" value="Update Cart">
                  </form>
    			</div>
    		</div>
    		<div class="row justify-content-end">
    			<div class="col-lg-4 mt-5 cart-wrap ftco-animate">
    				<div class="cart-total mb-3">
    					<h3>Coupon Code</h3>
    					<p>Enter your coupon code if you have one</p>
  						<form action="#" class="info">
	              <div class="form-group">
	              	<label for="">Coupon code</label>
	                <input type="text" class="form-control text-left px-3" placeholder="">
	              </div>
	            </form>
    				</div>
    				<p><a href="checkout.html" class="btn btn-primary py-3 px-4">Apply Coupon</a></p>
    			</div>
    			<div class="col-lg-4 mt-5 cart-wrap ftco-animate">
    				<div class="cart-total mb-3">
    					<h3>Estimate shipping and tax</h3>
    					<p>Enter your destination to get a shipping estimate</p>
  						<form action="#" class="info">
	              <div class="form-group">
	              	<label for="">Country</label>
	                <input type="text" class="form-control text-left px-3" placeholder="">
	              </div>
	              <div class="form-group">
	              	<label for="country">State/Province</label>
	                <input type="text" class="form-control text-left px-3" placeholder="">
	              </div>
	              <div class="form-group">
	              	<label for="country">Zip/Postal Code</label>
	                <input type="text" class="form-control text-left px-3" placeholder="">
	              </div>
	            </form>
    				</div>
    				<p><a href="checkout.html" class="btn btn-primary py-3 px-4">Estimate</a></p>
    			</div>
    			<div class="col-lg-4 mt-5 cart-wrap ftco-animate">
    				<div class="cart-total mb-3">
    					<h3>Cart Totals</h3>
    					<p class="d-flex">
    						<span>Subtotal</span>
    						<span>{{getSymbol().' '.currencySet(Cart::getSubTotal())}}</span>
                        </p>

    					<p class="d-flex">
    						<span>Delivery</span>
    						<span>{{getSymbol().' '}} 0.00</span>
    					</p>
    					<p class="d-flex">
    						<span>Discount</span>
    						<span>{{getSymbol().' '}} 0.00</span>
    					</p>
    					<hr>
    					<p class="d-flex total-price">
    						<span>Total</span>
    						<span> {{getSymbol().' '.currencySet(Cart::getSubTotal())}}</span>
    					</p>
    				</div>
    				<p><a href="#" id="proceed-checkout" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
    			</div>
    		</div>
			</div>
        </section>


        <section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
            <div class="container py-4">
              <div class="row d-flex justify-content-center py-5">
                <div class="col-md-6">
                    <h2 style="font-size: 22px;" class="mb-0">Subcribe to our Newsletter</h2>
                    <span>Get e-mail updates about our latest shops and special offers</span>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                  <form action="#" class="subscribe-form">
                    <div class="form-group d-flex">
                      <input type="text" class="form-control" placeholder="Enter email address">
                      <input type="submit" value="Subscribe" class="submit px-3">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </section>

    @endsection
