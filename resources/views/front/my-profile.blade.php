@extends('front.layouts.app')
  @section('content')
    <div class="hero-wrap hero-bread bg-primary" style="background-image: url('images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
            <h1 class="mb-0 bread">My Profile</h1>
          </div>
        </div>
      </div>
    </div><br />

    {{-- <section class="ftco-section"> --}}
      <div class="container-fluid">
        <div class="row ">
          <div class="col-xl-2 ftco-animate">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action bg-primary active  ">Dashboard</a>
                <a href="{{route('my.orders')}}" class="list-group-item list-group-item-action ">My Orders</a>
                <a href="{{route('my.profile')}}" class="list-group-item list-group-item-action">My Profile</a>
                <a href="#" class="list-group-item list-group-item-action disabled">Payment History</a>
              </div>
          </div> <!-- .col-md-8 -->
          <div class="col-xl-10">
            @include('alert')
              <form  action="{{route('update-user',$user->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                    <h3 class="mb-4 text-center billing-heading"></h3>
                        <div class="row align-items-end">

                            <div class="col-md-6">
                                <div class="form-group">
                                     <label for="firstname">Name</label>
                                <input required="required" value="{{$user->name}}" type="text" name="name" class="form-control" placeholder="">
                                 </div>
                             </div>

                             <div class="col-md-6">
                                <div class="form-group">
                                     <label for="firstname">Mobile</label>
                                      <input required="required" value="{{$user->mobile}}" type="text" name="mobile" class="form-control" placeholder="">
                                 </div>
                             </div>
                              <div class="col-md-6">
                                   <div class="form-group">
                                        <label for="firstname">E-mail</label>
                                         <input required="required" value="{{$user->email}}" type="text" name="email" class="form-control" placeholder="">
                                    </div>
                                </div>



                                 <div class="col-md-6">
                                     <div class="form-group row">
                                         <div class="col-9">
                                         <label for="lastname">Profile</label>
                                             <input onchange="readURL(this, 'FileImg');" type="file"  name="profile" class="form-control" placeholder="">
                                         </div>
                                         <div class="col-3">
                                            <img id="FileImg" src="{{url(''.$user->profile_pic)}}"  style="width: 80px;height:80px;"/>
                                         </div>
                                      </div>
                                 </div>

                                 <div class="col-md-6">
                                    <label for="firstname">Gender</label>
                                      <div class="form-group ">
                                       <div class="custom-control custom-radio custom-control-inline">
                                           <input  type="radio" class="custom-control-input" id="female" name="gender" @if($user->gender=='male') {{"checked='checked'"}} @endif value="male">
                                           <label class="custom-control-label" for="female">Male</label>
                                       </div>
                                       <div class="custom-control custom-radio custom-control-inline">
                                           <input type="radio" class="custom-control-input" id="male" name="gender" @if($user->gender=='female'){{"checked='checked'"}} @endif  value="female">
                                           <label class="custom-control-label" for="male">FeMale</label>
                                       </div>
                                    </div>
                                  </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <input style="border-radius:2px; color:white!important;" type="submit"  value="Submit" class="btn btn-primary  p-3" placeholder="">
                                        </div>
                                    </div>
                        </div>
                        <input type="hidden" name="old_image" id="old_image" value="{{url('/'.$user->profile_pic)}}" />
                    </form>
          </div>
        </div>
      </div>
    {{-- </section> <!-- .section --> --}}
    <script>
        function readURL(input, imgId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#' + imgId).attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

