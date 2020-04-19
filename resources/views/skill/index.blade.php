@extends('layouts.app')
@section('title', 'Skill')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-11">
            <h1>Skills</h1>    
        </div>
        <div class="col-sm-1">
            <a class="btn btn-success" href="skill/create">Add Skill</a>    
        </div>
    </div>
    
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection
@section('script')
<script src="{{ asset('js/skill/skill.js') }}" defer></script>
@endsection
