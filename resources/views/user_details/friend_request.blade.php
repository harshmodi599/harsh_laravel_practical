@extends('layouts.app')
@section('title', 'Request')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-11">
            <h1>Friend Request</h1>    
        </div>
    </div>
    
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Photo</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection
@section('script')
<script src="{{ asset('js/user_details/friend_request.js') }}" defer></script>
@endsection
