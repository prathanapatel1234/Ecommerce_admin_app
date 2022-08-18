@extends('front.layouts.app')
  @section('content')
<div class="hero-wrap hero-bread" style="background-image: url({{url('/public/')}}/images/bg_1.jpg);">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Checkout</span></p>
            <h1 class="mb-0 bread">Checkout</h1>
          </div>
        </div>
      </div>
    </div>

   <section class="ftco-section">
      <div class="container">
         <form  id="billing-form"  class="billing-form">
            @csrf
            <input type="hidden" name="payment_id" id="payment_id" value="pay_EgfqwHOvzAqtUm" />
            <div class="row justify-content-center">
                <div class="col-xl-7 ftco-animate">

                                <h3 class="mb-4 billing-heading">Billing Details</h3>
                    <div class="row align-items-end">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstname">Firt Name</label>
                            <input type="text" oninput="this.value = this.value.replace(/[^A-Z a-z]/g, '').replace(/(\..*)\./g, '$1');" required="required" name="first_name" id="first_name" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                        <input type="text" required="required" oninput="this.value = this.value.replace(/[^A-Z a-z]/g, '').replace(/(\..*)\./g, '$1');" name="last_name" id="last_name"  class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="country">State </label>
                                <div class="select-wrap">
                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                    <select required="required"  name="state" id="state"  class="form-control">
                                        <option value="">Select</option>
                                        <option value="France">France</option>
                                        <option value="France">Italy</option>
                                        <option value="France">Philippines</option>
                                        <option value="France">South Korea</option>
                                        <option value="France">Hongkong</option>
                                        <option value="France">Japan</option>
                                    </select>
                                    </div>
                            </div>
                        </div>
                        <div class="w-100"></div>

                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="country">City </label>
                                <div class="select-wrap">
                            <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                            <select required="required" name="city" id="city"  class="form-control">
                                <option value="">Select</option>
                                <option value="France">France</option>
                                <option value="France">Italy</option>
                                <option value="France">Philippines</option>
                                <option value="France">South Korea</option>
                                <option value="France">Hongkong</option>
                                <option value="France">Japan</option>
                            </select>
                            </div>
                            </div>
                        </div>
                        <div class="w-100"></div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="streetaddress">Street Address</label>
                                <textarea required="required"  class="form-control" name="address" id="address"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="postcodezip">Postcode / ZIP *</label>
                                <input type="text" required="required" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"  name="zipcode" id="zipcode"  class="form-control" placeholder="">
                        </div>
                        </div>

                        <div class="w-100"></div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                        <input type="text" required="required" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" name="mobile_no" id="mobile_no"  class="form-control" placeholder="">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="emailaddress">Email Address</label>
                        <input type="email" required="required"  name="email" id="email"  class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-md-12">
                        <div class="form-group mt-4">
                                            {{-- <div class="radio">
                                            <label class="mr-3"><input type="radio" name="optradio"> Create an Account? </label>
                                            <label><input type="radio" name="optradio"> Ship to different address</label>
                                            </div> --}}
                                        </div>
                    </div>
                    </div>
                </form><!-- END -->
                        </div>
                        <div class="col-xl-5">
                <div class="row mt-5 pt-3">
                    <div class="col-md-12 d-flex mb-5">
                        <div class="cart-detail cart-total p-3 p-md-4">
                            <h3 class="billing-heading mb-4">Cart Total</h3>
                            <p class="d-flex">
                                        <span>Subtotal</span>
                                        <span>{{getSymbol().' '.currencySet(Cart::getSubTotal())}}</span>
                                        <input type="hidden" name="sub_total" id="sub_total" value="{{currencySet(Cart::getSubTotal())}}"/>
                                    </p>
                                    <p class="d-flex">
                                        <span>Delivery</span>
                                    <span>{{getSymbol()}}0.00</span>
                                        <input type="hidden" name="delivery_charges" id="delivery_charges" value="0"/>
                                    </p>
                                    <p class="d-flex">
                                        <span>Discount</span>
                                        <span>{{getSymbol()}} 0.00</span>
                                        <input type="hidden" name="discount" id="discount"  value="0"/>
                                    </p>
                                    <hr>
                                    <p class="d-flex total-price">
                                        <span>Total</span>
                                        <span>{{getSymbol().' '.currencySet(Cart::getSubTotal())}}</span>
                                        {{-- {{Cart::getSubTotal()}} --}}
                                        <input type="hidden" name="total_amount" id="total_amount" value="{{currencySet(Cart::getSubTotal())}}"/>
                                    </p>
                                    </div>
                    </div>
                    <div class="col-md-12">
                        <div class="cart-detail p-3 p-md-4">
                            <h3 class="billing-heading mb-4">Payment Method</h3>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label>Payment Options</label>
                                                <select id="pay_type" name="pay_type" required="required" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="1">Online Payment</option>
                                                    <option value="2">COD (Cash on Delivery)</option>
                                                </select>
                                                {{-- <div class="radio">
                                                <label><input type="radio" name="payment" id="payment" value="1"  checked  class="mr-2">Online Payment</label>
                                                </div> --}}
                                            </div>
                                        </div>

                                        {{-- <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="radio">
                                                <label><input type="radio" name="payment" id="payment"   value="2" class="mr-2">COD (Cash on Delivery)</label>
                                                </div>
                                            </div>
                                        </div> --}}
{{--
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                <label><input  type="checkbox"  id="terms" name="terms" class="mr-2"> I have read and accept the terms and conditions</label>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <p>
                                            <button id="submit" type="submit"  class="btn btn-primary py-3 px-4 buy_now" data-amount="1" data-id="{{session()->get('LOGGED_ID')}}">Place Order Now</button>
                                            {{-- <a class="btn btn-primary py-3 px-4 buy_now">Place an order</a> --}}
                                        </p>
                                    </div>
                    </div>
                </div>
            </div> <!-- .col-md-8 -->
            </div>

        </form>
      </div>
    </section> <!-- .section -->


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
