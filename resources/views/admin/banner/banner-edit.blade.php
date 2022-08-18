@extends('admin/layouts/default')
@section('title')
<title>Edit Banner</title>
@stop

@section('inlinecss')

<!-- WYSIWYG EDITOR CSS -->
<link href="{{ asset('admin/assets/plugins/wysiwyag/richtext.css') }}" rel="stylesheet"/>
@stop

@section('breadcrum')
<h1 class="page-title">Edit Banner</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Banner</a></li>
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
										<h3 class="card-title">Banner Forms</h3>
									</div>
									<div class="card-body">
                                    <form id="submitForm"  method="post" action="{{route('banner-update', $post->id)}}">
                                    {{csrf_field()}}
                                    <div class="row">
										<div class="form-group col-sm-6">
											<label class="form-label">Title *</label>
											<input type="text" class="form-control" name="title" id="title" value="{{$post->title}}">
                                        </div>

										<div class="form-group col-sm-6">
											<label class="form-label">Link *</label>
											<input type="text" class="form-control" name="link" id="link" value="{{$post->link}}">
                                        </div>
										<div class="form-group col-sm-6">
											<label class="form-label">Banner</label>
											<input type="file" class="form-control" name="banner" id="banner">
											@if($post->banner)
												<img src="{{$post->banner}}" style="width:200px margin-top:15px; height:200px">
											@endif
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
                        var btn = '<a href="{{route('banner-list')}}" class="btn btn-info btn-sm">GoTo List</a>';
                        successMsg('Update Banner', data.msg, btn);
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
						errorMsg('Edit Banner', 'Input Error');
                    }
                    buttonLoading('reset', $this);

                },
                error: function() {
                    errorMsg('Update banner', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });


    </script>
@stop
