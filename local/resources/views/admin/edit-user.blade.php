@extends('layouts.master')
@section('title')
  Edit User
@endsection
@section('content')

<div class="col-md-8 col-md-offset-2 pad-panel">
  @if (session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
  @endif
  <div class="panel panel-info">
    <div class="panel-heading">
      <div class="row">
        <div class="col-sm-6"><h4 class="dark-blue"> Edit user details below. </h4></div>
        <div class="col-sm-6">
          <a href="{{route('users')}}">
          <button class="btn btn-success"> <i class="fa fa-backward"></i> Back to Users </button>
        </a>
        </div>
      </div>      
    </div>

    <div class="panel-body" style="">
      <form action="{{route('user.update')}}" method="post" class="form-horizontal" enctype="multipart/form-data" id="form_create_sale">
        <input type="hidden" name="uid" value="{{$user->id}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-md-8 col-md-offset-2">
        <legend style="color: #243EA3"> <i class="fa fa-chevron-down"></i> &nbsp;User Details:</legend>
          <div class="row" style="padding-left: 2%; padding-right: 2%">        
            <div class='col-sm-8 col-sm-offset-2'>

              <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">              
                <label for='firstname' style="margin-top:3px;"> First Name: </label>
                <input class="form-control" placeholder="" name="firstname" id="firstname" type="text" value="{{$user->firstname}}"/>
                @if ($errors->has('firstname'))
                  <span class="help-block">
                    <strong>{{ $errors->first('firstname') }}</strong>
                  </span>
                @endif
               </div>

               <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">              
                <label for='lastname' style="margin-top:3px;"> Last Name: </label>
                <input class="form-control" placeholder="" name="lastname" id="lastname" type="text" value="{{$user->lastname}}"/>
                @if ($errors->has('lastname'))
                  <span class="help-block">
                    <strong>{{ $errors->first('lastname') }}</strong>
                  </span>
                @endif
               </div>
               
               <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">              
                <label for='email' style="margin-top:3px;"> Email Address: </label>
                <input class="form-control" placeholder="" name="email" id="email" type="text" value="{{$user->email}}"/>
                @if ($errors->has('email'))
                  <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif          
               </div>
               
               <div class="form-group">
                <label for=''> Access Level: </label>
                <select class="form-control" name="role">
                 <option @if($user->role == "regular") selected @endif >regular</option>
                 <option @if($user->role == "admin") selected @endif >admin</option>
                </select> 
              </div>
              
            </div>
          </div> <!-- End row for attributes -->
        </div> <!-- End col-md-8 for attributes -->  

        <div class="form-group">
          <div class='col-sm-8 col-sm-offset-2' style="text-align: center">
            <input type="submit" name='update' class="btn btn-default btn-success" value = "Update User Details" />         
          </div>
        </div>
      </form>
    </div>

  </div>
</div>
@endsection
