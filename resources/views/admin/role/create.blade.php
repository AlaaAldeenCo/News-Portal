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
                <form action="{{ route('admin.social-count.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">{{ __('Role Name') }}</label>
                        <input type="text" name="role" id="" class="form-control">

                        @error('language')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <hr>

                    {{-- <div class="form-group">
                        <div class="control-label">Toggle switch single</div>
                        <label class="custom-switch mt-2">
                          <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                          <span class="custom-switch-indicator"></span>
                          <span class="custom-switch-description">I agree with terms and conditions</span>
                        </label>
                    </div> --}}
                    <div class="form-group">
                        <h6>Permissions Category</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Category Index</span>
                                </label>
                            </div>

                            <div class="col-md-3">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Category Create</span>
                                </label>
                            </div>

                            <div class="col-md-3">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Category Update</span>
                                </label>
                            </div>

                            <div class="col-md-3">
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Category Delete</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection
