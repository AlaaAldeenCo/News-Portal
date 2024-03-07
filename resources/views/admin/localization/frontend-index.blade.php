@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Frontend Localization') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('All Strings') }}</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.category.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> {{ __('Create new') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                    @foreach ($languages as $language)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->index === 0 ? 'active' : '' }}" id="home-tab2" data-toggle="tab"
                                href="#home-{{ $language->lang }}" role="tab" aria-controls="home"
                                aria-selected="true">{{ $language->name }}</a>
                        </li>
                    @endforeach

                </ul>
                <div class="tab-content tab-bordered" id="myTab3Content">
                    @foreach ($languages as $language)

                        <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                            id="home-{{ $language->lang }}" role="tabpanel" aria-labelledby="home-tab2">
                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <form action="{{route('admin.extract-localize-string')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="directory" value="{{resource_path('views/frontend')}}">
                                                <input type="hidden" name="language_code" value="{{$language->lang}}">
                                                <input type="hidden" name="file_name" value="frontend">
                                                <button type="submit" class="btn btn-primary mx-3">{{__('Generate Strings')}}</button>
                                            </form>

                                            <form action="{{route('admin.translate-string')}}" class="translate-from" method="POST">
                                                @csrf
                                                <input type="hidden" name="language_code" value="{{$language->lang}}">
                                                <input type="hidden" name="file_name" value="frontend">
                                                <button type="submit" class="btn btn-dark mx-3">{{__('Translate Strings')}}</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-{{ $language->lang }}">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>{{ __('String') }}</th>
                                                <th>{{ __('Translation') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $translatedValues = trans('frontend', [], $language->lang);
                                        @endphp
                                        <tbody>
                                            @foreach ($translatedValues as $key => $value)
                                                <tr>
                                                    <td>{{ ++$loop->index}}</td>
                                                    <td>{{ $key }}</td>
                                                    <td>{{ $value }}</td>
                                                    <td>
                                                        <button
                                                            data-langcode="{{$language->lang}}"
                                                            data-key = "{{$key}}"
                                                            data-value="{{ $value }}"
                                                            data-filename="frontend"
                                                            type="button" class="btn btn-primary modal_btn"
                                                            data-toggle="modal" data-target="#exampleModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>


                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>


        </div>
    </section>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('admin.Value') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.update-lang-string')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">{{ __('Value') }}</label>
                        <input type="text" name="value" class="form-control" value="">
                        <input type="hidden" name="lang_code" class="form-control">
                        <input type="hidden" name="key" class="form-control">
                        <input type="hidden" name="file_name" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        @foreach ($languages as $language)
            $("#table-{{ $language->lang }}").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2, 3]
                }],

            });
        @endforeach

        $(document).ready(function(){
            $(".modal_btn").on('click', function(){
                let langcode = $(this).data('langcode');
                let key = $(this).data('key');
                let value = $(this).data('value');
                let filename = $(this).data('filename');

                $('input[name="lang_code"]').val("");
                $('input[name="key"]').val("");
                $('input[name="value"]').val("");
                $('input[name="file_name"]').val("");

                $('input[name="lang_code"]').val(langcode);
                $('input[name="key"]').val(key);
                $('input[name="value"]').val(value);
                $('input[name="file_name"]').val(filename);
            })

            $('.translate-from').on('submit', function(e){
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    method: "POST",
                    url: "{{route('admin.translate-string')}}",
                    data: formData,
                    success: function(data){
                        console.log(data);
                    },

                    error: function(data){
                        console.log(data);
                    }

                })
            })

        })
    </script>
@endpush