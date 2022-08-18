{{-- <!DOCTYPE html>--}}
{{-- <html>
<head>
	<title>Laravel 6 - Google Recaptcha Code with Validation - ItSolutionStuff.com</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	 {!! NoCaptcha::renderJs() !!}
</head>
<body> --}}

{{--<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary"> --}}
                {{-- <div class="panel-heading">Register - ItSolutionStuff.com</div> --}}
                {{-- <div class="panel-body"> --}}
                    {{-- <form class="form-horizontal" role="form" method="POST" action="{{ url('/site-register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Captcha</label>
                            <div class="col-md-6">
                                {!! app('captcha')->display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <br/>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Register
                                </button>
                            </div>
                        </div>
                    </form> --}}
{{--
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html> --}}
<html>
<head>
	<title>Laravel 6 - Google Recaptcha Code with Validation - ItSolutionStuff.com</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/save-site-register') }}">
        {!! csrf_field() !!}
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-md-offset-2">
                        <div class="panel panel-primary">
                            <div class="panel-heading">EMI Calculation</div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label class="">Oustanding Amount</label>
                                <input value="@if(isset($_POST['outstanding_amt'])){{$_POST['outstanding_amt']}}@endif" type="text" class="form-control" name="outstanding_amt" >
                            </div>
                                <div class="col-md-2">
                                        <label class="">Reaming Tenure(Time)</label>
                                        <input type="text" class="form-control" name="time" value="@if(isset($_POST['time'])){{$_POST['time']}}@endif" />
                                </div>

                            <div class="col-md-2">
                                <label class="">Extend Month</label>
                                    <select class="form-control" onchange="setPrinciple(this)" name="exttenure">
                                        <option value="">Select</option>
                                        <option value="1" @if(isset($_POST['exttenure']) && $_POST['exttenure']==1){{'selected'}}@endif >1</option>
                                        <option value="2" @if(isset($_POST['exttenure']) && $_POST['exttenure']==2){{'selected'}}@endif>2</option>
                                    </select>
                            </div>

                            <div class="col-md-2">
                                <label class="">Rate</label>
                                    <input type="text" class="form-control" name="rate" value="@if(isset($_POST['rate'])){{$_POST['rate']}}@endif" >
                            </div>

                            <div class="col-md-2"><br />
                                 <input type="submit" class="btn btn-primary"  >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

<div class="p-5 pl-0">
    <div class="row">
        <div class="col-3"> @if(isset($data)) <p  id="data">Principle 3:</p>  {{$data}}@endif </div>
    </div>
</div>
<script>

function setPrinciple(thisObj){
    var exttenure=thisObj.value;
    $("#data").html('Principle '+exttenure+' :');
}

</script>
