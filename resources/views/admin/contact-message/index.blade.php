@extends('admin.layouts.master')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Social Links') }}</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>{{ __('All Social Links') }}</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.social-link.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> {{ __('Create new') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-striped" id="table-sub">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Subject') }}</th>
                                <th>{{ __('Message') }}</th>
                                <th>{{ __('Replied') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($messages as $message)
                            <tr>
                                <td>{{$message->id}}</td>
                                <td>{{$message->email}}</td>
                                <td>{{$message->subject}}</td>
                                <td>{{$message->message}}</td>
                                <td>
                                    @if ($message->replied == 1)
                                    <i style="font-size:20px" class="fas fa-check text-success"></i>
                                    @else
                                    <i style="font-size:20px" class="fas fa-clock text-warning"></i>
                                    @endif

                                </td>
                                <td>

                                    <a href=""
                                        class="btn btn-primary"><i
                                        class="fas fa-envelope"></i></a>
                                    <a href="{{ route('admin.social-link.destroy', $message->id) }}"
                                        class="btn btn-danger delete-item"><i
                                            class="fas fa-trash-alt"></i></a>

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
            $("#table-sub").dataTable({
                "columnDefs": [{
                    "sortable": false,
                    "targets": [2, 3]
                }]
            });

    </script>
@endpush
