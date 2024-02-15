@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('All Pending News') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('Pending News') }}</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
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
                        @php
                            $news = \App\Models\News::with('category')->where('language', $language->lang)->where('is_approved', 0)
                                ->orderByDesc('id')
                                ->get();
                        @endphp
                        <div class="tab-pane fade show {{ $loop->index === 0 ? 'active' : '' }}"
                            id="home-{{ $language->lang }}" role="tabpanel" aria-labelledby="home-tab2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-{{ $language->lang }}">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    #
                                                </th>
                                                <th>{{ __('Image') }}</th>
                                                <th>{{ __('Title') }}</th>
                                                <th>{{ __('Category') }}</th>
                                                <th>{{ __('Approve') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($news as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td><img src="{{asset($item->image)}}" width="80"></td>
                                                    <td style="width: 90px">{{ $item->title }}</td>
                                                    <td>{{ $item->category->name }}</td>
                                                    <td>
                                                        <label class="custom-switch mt-2">
                                                            <input {{$item->is_breaking_news === 1 ? 'checked':''}} data-id="{{$item->id}}" type="checkbox" data-name="is_breaking_news" class="custom-switch-input toggle-status" >
                                                            <span class="custom-switch-indicator"></span>
                                                          </label>
                                                    </td>
                                                    <td>
                                                        <label class="custom-switch mt-2">
                                                            <input {{$item->show_at_slider === 1 ? 'checked':''}} data-id="{{$item->id}}" type="checkbox" data-name="show_at_slider" class="custom-switch-input toggle-status" >
                                                            <span class="custom-switch-indicator"></span>
                                                          </label>
                                                    </td>
                                                    <td>
                                                        <label class="custom-switch mt-2">
                                                            <input {{$item->show_at_popular === 1 ? 'checked':''}} data-id="{{$item->id}}" type="checkbox" data-name="show_at_popular" class="custom-switch-input toggle-status" >
                                                            <span class="custom-switch-indicator"></span>
                                                          </label>
                                                    </td>
                                                    <td style="width: 30px">
                                                        <label class="custom-switch mt-2">
                                                            <input {{$item->status === 1 ? 'checked':''}} data-id="{{$item->id}}" type="checkbox" data-name="status" class="custom-switch-input toggle-status" >
                                                            <span class="custom-switch-indicator"></span>
                                                          </label>
                                                    </td>


                                                    <td>
                                                        <a href="{{ route('admin.news.edit', $item->id) }}"
                                                            class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                                        <a href="{{ route('admin.news.destroy', $item->id) }}"
                                                            class="btn btn-danger delete-item"><i
                                                                class="fas fa-trash-alt"></i></a>
                                                            <a href="{{ route('admin.news-copy', $item->id) }}"
                                                                class="btn btn-primary"><i class="fas fa-copy"></i></a>
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

        $(document).ready(function(){
            $('.toggle-status').on('click', function(){
                let id = $(this).data('id');
                let name = $(this).data('name');
                let status = $(this).prop('checked') ? 1:0;

                $.ajax({
                    mehod: 'GET',
                    url: "{{route('admin.toggle-news-status')}}",
                    data: {
                        id: id,
                        name: name,
                        status: status
                    },
                    success: function(data){
                        if(data.status === 'success')
                        {
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            })
                        }
                    },
                    error: function(error){
                        console.log(error);
                    }
                })
            })
        })
    </script>
@endpush