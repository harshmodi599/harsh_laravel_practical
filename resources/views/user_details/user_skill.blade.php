@extends('layouts.app')
@section('title', 'Index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-11">
            <h1>User Skills</h1>    
        </div>
    </div>
    
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Gender</th>
                <!-- <th>Photo</th> -->
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection
@section('script')
<script src="{{ asset('js/user_details/user_skill.js') }}" defer></script>
@endsection
