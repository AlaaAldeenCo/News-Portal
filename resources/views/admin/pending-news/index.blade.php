@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('admin.All Pending News') }}</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('admin.Pending News') }}</h4>
            </div>

            {{-- <div class="card-body">
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

                        </div>
                    @endforeach

                </div>
            </div> --}}
            @php
                    if(canAccess(['news all-access']))
                    {
                        $news = \App\Models\News::with('category')
                            ->where('is_approved', 0)
                            ->orderBy('id', 'DESC')
                            ->get();
                    }

                    else
                    {
                        $news = \App\Models\News::with('category')
                            ->where('is_approved', 0)
                            ->where('auther_id', auth()->guard('admin')->user()->id)
                            ->orderBy('id', 'DESC')
                            ->get();
                    }

                @endphp
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th>{{ __('admin.Image') }}</th>
                                <th>{{ __('admin.Title') }}</th>
                                <th>{{ __('admin.Category') }}</th>
                                <th>{{ __('admin.Approve') }}</th>
                                <th>{{ __('admin.Action') }}</th>
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
                                        <form action="" id="approve_form">
                                            <input type="hidden" value="{{$item->id}}" name="id">
                                            <div class="form-group">
                                                <select name="is_approved" class="form-control" id="approve-input">
                                                    <option value="0">{{__('admin.Pending')}}</option>
                                                    <option value="1">{{__('admin.Approved')}}</option>
                                                </select>
                                            </div>
                                        </form>
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
    </section>
@endsection

@push('scripts')
    <script>

            $("#table").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2, 3]
                }],
                "order":[
                    [0, 'desc']
                ]
            });


        $(document).ready(function(){

            $('#approve-input').on('change', function(){
                $('#approve_form').submit();
            });

            $('#approve_form').on('submit', function(e){
                e.preventDefault();
                let data = $(this).serialize();
                $.ajax({
                    mehod: 'PUT',
                    url: "{{route('admin.approve.news')}}",
                    data: data,
                    success: function(data){
                        if(data.status === 'success')
                        {
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            })
                            window.location.reload();
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
