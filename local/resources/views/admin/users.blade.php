@extends('layouts.master')

@section('title')
Admin - Users
@endsection

@section('content')


    <div class="col-md-8 col-md-offset-2 pad-panel">
        <div class="panel panel-info">
            <div class="panel-heading">       
                <h4 class="dark_blue upper_case"> User Manager - Active User List ({{count($users)}}) </h4>
                    
            </div>
            <div class="panel-body">        
                <table class="table table-striped table-responsive">        
        <tbody>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email Address</th>
            <th>Access Level</th>
            <!-- <th>Finished Tasks</th> -->
            <th></th>
        </tr>
        @foreach($users as $user)
            <col width="">
            <col width="">
            <col width="">
            <col width="">
            <col width="">
            <col width="">
            
            <tr>
                <td class="table-text"><div>@if($user->firstname == "") -- @else {{$user->firstname}} @endif </div></td>
                <td class="table-text"><div>@if($user->lastname == "") -- @else {{$user->lastname}} @endif </div></td>
                <td class="table-text"><div>{{ $user->email }}</div></td>
                <td class="table-text"><div>{{ $user->role }}</div></td>
                <td class="">
                    <div class="b-inline"> 
                        <a href="{{route('user.edit', ['id' => $user->id])}}">
                            <button class="btn btn-edit"><i class="fa fa-pencil-square">                        
                        </i> Edit User </button>
                        </a>
                    </div>
                
                    <div class="b-inline">                         
                            <button class="btn btn-danger" ng-click="open('delete_user',{{$user->id}})"><i class="fa fa-trash"></i> Delete User </button>
                    </div>
                </td>
                
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
            </div>
        </div>
    </div>  
<!-- modal form for delete confirmation -->
<script type="text/ng-template" id="delete_user.html">       
    <div class="modal-header">              
        <h4 class="modal-title danger">Delete User</h4>
    </div>
    <div class="modal-body">
        <p class="danger"> Are you sure you want to delete this user?</p>
        
    </div>
    <div class="modal-footer">              
        <button class="btn btn-primary" type="button" ng-click="delete_user()">Yes</button>
        <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
    </div>      
</script>
@endsection