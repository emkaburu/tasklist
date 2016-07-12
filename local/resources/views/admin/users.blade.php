@extends('layouts.master')

@section('title')
Admin - Users
@endsection

@section('content')


    <div class="col-md-8 col-md-offset-2 pad-panel">
        <div class="panel panel-info">
            <div class="panel-heading">       
                <h4 class="dark_blue upper_case"> User Manager - User List ({{count($users)}}) </h4>
                    
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
                            <button class="btn btn-danger" ng-click="open('delete',{{$user->id}})"><i class="fa fa-trash"></i> Delete User </button>
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

@endsection