@extends('admin/layouts/default')
@section('title')
<title>Create Offer</title>
@stop
@section('inlinecss')
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link href="{{ asset('admin/assets/multiselectbox/css/ui.multiselect.css') }}" rel="stylesheet">
@stop
@section('breadcrum')
<h1 class="page-title">Create Promocode</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Promocode</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
</ol>
@stop

@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!--  Start Content -->
                 <form id="submitForm" class="row"  method="post" action="@if(isset($offer->id)) {{route('offer-update',$offer->id)}} @else {{route('offer-store')}} @endif" enctype="multipart/form-data">
                        @csrf
                    <!-- COL END -->
							<div class="col-lg-12">
                                <div class="row">
                                     <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">General information</h3>
                                                </div>
                                                <div class="card-body">
                                                   <div class="form-group">
                                                        <label class="form-label"> Coupon Name  </label>
                                                   <input type="text" value="@if(isset($offer->offer_name)){{$offer->offer_name}}@endif" required="required"  class="form-control" name="offer_name" id="Offer_name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">Coupon Type</label>
                                                        <select onchange="setFlatAndDiscount()" class="form-control select2" name="coupon_type" id="offer_discount_type" required>
                                                            <option value=""> Select  </option>
                                                            <option @if(isset($offer->coupon_type) && $offer->coupon_type==1) {{"selected='selected'"}}@endif value="1">Flat off</option>
                                                            <option @if(isset($offer->coupon_type) && $offer->coupon_type==2) {{"selected='selected'"}}@endif value="2">% off</option>
                                                        </select>
                                                    </div>
                                                    {{-- <div class="form-group">
                                                        <label class="form-label">Coupon Type</label>
                                                            <select  onchange="setCouponFiled()" class="form-control select2" name="offer_type" id="offer_type" required>
                                                                <option value=""> Select  </option>
                                                                <option value="Coupon">Coupon</option>
                                                                <option value="Promo">Promo</option>
                                                            </select>
                                                    </div> --}}

                                                    <div class="form-group d-none" id="discountfield_div">
                                                        <label class="form-label" id="discountfield_label"></label>
                                                    <input class="form-control" value="" name="discount_amountoff" id="discountcoupon_field" >
                                                    </div>

                                                    <div class="form-group d-none" id="max_discount">
                                                        <label class="form-label" id="max_discount_label"></label>
                                                        <input  class="form-control" name="discount_percentage" id="max_discount_field">
                                                    </div>


                                                    <div class="form-group" >
                                                        <label class="form-label" >Coupon Limit</label>
                                                        <input name="coupon_uses" value="@if(isset($offer->coupon_uses)){{$offer->coupon_uses}}@endif"  class="form-control" type="text" required="required" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="2" >
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label"> Minimum Amount </label>
                                                        <input type="text" required="required"  value="@if(isset($offer->receipt_amt)){{$offer->receipt_amt}}@endif"    class="form-control" name="receipt_amt" id="reciept_name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">Coupon Description</label>
                                                        <textarea class="form-control" name="offer_desc">@if(isset($offer->offer_desc)){{$offer->offer_desc}}@endif</textarea>
                                                    </div>
                                                </div>
                                             </div>
                                        </div>

                                        <div class="container-fluid">
                                            <button type="submit" id="submitButton" class="btn btn-primary btn-lg float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="
                                                @if(isset($offer->id))
                                                Update
                                                @else
                                                Create
                                                @endif">
                                                @if(isset($offer->id))
                                                Update
                                                @else
                                                Create
                                                @endif
                                                </button>
                                            <input type="hidden" name="id" id="" value="" />
                                        </div>
                                    </div>
                               </div>
                   </form>
        </div><!-- COL END -->
        <!--  End Content -->

    </div>
</div>

@stop
@section('inlinejs')
<script type="text/javascript">
  $( "#offer_start_date" ).datepicker();
  $( "#offer_end_date" ).datepicker();
function setNeverExpireOfferEndDate(){
    if($("#never_exp").is(':checked')){
        $("#offer_end_date").val('');
        $("#offer_end_date_div").hide();
    }
    else
    {
        $("#offer_end_date_div").show();
        $("#offer_end_date").attr('required','required');
    }
}


            function setFlatAndDiscount(){
                var offer_type=$("#offer_discount_type option:selected").val();
                if(offer_type==1){
                    $("#max_discount").addClass('d-none');
                    $("#discountfield_div").removeClass('d-none');
                    $("#discountfield_label").html('Amount off');
                    $("#discountcoupon_field").attr('type','number');
                    $("#discountcoupon_field").attr('required','required');
                    $("#max_discount_field").removeAttr('required','required');
                    $("#discountcoupon_field").val('');

                }
                else
                {
                    $("#discountfield_div").removeClass('d-none');
                    // $("#discountfield_label").html('Amount Off');
                    // $("#discountcoupon_field").attr('type','number');
                    $("#discountfield_div").addClass('d-none');

                    $("#max_discount").removeClass('d-none');
                    $("#max_discount_label").html('Percentage Off');
                    $("#max_discount_field").attr('type','number');
                    $("#max_discount_field").attr('required','required');
                    $("#max_discount_field").val('');


                }
            }

$(document).ready(function(){
            var offer_type=$("#offer_discount_type option:selected").val();
                if(offer_type==1){
                    $("#max_discount").addClass('d-none');
                    $("#discountfield_div").removeClass('d-none');
                    $("#discountfield_label").html('Amount off');
                    $("#discountcoupon_field").attr('type','number');
                    $("#discountcoupon_field").attr('required','required');
                    $("#max_discount_field").removeAttr('required','required');
                    $("#discountcoupon_field").val(@if(isset($offer->discount_amountoff) && $offer->coupon_type==1) {{$offer->discount_amountoff}}@else{{''}}@endif);

                }
                else if(offer_type==2)
                {
                    $("#discountfield_div").removeClass('d-none');
                    // $("#discountfield_label").html('Amount Off');
                    // $("#discountcoupon_field").attr('type','number');
                    $("#discountfield_div").addClass('d-none');

                    $("#max_discount").removeClass('d-none');
                    $("#max_discount_label").html('Percentage Off');
                    $("#max_discount_field").attr('type','number');
                    $("#max_discount_field").attr('required','required');
                    $("#max_discount_field").val(@if(isset($offer->discount_amountoff) && $offer->coupon_type==2) {{$offer->discount_amountoff}}@else{{''}}@endif);
                }
});

        $(function () {



           $('#submitForm').submit(function(){
            var $this = $('#submitButton');
            buttonLoading('loading', $this);
            $('.is-invalid').removeClass('is-invalid state-invalid');
            $('.invalid-feedback').remove();
            $.ajax({
                url: $('#submitForm').attr('action'),
                type: "POST",
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: new FormData($('#submitForm')[0]),
                success: function(data) {
                    if(data.status){
						var btn = '<a href="{{route('offer-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Create Offer', data.msg, btn);
                        $('#submitForm')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               console.log(fieldName);
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Create Offer','Input error');
                    }
                    buttonLoading('reset', $this);

                },
                error: function() {
                    errorMsg('Create Offer', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

         });

    </script>
@stop
