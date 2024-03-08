@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.News') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('admin.Create News') }}</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="">{{ __('admin.Language') }}</label>
                        <select name="language" id="language-select" class="form-control select2">
                            <option value="">{{ __('admin.Select') }}</option>
                            @foreach ($languages as $lang)
                                <option {{$lang->lang === $news->language ? 'selected': ''}} value="{{ $lang->lang }}">{{ $lang->name }}</option>
                            @endforeach
                        </select>
                        @error('language')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>
                    <div class="form-group">
                        <label for="">{{ __('admin.Category') }}</label>
                        <select name="category" id="category" class="form-control select2">
                            <option value="">{{ __('admin.Select') }}</option>
                            @foreach ($categories as $category)
                            <option {{$category->id == $news->category_id ? 'selected':''}} value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach

                        </select>
                        @error('category')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror

                    </div>

                      <div class="form-group">
                        <label for="">{{ __('admin.Image') }}</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                          </div>
                        @error('image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Title') }}</label>
                        <input name="title" type="text" class="form-control" value="{{$news->title}}">
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">{{ __('admin.Content') }}</label>
                        <textarea class="summernote-simple" name="content">{{$news->content}}</textarea>
                        @error('content')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('admin.Tags') }}</label>
                          <input type="text" name="tags" class="form-control inputtags" value="{{formatTags($news->tags()->pluck('name')->toArray())}}">
                          @error('tags')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                      </div>
                    <div class="form-group">
                        <label for="">{{ __('admin.Meta Title') }}</label>
                        <input name="meta_title" type="text" class="form-control" value="{{$news->meta_title}}">
                        @error('meta_title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('admin.Meta Description') }}</label>
                        <textarea class="form-control" name="meta_description">{{$news->meta_description}}</textarea>
                        @error('meta_description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">{{__('admin.Status')}}</div>
                                <label class="custom-switch mt-2">
                                  <input type="checkbox" name="status" class="custom-switch-input" {{$news->status === 1 ? 'checked':''}} value="1">
                                  <span class="custom-switch-indicator"></span>
                                </label>
                              </div>
                        </div>

                        @if (canAccess(['news status', 'news all-access']))
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">{{__('admin.Is Breaking News')}}</div>
                                <label class="custom-switch mt-2">
                                  <input type="checkbox" name="is_breaking_news" class="custom-switch-input" {{$news->is_breaking_news === 1 ? 'checked':''}} value="1">
                                  <span class="custom-switch-indicator"></span>
                                </label>
                              </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">{{__('admin.Show At Slider')}}</div>
                                <label class="custom-switch mt-2">
                                  <input type="checkbox" name="show_at_slider" class="custom-switch-input" {{$news->show_at_slider === 1 ? 'checked':''}} value="1">
                                  <span class="custom-switch-indicator"></span>
                                </label>
                              </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="control-label">{{__('admin.Show At Popular')}}</div>
                                <label class="custom-switch mt-2">
                                  <input type="checkbox" name="show_at_popular" class="custom-switch-input" {{$news->show_at_popular === 1 ? 'checked':''}} value="1">
                                  <span class="custom-switch-indicator"></span>
                                </label>
                              </div>
                        </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('admin.Update') }}</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')

<script>
    $(document).ready(function(){
        $('#language-select').on('change', function(){
            let lang = $(this).val()
            $.ajax({
                method: 'GET',
                url:"{{route('admin.fetch-news-category')}}",
                data: {
                    lang: lang
                },
                success: function(data)
                {
                    $('#category').html('')
                    $('#category').html(`<option value="">{{ __('admin.Select') }}</option>`)
                    $.each(data,function(index, data){
                        $('#category').append(`<option value="${data.id}">${data.name}</option>`)
                    })
                },
                error: function(error)
                {
                    console.log(error);
                }
            })
        })
    })
</script>

<script>
    $(document).ready(function(){
        $('.image-preview').css({
            "background-image": "url({{ asset($news->image) }})",
            "background-size": "cover",
            "background-position": "center center"
        });
    })
</script>

@endpush
