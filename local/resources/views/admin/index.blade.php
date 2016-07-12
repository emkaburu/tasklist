@extends('layouts.master')

@section('title')
Admin - Home
@endsection

@section('content')


	<div class="col-md-8 col-md-offset-2 pad-panel">
		<div class="panel panel-info">
	  		<div class="panel-heading"> 	  
		  		<h4 class="dark_blue upper_case"> My Tasks </h4>
		  			
		  	</div>
		  	<div class="panel-body">	  	
			  	<div class="row" class="panels">
					<a href="{{url('admin/users')}}">
					<div class="col-md-4 col-md-offset-2 color-panel col-sm-5 col-sm-offset-1">
						 <h4><i class="fa fa-group fa-2x"></i> Users: {{$users}}</h4>
					</div>
					</a>
					
					<a href="{{url('admin/tasks')}}">
					<div class="col-md-4 col-md-offset-1 color-panel col-sm-5 col-sm-offset-1">
						 <h4><i class="fa fa-tasks fa-2x"></i>  Tasks: {{$tasks}} </h4>
					</div>
					</a>
				</div>
			</div>
  		</div>
  	</div>	

@endsection