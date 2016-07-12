@extends('layouts.master')

@section('title')
Admin - Tasks
@endsection

@section('content')
<?php
use App\User;
?>
@if (!$tasks->count())
	<div class="col-md-8 col-md-offset-2 pad-panel">
		<div class="panel panel-info">
	  		<div class="panel-heading"> 	  
		  		<h4 class="dark_blue upper_case"> All Tasks </h4>
		  			
		  	</div>
		  <div class="panel-body">		  		
				<h4> There are no tasks so far. Create an admin task 
					<a href="{{route('tasks.create')}}">
						<button class="btn btn-success"> HERE </button>
					</a>
				</h4>				
		  </div>
	  	</div>
  	</div>
	
@else
<div class="col-md-10 col-md-offset-1 pad-panel" >
	@if (session('success'))
      	<div class="alert alert-success">
        	{{ session('success') }}
      	</div>
  	@endif
	<div class="panel panel-info">
	  	<div class="panel-heading">
	  		<div class="row">
	  			<div class="col-sm-8"><h4 class="dark_blue upper_case"> Task Manager - All Tasks ( {{count($tasks)}} )</h4></div>
	  			<div class="col-sm-2">
	  				<a href="{{route('tasks.create')}}">
						<button class="btn btn-success" style="margin-top: 5px;"><i class="fa fa-plus">						
						</i> Add New Task </button>
					</a> 
				</div>
	  			<div class="col-sm-2">
	  				<a href="{{route('download-excel-b')}}">
						<button class="btn btn-warning" style="margin-top: 5px;"><i class="fa fa-download">						
						</i> Download as CSV </button>
					</a>
					<a href="{{route('download-xml-b')}}">
						<button class="btn btn-warning" style="margin-top: 5px;"><i class="fa fa-download">						
						</i> Download as XML </button>
					</a>
	  			</div>
	  		</div>	
	  	</div>

	  <div class="panel-body">
	  <table class="table table-striped table-responsive fixed-table">        
        <tbody>
        <tr>
        	<th>Name</th>
        	<th>Description</th>
        	<th>State</th>
        	<th>Owner</th>
        	<th>Created On</th>
        	<th>Last Updated On</th>
        	<th></th>
        </tr>
		@foreach($tasks as $task)
			<col width="">
  			<col width="">
  			<col width="">
  			<col width="">
  			<col width="">
  			<col width="">
  			
			<tr>
                <td class="table-text"><div>{{ $task->name }}</div></td>
                <td class="table-text"><div>{{ $task->description }}</div></td>
                <td class="table-text"><div>{{ $task->state }}</div></td>
                <td class="table-text"><div>{{ User::getName($task->user_id) }}</div></td>
                <td class="table-text"><div>{{date('jS M Y H:i', strtotime($task->created_at))}}</div></td>
				<td class="table-text"><div>{{date('jS M Y H:i', strtotime($task->updated_at))}}</div></td>
                <td class="">
                	<div class="b-inline"> 
                		<a href="{{route('task.edit', ['id' => $task->id])}}">
							<button class="btn btn-edit"><i class="fa fa-pencil-square">						
						</i> Edit</button>
						</a>
					</div>
				
                	<div class="b-inline"> 
                		{{-- <a href="{{route('tasks.destroy', ['id' => $task->id])}}"> --}}
							<button class="btn btn-danger" ng-click="open('delete',{{$task->id}})"><i class="fa fa-trash"></i> Delete</button>
						{{-- </a> --}}
					</div>
				
                	<div class="b-inline">                 		
							<button class="btn btn-info" ng-click="open('edit',{{$task->id}})"><i class="fa fa-pencil-square-o"></i> Change State </button>
					</div>
				</td>
				
            </tr>
		@endforeach
		</tbody>
	</table>
		{{ $tasks->links() }}
	</div>
</div>
<div class="clearfix"></div>

<!-- modal form for changing task state via ajax -->
<script type="text/ng-template" id="changestate.html">		
	<div class="modal-header">				
		<h4 class="modal-title">Change Task State</h4>
	</div>
	<div class="modal-body">
		<form name="formTasks" class="form-horizontal" novalidate="">

			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Choose New Task State &nbsp;<i class="fa fa-caret-right"></i></label>
				<div class="col-sm-4">
					<select name="selector" id="tstates" class="form-control tstates" ng-model="stateoptions" ng-options="x.state for x in taskStates">
					</select>							
				</div>
			</div>

		</form>
		
	</div>
	<div class="modal-footer">				
		<button class="btn btn-primary" type="button" ng-click="submit()">Submit</button>
    	<button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
	</div>		
</script>

<!-- modal form for delete confirmation -->
<script type="text/ng-template" id="delete.html">		
	<div class="modal-header">				
		<h4 class="modal-title danger">Delete Task</h4>
	</div>
	<div class="modal-body">
		<p class="danger"> Are you sure you want to delete this task?</p>
		
	</div>
	<div class="modal-footer">				
		<button class="btn btn-primary" type="button" ng-click="delete()">Yes</button>
    	<button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
	</div>		
</script>
@endif
@endsection