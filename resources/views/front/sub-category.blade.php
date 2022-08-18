
@extends('front.layouts.app')
  @section('content')
  <section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-5 text-center">
                {{-- <ul class="product-category">
                    <li><a href="#" class="active">All</a></li>
                    @foreach ($category as $key=>$val)
                        <li><a href="#">{{$val->title}}</a></li>
                    @endforeach
                </ul> --}}
            <h1>{{$subtitle}}</h1>
            </div>
        </div>

        @include('messages')
        <div class="row">
            @foreach ($product as $key=>$val)
            <div class="col-md-6 col-lg-3 ftco-animate">
                <div class="product">
                <a href="{{route('single-product',['category'=>$title, 'subcategory'=>$subtitle,'slug'=>$val->slug])}}" class="img-prod"><img class="img-fluid" src="{{url('/public/'.$val->image)}}" alt="{{$val->product_name}}">
                        {{-- <span class="status">30%</span> --}}
                        <div class="overlay"></div>
                    </a>
                    <div class="text py-3 pb-4 px-3 text-center">
                        <h3><a href="">{{$val->product_name}}</a></h3>
                        <div class="d-flex">
                            <div class="pricing">
                                <p class="price"><span class="mr-2 price-dc">{{getSymbol().' '.currencySet($val->product_mrp_price)}}</span><span class="price-sale">{{getSymbol().' '.currencySet($val->product_mrp_price)}}</span></p>
                            </div>
                        </div>
                        <div class="bottom-area d-flex px-3">
                            <div class="m-auto d-flex">
                                <form method="POST" action="{{route('cart.add')}}" class="form-inline my-2 my-lg-0" >
                                    @csrf
                                    <input name="id" type="hidden" value="{{$val->id}}">
                                    <button class="btn btn-success btn-block" type="submit">Add to cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row mt-5">
      <div class="col text-center">
        <div class="block-27">
          <ul>
            <li><a href="#">&lt;</a></li>
            <li class="active"><span>1</span></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">&gt;</a></li>
          </ul>
        </div>
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
