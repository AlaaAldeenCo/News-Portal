@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.Role User') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('admin.Update User') }}</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.role-users.update', $admin->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">{{ __('admin.User Name') }}</label>
                        <input type="text" name="name" id="" class="form-control" value="{{$admin->name}}">

                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Email') }}</label>
                        <input type="text" name="email" id="" class="form-control" value="{{$admin->email}}">

                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Password') }}</label>
                        <input type="password" name="password" id="" class="form-control">

                        @error('password')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Confirm Password') }}</label>
                        <input type="password" name="password_confirmation" id="" class="form-control">

                        @error('password_confirmation')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Role') }}</label>
                        <select name="role" class="form-control select2">
                            <option value="">{{__('admin.Select')}}</option>
                            @foreach ($roles as $role)
                            <option {{$admin->getRoleNames()->first() === $role->name ? 'selected' : ''}} value="{{$role->name}}">{{$role->name}}</option>
                            @endforeach
                        </select>

                        @error('role')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('admin.Update') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
