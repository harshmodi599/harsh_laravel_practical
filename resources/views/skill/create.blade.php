@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if(isset($skill_data->id) && !empty($skill_data->id))
                          @php $etxt = 'Edit Skill' @endphp
                   @else
                         @php $etxt = 'Add Skill' @endphp
                @endif
                <div class="card-header">{{ $etxt }}</div>

                <div class="card-body">
                    @if(isset($skill_data->id) && !empty($skill_data->id))
                        <form action="{{ route('update',$skill_data->id) }}" method="POST" enctype="multipart/form-data">
                        @else
                        <form method="POST" action="{{ url('skill/add') }}" enctype="multipart/form-data">
                    @endif
                        
                        @csrf
                        @if(isset($skill_data->id) && !empty($skill_data->id))
                        <input type="hidden" name="eid" id="eid" value="{{$skill_data->id}}">
                        @endif
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}*</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ isset($skill_data->name)?$skill_data->name:''}}">

                                @if($errors->has('name'))
                                    <div class="error">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                 @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                                <a href="/skill" class="btn btn-danger">
                                    {{ __('Back') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
