@extends('layouts.master')
@section('title')
  Task List Manager - Home
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading"><h4>Welcome</h4></div>

                <div class="panel-body center-text">
                    <h4>WELCOME TO THE TASKLIST MANAGER. </h4>
                    @if (Auth::guest())
                        <h4>Please <a href="{{ url('/login') }}">Login</a> or <a href="{{ url('/register') }}">Register</a> to proceed.</h4>
                    @elseif(Auth::user()->role == "admin")
                        <h4>CLICK <a href="{{url('admin/home')}}">HERE</a> TO BEGIN.</h4>
                    @elseif(Auth::user()->role == "regular")
                        <h4>CLICK <a href="{{ route('tasks.index') }}">HERE</a> TO BEGIN.</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
