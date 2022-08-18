@extends('admin/layouts/default')
@section('title')
<title>Edit Blog</title>
@stop

@section('inlinecss')

<!-- WYSIWYG EDITOR CSS -->
<link href="{{ asset('admin/assets/plugins/wysiwyag/richtext.css') }}" rel="stylesheet"/>
@stop

@section('breadcrum')
<h1 class="page-title">Edit Blog</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Blog</a></li>
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

        <!-- COL END -->
							<div class="col-lg-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Blog Forms</h3>
									</div>
									<div class="card-body">
                                    <form id="submitForm"  method="post" action="{{route('blog-update', $post->id)}}">
                                    {{csrf_field()}}
                                    <div class="row">
										<div class="form-group col-sm-12 col-lg-12 col-md-12 col-12">
											<label class="form-label">Title *</label>
											<input type="text" onkeyup="convertToSlug(this)" class="form-control" name="title" id="title" value="{{$post->title}}">
                                        </div>
                                        <div class="form-group col-sm-12 col-lg-12 col-md-12 col-12">
											<label class="form-label">Slug </label>
											<input type="text" readonly="readonly"  value="{{$post->slug}}" class="form-control" name="slug" id="slug">
                                        </div>
										<div class="form-group col-sm-12 col-lg-12 col-md-12 col-12">
											<label class="form-label">Blog Image</label>
                                            <input type="file" class="form-control" name="image" id="image">
                                        </div>
                                        <div class="form-group col-sm-2">
											@if($post->image)
												<img src="{{url('/public/'.$post->image)}}" style="width:100px;height:100px">
											@endif
                                        </div>

                                       <div class="form-group col-sm-12">
                                            <label  for="value"><b>Description</b></label>
                                       <textarea class="Description" name="description" id="description">{{$post->description}}</textarea>
                                        </div>

                                        <div class="form-group col-sm-6">
											<label class="form-label">Status</label>
											<select name="status" id="status" class="form-control custom-select">
												<option @if($post->status == 1) selected @endif value="1">Active</option>
												<option @if($post->status == 0) selected @endif value="0">InActive</option>
											</select>
                                        </div>

                                    </div>


                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Update">Update</button>
                                        </div>
                                            <input type="hidden" name="old_image" id="old_image" value="{{$post->image}}"/>
                                        </form>
									</div>

								</div>
							</div><!-- COL END -->

        <!--  End Content -->

    </div>
</div>

@stop
@section('inlinejs')

<script src="{{ asset('admin/assets/plugins/wysiwyag/jquery.richtext.js') }}"></script>
    <script type="text/javascript">
  $('.Description').summernote({ height:250 });
        function convertToSlug(TextObj){ $("#slug").val(TextObj.value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-'));}
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
                        var btn = '<a href="{{route('blog-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Update Blog', data.msg, btn);
						window.location.reload();
                        //$('#submitForm')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
						errorMsg('Edit Blog', 'Input Error');
                    }
                    buttonLoading('reset', $this);

                },
                error: function() {
                    errorMsg('Update Blog', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });


    </script>
@stop
