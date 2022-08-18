@extends('admin/layouts/default')
@section('title')
<title>Edit Testimonial</title>
@stop

@section('inlinecss')
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link href="{{ asset('admin/assets/multiselectbox/css/ui.multiselect.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Edit Testimonial</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Testimonial</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
</ol>
@stop

@section('content')
<div class="app-content">
    <div class="side-app">

        <!-- PAGE-HEADER -->
        @include('admin.layouts.pagehead')
        <!-- PAGE-HEADER END -->

        <!--  Start Content -->
    <form id="submitForm" class="row"  method="post" action="{{route('testimonial-update', $testedit->id)}}">
        {{csrf_field()}}
        <!-- COL END -->
							<div class="col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Testimonial Forms</h3>
									</div>
									<div class="card-body">


                                        <div class="form-group">
											<label class="form-label">Heading *</label>
                                        <input type="text" class="form-control" value="{{$testedit->heading}}" name="heading" id="heading" placeholder="Heading..">
										</div>

										<div class="form-group">
											<label class="form-label">Title *</label>
											<input type="text" class="form-control"  value="{{$testedit->title}}" name="title" id="title" placeholder="Title..">
										</div>

                                        <div class="form-group">
                                            <label  for="value"><b>Description</b></label>
                                                <textarea maxlength="55" class="form-control Description" name="desc" id="desc">{{$testedit->desc}}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label"> Image </label>
                                            <div class="row">
                                                <div class="col-md-10 ">
                                                    <input id="image" type="file" class="form-control align-middle custom-file-input" name="image" onchange="readURL(this, 'FileImg');">
                                                    <label class="text-dark mt-4 ml-2 custom-file-label" for="value">Choose file</label>
                                              </div>
                                                <div class="col-md-2 ">
                                                <img id="FileImg" src="@if(!empty($testedit->image)){{url($testedit->image)}}@else{{url('/notfound.png')}}@endif" style="width: 100px;height: 100px">
                                                </div>
                                            </div>
                                         </div>

                                       <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>
										</div>
									</div>
								</div>
                                <input type="hidden" name="old_image" value="{{$testedit->image}}" id="old_image" />
							</form>
        </div><!-- COL END -->
        <!--  End Content -->

    </div>
</div>

@stop
@section('inlinejs')
    <script type="text/javascript">
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
						var btn = '<a href="{{route('testimonial-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Edit Testimonial', data.msg, btn);


                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Edit Testimonial','Input error');
                    }
                    buttonLoading('reset', $this);

                },
                error: function() {
                    errorMsg('Edit Testimonial', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });
		   $("#icon").change(function(){
                readURL(this);
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#icon_image_select').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }


    </script>
@stop
@section('bottomjs')

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script src="{{ asset('admin/assets/multiselectbox/js/ui.multiselect.js') }}"></script>
<script>

$(function () {
  $('#loan_fields').multiselect();
  $("ul.selected li").each(function(){
		var selected_value = $(this).attr('data-selected-value');
		//alert(selected_value);
	});
});
  </script>
@stop
