@extends('admin.layouts.master')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Language</h1>
    </div>
</section>
<div class="card card-primary">
    <div class="card-header">
      <h4>Edit Language</h4>

    </div>
    <div class="card-body">
      <form action="{{route('admin.language.update', $language->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Language</label>
            <select name="lang" id="language-select" class="form-control select2">
                <option value="">Select</option>
                @foreach (config('language') as $key => $lang )
                <option {{$language->lang == $key? 'selected': ''}} value="{{$key}}">{{$lang['name']}}</option>
                @endforeach
            </select>
            @error('lang')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" readonly class="form-control" id="name" name="name" value="{{$language->name}}">
            @error('name')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="form-group">
            <label>Slug</label>
            <input type="text" readonly class="form-control" id="slug" name="slug" value="{{$language->slug}}">
            @error('slug')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="form-group">
            <label>Is it default?</label>
            <select name="default" class="form-control">
                <option {{$language->default == 1? 'selected': ''}} value="1">Yes</option>
                <option {{$language->default == 0? 'selected': ''}} value="0">No</option>
            </select>
            @error('default')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option {{$language->status == 1? 'selected': ''}} value="1">Active</option>
                <option {{$language->status == 0? 'selected': ''}} value="0">Inactive</option>
            </select>
            @error('status')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Edit</button>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(document).ready(function(){
        $('#language-select').on('change', function(){
            let value = $(this).val();
            let name = $(this).children(':selected').text();
            $('#slug').val(value);
            $('#name').val(name);
        })
    })
  </script>
@endpush
