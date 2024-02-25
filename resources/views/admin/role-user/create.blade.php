@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Role And Permissions') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Create Role') }}</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.role-users.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">{{ __('User Name') }}</label>
                        <input type="text" name="name" id="" class="form-control">

                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Email') }}</label>
                        <input type="text" name="email" id="" class="form-control">

                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Password') }}</label>
                        <input type="password" name="password" id="" class="form-control">

                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" id="" class="form-control">

                        @error('password_confirmation')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="">{{ __('Role') }}</label>
                        <select name="role" class="form-control select2">
                            <option value="">{{__('Select')}}</option>
                            @foreach ($roles as $role)
                            <option value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                        </select>

                        @error('role')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
