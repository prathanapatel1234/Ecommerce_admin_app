@extends('front.layouts.app')
  @section('content')
    <div class="hero-wrap hero-bread bg-primary" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-0 bread">Login</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-7 ftco-animate">
            @include('alert')
          <form action="{{route('check-login')}}" method="POST" class="billing-form">
            @csrf
							  <h3 class="mb-4 text-center billing-heading"></h3>
                                <div class="row align-items-end">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="firstname">E-mail</label>
                                        <input required="required" type="text" name="email" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="lastname">Password</label>
                                    <input type="password"  required="required" name="password" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <a href="{{route('register')}}">Create My Account ?</a>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                    <input type="submit" value="Login" class="btn btn-primary btn-block p-3" class="form-control" placeholder="">
                                    </div>
                                </div>

                        </form><!-- END -->
					</div>
          </div> <!-- .col-md-8 -->
        </div>
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
