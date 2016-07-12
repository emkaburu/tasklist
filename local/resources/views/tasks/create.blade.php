@extends('layouts.master')
@section('title')
  Create New Task
@endsection
@section('content')

<div class="col-md-8 col-md-offset-2 pad-panel">
  <div class="panel panel-info">
    <div class="panel-heading">
      <div class="row">
        <div class="col-sm-6"><h4 class="dark-blue"> Create a new task by filling the form below. </h4></div>
        <div class="col-sm-6">
          <a href="{{route('tasks.index')}}">
          <button class="btn btn-success"> <i class="fa fa-backward"></i> Back to Tasks </button>
        </a>
        </div>
      </div>
    </div>
    <div class="panel-body" style="">
      <form action="{{route('tasks.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data" id="form_create_sale" style="margin: 0 auto; border: 1px solid re">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-md-8 col-md-offset-2">
        <legend style="color: #243EA3"> <i class="fa fa-chevron-down"></i> &nbsp;Task Details:</legend>
          <div class="row" style="border: 1px dotted re; padding-left: 2%; padding-right: 2%">        
            <div class='col-sm-8 col-sm-offset-2'>

              <div class="form-group{{ $errors->has('taskname') ? ' has-error' : '' }}">              
               <label for='taskname' style="margin-top:3px;"> Task Name: </label>
               <input class="form-control" placeholder="" name="taskname" id="taskname" type="text" value="{{ old('taskname') }}"/>
                @if ($errors->has('taskname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('taskname') }}</strong>
                    </span>
                @endif
               <br/>
               </div>
               <div class="form-group">
                 <label for='tdesc'> Task Description</label>
                 <textarea class="form-control" placeholder="" name="tdesc" id="tdesc"></textarea>
               </div>
              
            </div>
          </div> <!-- End row for attributes -->
        </div> <!-- End col-md-8 for attributes -->  

        <div class="form-group">
          <div class='col-sm-8 col-sm-offset-2' style="text-align: center">
            <input type="submit" name='save' class="btn btn-default btn-success" value = "Save Task" />         
          </div>
        </div>
      </form>
    </div>

  </div>
</div>
@endsection
