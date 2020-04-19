@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if(isset($user_details_data->id) && !empty($user_details_data->id))
                    @php $etxt = 'Edit User Details' @endphp
                @else
                    @php $etxt = 'Add User Details' @endphp
                @endif
                <div class="card-header">{{ $etxt }}</div>

                <div class="card-body">
                    @if(isset($user_details_data->id) && !empty($user_details_data->id))
                        <form action="{{ route('update',$user_details_data->id) }}" method="POST" enctype="multipart/form-data">
                        @else
                         <form method="POST" action="{{ url('user_details/add') }}" enctype="multipart/form-data">
                    @endif
                        
                        @csrf
                        @if(isset($user_details_data->id) && !empty($user_details_data->id))
                        <input type="hidden" name="eid" id="eid" value="{{$user_details_data->id}}">
                        @endif
                        @if(isset($user_details_data->photo) && !empty($user_details_data->photo))
                        <input type="hidden" name="eimg" id="eimg" value="{{$user_details_data->photo}}">
                        @endif
                        <div class="form-group row">
                            <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}*</label>
                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ isset($user_details_data->first_name)?$user_details_data->first_name:''}}">
                                @if($errors->has('first_name'))
                                    <div class="error">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}*</label>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ isset($user_details_data->last_name)?$user_details_data->last_name:''}}">
                                @if($errors->has('last_name'))
                                    <div class="error">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_name" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}*</label>
                            <div class="col-md-6">
                                <input id="user_name" type="text" class="form-control" name="user_name" value="{{ isset($user_details_data->user_name)?$user_details_data->user_name:''}}">
                                @if($errors->has('user_name'))
                                    <div class="error">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}*</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ isset($user_details_data->email)?$user_details_data->email:''}}">
                                @if($errors->has('email'))
                                    <div class="error">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile') }}*</label>
                            <div class="col-md-6">
                                <input id="mobile" type="mobile" class="form-control" name="mobile" value="{{ isset($user_details_data->mobile)?$user_details_data->mobile:''}}">
                                @if($errors->has('mobile'))
                                    <div class="error">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="skill" class="col-md-4 col-form-label text-md-right">{{ __('Skill') }}*</label>
                            <div class="col-md-6">
                                @foreach($skill_list as $skill)
                                    @if(isset($user_skills))
                                        {{ Form::checkbox('skill[]', $skill->id,  in_array($skill->id, $user_skills), array('class'=>'')) }} {{$skill->name}}
                                    @else
                                        {{ Form::checkbox('skill[]', $skill->id, null, array('class'=>'')) }} {{$skill->name}}
                                    @endif
                                @endforeach
                                @if($errors->has('skill'))
                                    <div class="error">
                                        <strong>{{ $errors->first('skill') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                            <div class="col-md-6">
                               <div class="radio">
                                  <label><input type="radio" name="gender" value="male" {{(isset($user_details_data->gender)&&$user_details_data->gender=='male')?'checked':''}}>Male</label>
                                
                                  <label><input type="radio" name="gender" value="female" {{(isset($user_details_data->gender)&&$user_details_data->gender=='female')?'checked':''}}>Female</label>
                                </div>
                            </div>
                        </div>                        

                        <div class="form-group row">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('photo') }}</label>
                            <div class="col-md-6">
                                <input type="file" name="photo">
                                @if(isset($user_details_data->photo) && !empty($user_details_data->photo))
                                    <img src="{{Storage::url($user_details_data->photo) }}" width="150" height="150">
                                @endif
                                @if($errors->has('photo'))
                                     <div class="error">
                                        <strong>{{ $errors->first('photo') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                                <a href="/user_details" class="btn btn-danger">
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
