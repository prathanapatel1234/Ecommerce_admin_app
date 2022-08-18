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
        @include('admin.layouts.pagehead')
        <form id="submitForm" class="row"  method="post" action="{{route('bulk-product')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <!-- COL END -->
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Product Forms</h3>
						</div>
						
						<div class="card-body">
                         
                         <div class="form-group col-12  ">
                            <label class="control-label mt-4"> Upload File </label>
                            <div class="row">
                                <div class="col-md-10 ">
                                    <input id="file" type="file" class="form-control align-middle custom-file-input" name="file" >
                                    <label class="text-dark mt-4 ml-2 custom-file-label" for="image">Choose file</label>
                                    <br /><br />
                              </div>
                            </div>
                         </div>
                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Create">Create</button>
						</div>
					</div>
				</div>
		</form>
      </div><!-- COL END -->
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
                         errorMsg('Create product',data.errors);      
                        if(data.errors.length>0)
                        {
                            $.each(data.errors, function(fieldName, field){
                                $.each(field, function(index, msg){
                                    $('#'+fieldName).addClass('is-invalid state-invalid');
                                   errorDiv = $('#'+fieldName).parent('div');
                                   errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                                });
                            });
                            errorMsg('Create product','Input error');                            
                        }
                        else
                        {
                                                      
                        }

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
