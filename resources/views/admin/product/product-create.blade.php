@extends('admin/layouts/default')
@section('title')
<title>Create Product</title>
@stop

@section('inlinecss')
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link href="{{ asset('admin/assets/multiselectbox/css/ui.multiselect.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Create Product</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Product</a></li>
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
    <form id="submitForm" class="row"  method="post" action="{{route('product-save')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <!-- COL END -->
							<div class="col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Product Forms</h3>
									</div>
									<div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <label class="form-label">Name *</label>
                                                <input onblur="convertToSlug(this)" type="text" class="form-control" name="name" id="name" placeholder="Title..">
                                            </div>
                                            <div class="form-group col-12">
                                                <label class="form-label">Slug *</label>
                                                <input type="text" readonly="readonly" class="form-control" name="slug" id="slug" placeholder="Slug..">
                                            </div>
                                            <div class="form-group col-6">
                                                <label class="form-label">Category *</label>
                                                <select required="required" onchange="getName('category_id','category_name');getSubCategory(this,'get-subcategory','sub_category_id')" name="category_id" id="category_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($category as $key=>$val)
                                                    <option value="{{$val->id}}">{{$val->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-6">
                                                <label class="form-label">Sub Category </label>
                                                <select name="sub_category_id" onchange="getName('sub_category_id','sub_category_name')" id="sub_category_id" class="form-control">
                                                    <option value="">Select</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-12">
                                                <label  for="value"><b>Short Description</b></label>
                                                    <textarea maxlength="70" class="form-control" name="short_desc" id="short_desc"></textarea>
                                            </div>

                                            <div class="form-group col-12">
                                                <label  for="value"><b>Description</b></label>
                                                    <textarea class="Description" name="description" id="description"></textarea>
                                            </div>

                                            <div class="col-md-12"  id="productText">
                                                <div class="row">

                                                    <div class=" col-lg-2 col-12">
                                                        <label  for="value"><b>Product Weight</b></label>
                                                        <input  name="product_weight[]" id="product_weight" type="text" oninput="this.value = this.value.replace(/[^A-Z a-z 0-9]/g, '').replace(/(\..*)\./g, '$1');" class="form-control" placeholder="">
                                                    </div>

                                                    <div class="col-lg-2 col-12">
                                                        <label  for="value"><b>Mrp Price </b></label>
                                                        <input  name="product_mrp_price[]" id="product_mrp_price"  type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="12" class="form-control" placeholder="">
                                                    </div>

                                                    <div class="col-lg-2 col-12">
                                                        <label  for="value"><b>Selling Price </b></label>
                                                        <input  name="product_sell_price[]" id="product_sell_price" type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="12" class="form-control"  placeholder="">
                                                    </div>

                                                    <div class=" col-lg-2 col-12">
                                                        <label  for="value"><b>Product  Qty</b></label>
                                                        <input  name="product_total_qty[]" id="product_total_qty" type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="12" class="form-control"  placeholder="">
                                                    </div>
                                                    
                                                    <div class="col-lg-3 col-12">
                                                        <label  for="value"><b>Product Image</b></label>
                                                        <input  name="product_image[]" id="product_image" type="file" class="form-control">
                                                    </div>

                                                    <div class="col-lg-1 col-12  d-flex align-items-center ">
                                                        <button onclick="addMoreProductVariations()" type="button" class="btn btn-success mt-2"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-12  ">
                                                <label class="control-label mt-4"> Image </label>
                                                <div class="row">
                                                    <div class="col-md-10 ">
                                                        <input id="image" type="file" class="form-control align-middle custom-file-input" name="image" onchange="readURL(this, 'FileImg');">
                                                        <label class="text-dark mt-4 ml-2 custom-file-label" for="image">Choose file</label>
                                                  </div>
                                                    <div class="col-md-2 ">
                                                    <img id="FileImg" src="{{url('/public/notfound.png')}}" style="width: 100px;height: 100px">
                                                    </div>
                                                </div>
                                             </div>

                                        <div class="form-group col-12">
                                            <label class="control-label"  for="value"><b>Product Images</b></label>
                                            <input type="file" class="form-control align-middle custom-file-input" name="products_images[]" onchange="preview_image();" multiple/>
                                            <label class="text-dark mt-4 ml-2 custom-file-label" for="image">Choose file</label>
                                        </div>

                                        <!--<div class="form-group col-12">-->
                                        <!--    <label  for="value"><b>Select Multiple Locations</b></label>-->
                                        <!--        <select class="js-example-basic-multiple form-control" name="location[]" multiple="multiple">-->
                                        <!--            <option value="jaipur">Jaipur</option>-->
                                        <!--            <option value="delhi">Delhi</option>-->
                                        <!--            <option value="mumbai">Mumbai</option>-->
                                        <!--        </select>-->
                                        <!--</div>-->
                                        <!--<div class="form-group col-6">-->
                                        <!--    <label class="form-label">Status </label>-->
                                        <!--    <select class="form-control" id="status" name="status">-->
                                        <!--        <option value="">Select</option>-->
                                        <!--        <option value="approved" >Approved</option>-->
                                        <!--        <option value="pending">Pending</option>-->
                                        <!--        <option value="blocked">Blocked </option>-->
                                        <!--        <option value="onhold">On Hold</option>-->
                                        <!--        <option value="outofstock">Out of Stock</option>-->
                                        <!--    </select>-->
                                        <!--</div>-->
                                    </div>

                                    <!--<div class="form-group col-12">-->
                                    <!--    <div class="custom-control custom-checkbox">-->
                                    <!--        <input value="1" type="checkbox" class="custom-control-input" id="Latest" name="latest">-->
                                    <!--        <label class="custom-control-label" for="Latest">Latest</label>-->
                                    <!--      </div>-->
                                    <!--</div>-->

                                        {{-- <div class="form-group col-12">
                                            <div id="image_preview" class="row"></div>
                                        </div> --}}
                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Create">Create</button>
										</div>
									</div>
								</div>
                                <input type="hidden" name="sub_category_name" id="sub_category_name" />
                                <input type="hidden" name="category_name" id="category_name" />
							</form>
        </div><!-- COL END -->
        <!--  End Content -->

    </div>
</div>

@stop
@section('inlinejs')
<script type="text/javascript">
var cnt=0;
            function addMoreProductVariations(){
                cnt++;
                html='';
                html+='<div class="row pb-2 pt-2" id=ROW-'+cnt+'>';
                
                html+='<div class="col-lg-2 col-12">';
                html+='    <label  for="value"><b>Product Weight</b></label>';
                html+='    <input name="product_weight[]" id="product_weight" type="text" required="required" class="form-control"  placeholder="">';
                html+='</div>';
                
                html+='<div class="col-lg-2 col-12">';
                html+='<label  for="value"><b>Mrp Price </b></label>';
                html+='<input name="product_mrp_price[]" id="product_mrp_price"  type="number" required="required" maxlength="12" class="form-control" placeholder="">';
                html+='</div>';
                
                html+='<div class="col-lg-2 col-12">';
                html+='   <label  for="value"><b>Product Price </b></label>';
                html+='   <input name="product_sell_price[]" id="product_sell_price" type="number" required="required" maxlength="12" class="form-control"  placeholder="">';
                html+='</div>';
                
                html+='<div class=" col-lg-2 col-12">';
                html+='     <label  for="value"><b>Product  Qty</b></label>';
                html+='     <input name="product_total_qty[]" id="product_total_qty" type="number" required="required" maxlength="12" class="form-control"  placeholder="">';
                html+='</div>';
                
                
                html+='<div class="col-lg-3 col-12">';
                html+='    <label  for="value"><b>Product Image</b></label>';
                html+='    <input  name="product_image[]" id="product_image" type="file" class="form-control">';
                html+='</div>';
                
                html+='<div class="col-lg-1 col-12 d-flex align-items-center ">';
                html+='     <button onclick="RemoveMoreProductVariations('+cnt+')" type="button" class="btn btn-danger mt-2"><i class="fa fa-trash"></i></button>';
                html+='</div>';
                html+='</div>';

                $("#productText").append(html);
            }

            function RemoveMoreProductVariations(id){$("#ROW-"+id).remove();}
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#icon_image_select').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            $('.js-example-basic-multiple').select2();
   $('.Description').summernote({ height:250 });
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
						var btn = '<a href="{{route('product-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Create product', data.msg, btn);
                        $('#submitForm')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Create product','Input error');
                    }
                    buttonLoading('reset', $this);

                },
                error: function() {
                    errorMsg('Create product', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });


    </script>
@stop
