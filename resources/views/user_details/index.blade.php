@extends('layouts.app')
@section('title', 'User Details')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-11">
            <h1>User Details</h1>    
        </div>
        @if($user_count == 0)
            <div class="col-sm-1">
                <a class="btn btn-success" href="user_details/create">Add User Details</a>    
            </div>
        @endif
    </div>
    
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Gender</th>
                <th>Photo</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection
@section('script')
<script src="{{ asset('js/user_details/user_details.js') }}" defer></script>
@endsection
