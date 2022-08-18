@extends('front.layouts.app')
  @section('content')
    @if(!empty($product[0]->id))
    <div class="hero-wrap hero-bread" style="background-image: url({{url('/public/'.$product[0]->image)}});">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span class="mr-2"><a href="index.html">Home</a></span> <span>Product Single</span></p>
            <h1 class="mb-0 bread" ">{{$product[0]->name}}</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
    	<div class="container">
    		<div class="row">
    			<div class="col-lg-6 mb-5 ftco-animate">
    			    
                    <a  id="prdimg1" href="{{url('/public/'.$product[0]->image)}}" class="image-popup">
                        <img id="prdimg" src="{{url('/public/'.$product[0]->image)}}" class="img-fluid" alt="Colorlib Template">
                    </a>
    			</div>
    			<div class="col-lg-6 product-details pl-md-5 ftco-animate">
    				<h3></h3>
    		<!--		<div class="rating d-flex">-->
						<!--	<p class="text-left mr-4">-->
						<!--		<a href="#" class="mr-2">5.0</a>-->
						<!--		<a href="#"><span class="ion-ios-star-outline"></span></a>-->
						<!--		<a href="#"><span class="ion-ios-star-outline"></span></a>-->
						<!--		<a href="#"><span class="ion-ios-star-outline"></span></a>-->
						<!--		<a href="#"><span class="ion-ios-star-outline"></span></a>-->
						<!--		<a href="#"><span class="ion-ios-star-outline"></span></a>-->
						<!--	</p>-->
						<!--	<p class="text-left mr-4">-->
						<!--		<a href="#" class="mr-2" style="color: #000;">100 <span style="color: #bbb;">Rating</span></a>-->
						<!--	</p>-->
						<!--	<p class="text-left">-->
						<!--		<a href="#" class="mr-2" style="color: #000;">500 <span style="color: #bbb;">Sold</span></a>-->
						<!--	</p>-->
						<!--</div>-->
						<p> Name : <span>{{$product[0]->product_name}}</span></p>
    				<p class="price"><span >{{getSymbol(Sess()['currency'])}}</span><span id="mrp">{{$product[0]->varient->product_mrp_price}}</span></p>
    				<p>{{$product[0]->short_desc}}</p>
						<div class="row mt-4">
							<div class="col-md-6">
								<div class="form-group d-flex">
		              <div class="select-wrap">
	                  <div class="icon"><span class="ion-ios-arrow-down"></span></div>
	                  <select name="" onchange="GetVarient(this.value);" id="prdvarient" class="form-control">
	                      @foreach($productvarient as $key2=>$val2)
	                  	<option  value="{{$val2->id}}">{{$val2->product_weight}}</option>
	                  @endforeach
	                  </select>
	                </div>
		            </div>
							</div>
							<div class="w-100"></div>
	          	<div class="w-100"></div>
	          	<div class="col-md-12">
	          		<!--<p style="color: #000;">600 kg available</p>-->
	          	</div>
          	</div>
                <p>

                    <form  method="POST" action="{{route('cart.add')}}" class="product-details" >
                        @csrf
                        <input name="id" type="hidden" value="{{$product[0]->id}}">
                         <input name="mrpprice" type="hidden" id="mrpprice" value="{{$product[0]->id}}">
                          <input name="prdimage" type="hidden" id="prdimage" value="{{$product[0]->image}}">
                        <input class="btn btn-success text-white btn-block p-3" style="" type="submit" value="Add to cart">
                    </form>
                </p>
    			</div>
    		</div>
    	</div>
    </section>

    <!--<section class="ftco-section">-->
    <!--	<div class="container">-->
				<!--<div class="row justify-content-center mb-3 pb-3">-->
    <!--      <div class="col-md-12 heading-section text-center ftco-animate">-->
    <!--      	<span class="subheading">Products</span>-->
    <!--        <h2 class="mb-4">Related Products</h2>-->
    <!--        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>-->
    <!--      </div>-->
    <!--    </div>-->
    <!--	</div>-->
    <!--	<div class="container">-->
    <!--		<div class="row">-->
                
    <!--            @foreach($product as $key1=>$val1)-->
    <!--            <div class="col-md-6 col-lg-3 ftco-animate">-->
    <!--                <div class="product">-->
    <!--                <a href="#" class="img-prod"><img class="img-fluid" src="{{url('/public/'.$val1->image)}}" alt="{{$val1->name}}">-->
    <!--                        {{-- <span class="status">30%</span> --}}-->
    <!--                        <div class="overlay"></div>-->
    <!--                    </a>-->
    <!--                    <div class="text py-3 pb-4 px-3 text-center">-->
    <!--                        <h3><a href="#">{{$val1->name}}</a></h3>-->
    <!--                        <div class="d-flex">-->
    <!--                            <div class="pricing">-->
    <!--                                <p class="price"><span class="mr-2 price-dc">{{getSymbol(Sess()['currency']).' '.currencySet($val1->mrp_price)}}</span><span class="price-sale">{{getSymbol(Sess()['currency']).' '.currencySet($val1->price)}}</span></p>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                        <div class="bottom-area d-flex px-3">-->
    <!--                            <div class="m-auto d-flex">-->
    <!--                                <a href="#" class="buy-now d-flex justify-content-center align-items-center mx-1">-->
    <!--                                    <span><i class="ion-ios-cart"></i></span>-->
    <!--                                </a>-->
    <!--                            </div>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            @endforeach-->
              
    <!--		</div>-->
    <!--	</div>-->
    <!--</section>-->
    @endif
@endsection
 @section('bottomjs')
 
 <script type="text/javascript">
  function GetVarient(vals){
            
         var changvar = vals;
          var base_url = "{{url('/public')}}";
        //  var pincode = $('#pins').val();
         $('.process').show();
          $('.SelectFlorist').prop('disabled',true);
         $.ajax({
            
        	type: 'GET',
        	url: "{{route('changevarient')}}",
        	data: {changvar:changvar},
        	success: function(data){
        	    
        	$("#mrp").text(data.product_mrp_price);
        		$("#mrpprice").val(data.product_mrp_price);
                // 		$("#name").text(data.product_mrp_price);
       	    $("#prdimg").attr('src',base_url + data.product_image);
       	     $("#prdimg1").attr('href',base_url + data.product_image);
       	     $("#prdimage").val(data.product_image);
       	    //  $("#prdimg2").attr('href',base_url + data.product_image);
       	    
        	   
                        
	},
// 	error:function(response){
// 	  $('.process').hide();
// 	  alert('something went wrong, select city again!');	
// 	}
	}); 	
};
 </script>
 
 @endsection