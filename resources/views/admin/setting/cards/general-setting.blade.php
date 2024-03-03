<div class="card">
    <div class="card-body card border border-primary">
        <form action="{{route('admin.general-setting.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>{{__('Site Name')}}</label>

                <input class="form-control" type="text" name="site_name" value="{{$settings['site_name']}}">
            </div>

            <div class="form-group">
                <img src="{{asset($settings['site_logo'])}}" width="150px"><br>
                <label>{{__('Site Logo')}}</label>

                <input class="form-control" type="file" name="site_logo">
            </div>

            <div class="form-group">
                <img src="{{asset($settings['site_favicon'])}}" width="150px"><br>
                <label>{{__('Site Favicon')}}</label>
                <input class="form-control" type="file" name="site_favicon">
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
      </div>
  </div>
