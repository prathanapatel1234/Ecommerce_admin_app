@extends('admin/layouts/default')
@section('title')
<title>Bulk Image Upload</title>
@stop

@section('inlinecss')
<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/themes/ui-lightness/jquery-ui.css" />
<link href="{{ asset('admin/assets/multiselectbox/css/ui.multiselect.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title"> Bulk Image Upload</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"> Bulk </a></li>
    <li class="breadcrumb-item active" aria-current="page">UPload</li>
</ol>
@stop

@section('content')
<div class="app-content">
    <div class="side-app">
        @include('admin.layouts.pagehead')
        <form id="submitForm" class="row"  method="post" action="{{route('move-bulkimage')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <!-- COL END -->
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Image Form</h3>
						</div>
						
						<div class="card-body">
                         
                         <div class="form-group col-12  ">
                            <label class="control-label mt-4"> Upload File </label>
                            <div class="row">
                                <div class="col-md-10 ">
                                 <input type="file" class="form-control align-middle custom-file-input" id="images" name="images[]" onchange="preview_image();" multiple/>
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
						
                        successMsg('Upload Images', data.msg);
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
                    errorMsg('Upload Images', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });


    </script>
@stop
