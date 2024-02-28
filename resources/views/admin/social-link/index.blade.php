@extends('admin.layouts.master')

@section('content')

{{-- <section class="section">
    <div class="section-header">
        <h1>{{ __('Subscribers') }}</h1>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ __('Send Mail To Subscribers') }}</h4>

        </div>

        <div class="card-body">
            <form action="{{route('admin.subscribers.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">{{ __('Subject') }}</label>
                    <input name="subject" type="text" class="form-control" id="name">
                    @error('subject')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">{{ __('Message') }}</label>
                    <textarea class="summernote-simple" name="message"></textarea>
                    @error('message')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">{{__('Send')}}</button>
            </form>
        </div>


    </div>
</section> --}}

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
                                <th>{{ __('Icon') }}</th>

                                <th>{{ __('Url') }}</th>
                                <th>{{ __('Status') }}</th>

                                <th>{{ __('Action') }}</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($socialLinks as $socialLink)
                            <tr>
                                <td>{{$socialLink->id}}</td>
                                <td><i style="font-size:30px" class="{{$socialLink->icon}}"></i></td>
                                <td>{{$socialLink->url}}</td>
                                <td>
                                    @if ($socialLink->status === 1)
                                    <span class="badge badge-success">{{ __('Yes') }}</span>

                                    @else
                                    <span class="badge badge-danger">{{ __('No') }}</span>

                                    @endif

                                </td>
                                <td>
                                    <a href="{{ route('admin.social-link.edit', $socialLink->id) }}"
                                        class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin.social-link.destroy', $socialLink->id) }}"
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