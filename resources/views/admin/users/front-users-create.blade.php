@extends('admin/layouts/default')
@section('title')
<title>Create Front User</title>
@stop

@section('inlinecss')
<link href="{{ asset('admin/assets/multiselectbox/css/multi-select.css') }}" rel="stylesheet">
@stop

@section('breadcrum')
<h1 class="page-title">Create Front Users</h1>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Users</a></li>
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

        <!-- COL END -->
							<div class="col-lg-6">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">User Forms</h3>
									</div>
									<div class="card-body">
                                    <form id="submitForm"  action="{{route('save-front-users')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="form-group row">
                                        <label>Are You Help India Online Member</label>
                                        <select class="form-control" onchange="setField()" name="help_india" id="help_india">
                                            <option >Select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>

                                    <div class="form-group row">
                                        <label>Name</label>
                                       <input name="name" type="text" class="form-control" required="required" >
                                       @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label>E-mail</label>
                                        <input name="email"  type="email" class="form-control"  required="required">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label>Mobile</label>
                                        <input name="mobile" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control"  required="required">
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <label>Paaword</label>
                                        <input name="password" minlength="6"  type="text" class="form-control"  required="required">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row d-none"  id="help_india_div">
                                        <label>Help India ID</label>
                                        <input id="help_india_id"  name="help_india_id"  oninput="this.value = this.value.replace(/[^0-9 A-Z a-z]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control"  >
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                        <div class="card-footer"></div>
                                            <button type="submit" id="submitButton" class="btn btn-primary float-right"  data-loading-text="<i class='fa fa-spinner fa-spin '></i> Sending..." data-rest-text="Create">Create</button>

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
<script src="{{ asset('admin/assets/multiselectbox/js/jquery.multi-select.js') }}"></script>
    <script type="text/javascript">
   function setField(){
       var vla= $("#help_india option:selected").val();
        if(vla=='yes'){
            $("#help_india_div").removeClass('d-none');
            $("#help_india_id").attr('required','required');
        }
        else
        {
            $("#help_india_id").removeAttr('required');
            $("#help_india_div").addClass('d-none');
        }
    }
        $(function () {
            $('#roles').multiSelect();
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

                        successMsg('Create User', 'User Created...');
                        $('#submitForm')[0].reset();

                    }else{
                        $.each(data.errors, function(fieldName, field){
                            $.each(field, function(index, msg){
                                $('#'+fieldName).addClass('is-invalid state-invalid');
                               errorDiv = $('#'+fieldName).parent('div');
                               errorDiv.append('<div class="invalid-feedback">'+msg+'</div>');
                            });
                        });
                        errorMsg('Create User','Input error');
                    }
                    buttonLoading('reset', $this);

                },
                error: function() {
                    errorMsg('Create User', 'There has been an error, please alert us immediately');
                    buttonLoading('reset', $this);
                }

            });

            return false;
           });

           });

       function getPassword(){
           pass=  Math.random().toString(36).slice(-8);
           $('#password').val(pass);
       }
    </script>
@stop
