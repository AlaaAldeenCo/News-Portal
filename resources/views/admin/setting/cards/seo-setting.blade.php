<div class="card">
    <div class="card-body card border border-primary">
        <form action="{{route('admin.seo-setting.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>{{__('Site Seo Title')}}</label>
                <input class="form-control" type="text" name="site_seo_title" value="{{$settings['site_seo_title']}}">
                @error('site_seo_title')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>{{__('Site Seo Description')}}</label>
                <textarea name="site_seo_description" class="form-control" style="height: 300px" id="" cols="30" rows="10">{{$settings['site_seo_description']}}</textarea>
                @error('site_seo_description')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>{{__('Site Seo Keywords')}}</label>
                <input class="form-control inputtags" type="text" name="site_seo_keywords" value="{{$settings['site_seo_keywords']}}">
                @error('site_seo_keywords')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
      </div>
  </div>
