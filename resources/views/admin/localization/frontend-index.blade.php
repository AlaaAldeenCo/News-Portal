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
                                            <button class="btn btn-dark mx-3">{{__('Translate Strings')}}</button>
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
                                                        <a href=""
                                                            class="btn btn-primary"><i class="fas fa-edit"></i></a>


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
@endsection

@push('scripts')
    <script>
        @foreach ($languages as $language)
            $("#table-{{ $language->lang }}").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2, 3]
                }],
                "order":[
                    [0, 'desc']
                ]
            });
        @endforeach
    </script>
@endpush
