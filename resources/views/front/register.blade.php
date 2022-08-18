@extends('front.layouts.app')
  @section('content')
    <div class="hero-wrap hero-bread bg-primary" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-0 bread">Register</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
      <div class="container">

        <div class="row justify-content-center">
          <div class="col-xl-7 ftco-animate">
            @include('alert')
                <form action="{{route('save.register')}}" method="POST" class="billing-form">
                    @csrf
                    <h3 class="mb-4 text-center billing-heading"></h3>
                    <div class="row align-items-end">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstname">Name</label>
                            <input type="text" oninput="this.value = this.value.replace(/[^A-Z a-z]/g, '').replace(/(\..*)\./g, '$1');" name="name" id="name" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstname">E-mail</label>
                            <input type="email" name="email" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="lastname">Password</label>
                            <input type="password"  name="password" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="firstname">Mobile No</label>
                                <input type="text" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="mobile" id="mobile" class="form-control" placeholder="">
                            </div>
                        </div>

                    <div class="col-md-12">
                        <div class="form-group">
                        <input type="submit" value="Register" class="btn btn-primary btn-block p-3" class="form-control" placeholder="">
                        </div>
                    </div>
                  </form><!-- END -->
					</div>
          </div> <!-- .col-md-8 -->
        </div>
      </div>
    </section> <!-- .section -->
@endsection
