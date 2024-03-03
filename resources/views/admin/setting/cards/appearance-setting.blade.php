<div class="card">
    <div class="card-body card border border-primary">
        <form action="{{route('admin.appearance-setting.update')}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>{{__('Pick Your Color')}}</label>
                <div class="input-group colorpickerinput">
                  <input type="text" class="form-control" name="site_color">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <i class="fas fa-fill-drip"></i>
                    </div>
                  </div>
                </div>
                @error('site_color')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
      </div>
  </div>
