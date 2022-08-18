
@extends('front.layouts.app')
  @section('content')
  <div class="hero-wrap hero-bread " style="background-image:  url({{url('/public/')}}/images/bg_1.jpg);"
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
          <h1 class="mb-0 bread">Shop</h1>
        </div>
      </div>
    </div>
  </div><br />

        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10 mb-5 text-center">
                        <ul class="product-category">
                            <li><a style="cursor:pointer;" onclick="getProductsByCategory('')" class="active">All</a></li>
                            @foreach ($category as $key=>$val)
                                <li><a style="cursor:pointer;" onclick="getProductsByCategory({{$val->id}})">{{$val->title}}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 ftco-animate fadeInUp ftco-animated" id="parentDiv"></div>
                <div class="row" id="data">
                    @foreach ($product as $key=>$val)
                    <div class="col-md-6 col-lg-3 ftco-animate">
                        <div class="product">
                            @php
                            if(!empty($val->sub_category_name))  $route=route('single-product',['category'=>$val->category_name, 'subcategory'=>$val->sub_category_name,'slug'=>$val->slug]);
                            else                                 $route=route('single-category-product',['category'=>$val->category_name,'slug'=>$val->slug]);
                            @endphp
                        <a href="{{$route}}" class="img-prod"><img class="img-fluid" src="{{url('/public/'.$val->image)}}" alt="{{$val->product_name}}">
                                {{-- <span class="status">30%</span> --}}
                                <div class="overlay"></div>
                            </a>
                            <div class="text py-3 pb-4 px-3 text-center">
                                <h3><a href="{{$route}}">{{$val->title}}</a></h3>
                                <div class="d-flex">
                                    <div class="pricing">
                                        <p class="price"><span class="mr-2 price-dc">{{getSymbol().' '.currencySet($val->mrp_price)}}</span><span class="price-sale">{{getSymbol().' '.currencySet($val->price)}}</span></p>
                                    </div>
                                </div>
                                <div class="bottom-area d-flex px-3">
                                    <div class="m-auto d-flex">
                                        <form method="POST" action="{{route('cart.add')}}" class="form-inline my-2 my-lg-0" >
                                            @csrf
                                            <input name="id" type="hidden" value="{{$val->id}}">
                                            <button class="btn btn-success btn-block" type="submit"><span><i class="ion-ios-cart"></i></span></button>
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
  @endsection
  @section('bottomjs')
  <script>
      function getProductsByCategory(id){
        $.ajax({
                type:'get',
                url:"{{route('shop-products')}}",
                data:'id='+id,
                dataType:'html',
                success:function(resData) {
                    $("#data").html(resData);
                }
            });
      }
  </script>
@endsection
