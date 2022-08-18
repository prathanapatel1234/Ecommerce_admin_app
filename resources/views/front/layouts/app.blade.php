<!DOCTYPE html>
<html lang="en">
  <head>
    @yield('title')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('/public/images/icon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{url('/public/images/icon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{url('/public/css/open-iconic-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('/public/css/animate.css')}}">

    <link rel="stylesheet" href="{{url('/public/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{url('/public/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{url('/public/css/magnific-popup.css')}}">

    <link rel="stylesheet" href="{{url('/public/css/aos.css')}}">

    <link rel="stylesheet" href="{{url('/public/css/ionicons.min.css')}}">

    <link rel="stylesheet" href="{{url('/public/css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{url('/public/css/jquery.timepicker.css')}}">


    <link rel="stylesheet" href="{{url('/public/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{url('/public/css/icomoon.css')}}">
    <link rel="stylesheet" href="{{url('/public/css/style.css?ver=1.0.0')}}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  </head>
  <style>
      input,select,textarea{
        color: rgba(0, 0, 0) !important;
      }
      .btn.btn-primary:hover{
    color: white!important;
      }
  </style>
  <body class="goto-here">
		<div class="py-1 bg-primary">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
	    		<div class="col-lg-12 d-block">
		    		<div class="row d-flex">
		    			<div class="col-md-4 pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
                            <span class="text">+91 92222 5 8888</span>
                          <!--    <select class="form-control p-1" style="    height: 35px !important;" onchange="setCurrency()" name="currency" id="currency">
                                <option value="INR" @if(isset(Sess()['currency']) && Sess()['currency']=='INR'){{'selected'}}@endif>INR - ₹</option>
                                <option value="USD" @if(isset(Sess()['currency']) && Sess()['currency']=='USD'){{'selected'}}@endif>USD - $</option>
                                <option value="EUR" @if(isset(Sess()['currency']) && Sess()['currency']=='EUR'){{'selected'}}@endif>EURO - €</option>
                            </select>-->
					    </div>
					    <div class="col-md pr-4 d-flex topper align-items-center">
					    	<div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
						    <span class="text" style="text-transform: lowercase!important;">Info@365dailyneeds.in</span>
					    </div>
					    <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
						    <span class="text">Unit of <a class="text-white" target="_blank" href="https://www.KrishiTrade.com">www.365dailyneeds.in</a></span>
					    </div>
				    </div>
			    </div>
		    </div>
		  </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar" style="background: white!important;">
	    <div class="container">
	      <a class="navbar-brand" href="{{url('/')}}">
	          <!--<img style="height:71px;" src="{{url('/public/images/logo.png')}}" />-->
	          </a>
	      <button class="navbar-toggler" style="background: #82ae46!important;" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu" style="color: white;"></span>
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="{{url('/')}}" class="nav-link text-muted">Home</a></li>
	          {{-- <li class="nav-item dropdown"><a class="nav-link text-muted " id="dropdown04" data-toggle="dropdown">Shop</a></li> --}}
              <li class="nav-item"><a href="about.html" class="nav-link text-muted">About</a></li>
              {{-- <li class="nav-item"><a href="blog.html" class="nav-link text-muted">Blog</a></li> --}}
              <li class="nav-item"><a href="contact.html" class="nav-link text-muted">Contact</a></li>

            @php $data=session()->all(); @endphp
            @if(!isset($data['LOGGED_ID']))
            <li class="nav-item"><a href="{{route('login')}}" class="nav-link text-muted">Login</a></li>
            <li class="nav-item"><a href="{{route('register')}}" class="nav-link text-muted">Register</a></li>
            @else
            <li class="nav-item dropdown">
                <a class="nav-link text-muted dropdown-toggle" href="#" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>
                <div class="dropdown-menu" aria-labelledby="dropdown05">
                <a class="dropdown-item" href="{{route('users.dashboard')}}">Mr. {{Session::get('LOGGED_NAME')}}</a>
                    <a class="dropdown-item" href="#">My Profile</a>
                    <a class="dropdown-item" href="#">Orders</a>
                    <a class="dropdown-item" href="#">Payment</a>
                    <a class="dropdown-item" href="{{route('logout')}}">Logout</a>
                </div>
            </li>
            @endif
            <li class="nav-item cta cta-colored">
                <a href="{{route('cart.list')}}" class="nav-link text-muted">
                      <span class="icon-shopping_cart"></span>{{Cart::getContent()->count()}}
                </a>
            </li>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->

    @yield('content')

    <footer class="ftco-footer ftco-section">
      <div class="container">
      	<div class="row">
      		<div class="mouse">
						<a href="#" class="mouse-icon">
							<div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
						</a>
					</div>
      	</div>
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">365 Daily Needs</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
                <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                    <li class="ftco-animate"><a href="https://twitter.com/krishi_trade" style="width: 39px;height: 39px;"><span class="icon-twitter"></span></a></li>
                    <li class="ftco-animate"><a href="https://www.facebook.com/krishitrade/"  style="width: 39px;height: 39px;"><span class="icon-facebook"></span></a></li>
                    <li class="ftco-animate"><a href="https://api.whatsapp.com/send?phone=+919029026000&lang=en"  style="width: 39px;height: 39px;"><span class="icon-whatsapp"></span></a></li>
                    <li class="ftco-animate"><a href="https://www.linkedin.com/company/krishi-trade"  style="width: 39px;height: 39px;"><span class="icon-linkedin"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Menu</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">Shop</a></li>
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Journal</a></li>
                <li><a href="#" class="py-2 d-block">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Help</h2>
              <div class="d-flex">
	              <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
	                <li><a href="#" class="py-2 d-block">Shipping Information</a></li>
	                <li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
	                <li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
	                <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
	              </ul>
	              <ul class="list-unstyled">
	                <li><a href="#" class="py-2 d-block">FAQs</a></li>
	                <li><a href="#" class="py-2 d-block">Contact</a></li>
	              </ul>
	            </div>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">Krishi Trade Private Market
                                                                                    Lai Televentures Limited
                                                                                    Tata Steel Yard / Gateway Rail,
                                                                                    Sector-3E, Kalamboli,
                                                                                    Navi Mumbai - 410218
                                                                                    Maharashtra, India
                        </span>
                    </li><br />
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+91 9029026000</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">Info@365dailyneeds.in</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
 			   Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | By <a href="http://www.aamoditsolutions.com/"> Aamod Itsolutions</a>
			   <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
			</p>
          </div>
        </div>
      </div>
    </footer>



  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen">
      <svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg>
  </div>
  <script src="{{url('/public/js/jquery.min.js')}}"></script>
  <script src="{{url('/public/js/jquery-migrate-3.0.1.min.js')}}"></script>
  <script src="{{url('/public/js/popper.min.js')}}"></script>
  <script src="{{url('/public/js/bootstrap.min.js')}}"></script>
  <script src="{{url('/public/js/jquery.easing.1.3.js')}}"></script>
  <script src="{{url('/public/js/jquery.waypoints.min.js')}}"></script>
  <script src="{{url('/public/js/jquery.stellar.min.js')}}"></script>
  <script src="{{url('/public/js/owl.carousel.min.js')}}"></script>
  <script src="{{url('/public/js/jquery.magnific-popup.min.js')}}"></script>
  <script src="{{url('/public/js/aos.js')}}"></script>
  <script src="{{url('/public/js/jquery.animateNumber.min.js')}}"></script>
  <script src="{{url('/public/js/bootstrap-datepicker.js')}}"></script>
  <script src="{{url('/public/js/scrollax.min.js')}}"></script>
  {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script> --}}
  <script src="{{url('/public/js/google-map.js')}}"></script>
  <script src="{{url('/public/js/main.js')}}"></script>

  </body>
</html>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@yield('bottomjs')
<script>
    function SubmitForm(id){
        event.preventDefault();
            $.ajax({
                url: $('#submitForm'+id).attr('action'),
                type: "POST",
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: new FormData($('#submitForm'+id)[0]),
                success: function(data) {
                    if(data['success']=='true'){
                        $("#parentDiv").html(data['data']);
                    }
                }
            });
}

function setCurrency(){
            $.ajax({
                type:'get',
                url:"{{route('currency')}}",
                data:'currency='+$('#currency option:selected').val(),
                dataType:'text',
                success:function(resData) {
                    window.location.href = window.location.href;
                }
            });
}


   var SITEURL = '{{URL::to('')}}';
   $.ajaxSetup({
     headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });
   $('#billing-form').submit(function(e){
    //var validate=checkValidation();
if($("#pay_type option:selected").val()==1){
    var totalAmount = $("#total_amount").val().replace(",", "");
    var options = {
     "key": "rzp_test_jyFQF5QEwvw5PQ",
     "amount": (totalAmount*100), // 2000 paise = INR 20
     "name": "SabjiMart",
     "description": "Payment",
     'currency':"{{Sess()['currency']}}",
     "image": SITEURL+"/public/images/logo.png",
     "handler": function (response){
      var paymentid=$("#payment_id").val(response.razorpay_payment_id);

      $.ajax({
             url: "{{route('paysuccess')}}",
             type: 'post',
             processData: false,  // Important!
             contentType: false,
             cache: false,
             dataType: 'json',
             data: new FormData($('#billing-form')[0]),
             success: function (msg){
                   location.href = "{{route('my.orders')}}";
             }
         });
     },
    "prefill":
     {
         "contact": '+19029026000',
         "email":   'info@subjimart.com',
     },
     "theme":
     {
         "color": "#82ae46"
     }
   };
   var rzp1 = new Razorpay(options);
   rzp1.open();
   e.preventDefault();
}
else{
    e.preventDefault();
     $.ajax({
             url: "{{route('paysuccess')}}",
             type: 'post',
             processData: false,  // Important!
             contentType: false,
             cache: false,
             dataType: 'json',
             data: new FormData($('#billing-form')[0]),
             success: function (msg)
             {
                  // location.href = "{{route('my.orders')}}";
             }
         });

}
   });



   /*document.getElementsClass('buy_plan1').onclick = function(e){
     rzp1.open();
     e.preventDefault();
   }*/

</script>

<script>

    $("#proceed-checkout").click(function(){
        var item="{{count(Cart::getContent())>0}}";
        if(item==0)
        {
            alert('Cart is Empty Please go to Shop Page');
        }
        else
        {
            $(this).attr('href','{{route('cart.checkout')}}');
        }
    });

function setQty(thisobj,id){  $("#quantity-upadte"+id).val(thisobj.value);}

    function setLocationOfProducts(){
            $.ajax({
                type:'get',
                url:"{{route('location')}}",
                data:'location='+$('#location option:selected').text(),
                dataType:'text',
                success:function(resData) {
                    window.location.href = window.location.href;
                }
            });
        }

 var quantitiy=0;

    function QuantityPlus(id){
                // Stop acting like a button
//                event.preventDefault();
                // Get the field name
                var quantity = parseInt($('#quantity'+id).val());
                // If is not undefined
                    $('#quantity'+id).val(quantity + 1);
                // Increment
    }


    function QuantityMinus(id){
                // Stop acting like a button
                event.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity'+id).val());

            // If is not undefined

                // Increment
                if(quantity>0){
                $('#quantity'+id).val(quantity - 1);
                }
    }


    $(document).ready(function(){

    var quantitiy=0;
       $('.quantity-right-plus').click(function(e){

            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

                $('#quantity').val(quantity + 1);


                // Increment

        });

         $('.quantity-left-minus').click(function(e){
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());

            // If is not undefined

                // Increment
                if(quantity>0){
                $('#quantity').val(quantity - 1);
                }
        });

    });
</script>
<script>
    $(document).ready(function(){
        setTimeout(function(){ $("#myModal").modal(); }, 2000);
    });
</script>
