<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="og:title" content="@yield('meta_og_title')">
    <meta name="og:description" content="@yield('meta_og_description')">
    <meta name="og:image" content="@yield('meta_og_image')">
    <meta name="twitter:title" content="@yield('meta_tw_title')">
    <meta name="twitter:description" content="@yield('meta_tw_description')">
    <meta name="twitter:image" content="@yield('meta_tw_image')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link href="{{asset('frontend/assets/css')}}/styles.css" rel="stylesheet">
    {{-- <link href="{{ asset('frontend/assets/css/styles.css') }}" rel="stylesheet"> --}}

</head>

<body>

    @php
        $socialLinks = App\Models\SocialLink::where('status', 1)->get();
        $footerInfo = App\Models\FooterInfo::where('language', getLanguage())->first();
    @endphp
    <!-- Header news -->
    @include('frontend.layouts.header')
    <!-- End Header news -->


    @yield('content')

    <!-- Footer Section -->
    @include('frontend.layouts.footer')
    <!-- End Footer Section -->

    <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

    <script type="text/javascript" src="{{asset('frontend/assets/js/index.bundle.js')}}"></script>
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){
            $('#site-language').on('change', function(){
                let languageCode = $(this).val();
                $.ajax({
                    method: 'GET',
                    url: "{{route('language')}}",
                    data: {languageCode: languageCode},
                    success: function(data)
                    {
                        if(data.status === 'success')
                        {
                            // window.location.reload();
                            window.location.href = "{{ url('/') }}";
                        }
                    },
                    error: function(data)
                    {
                        console.log(data);
                    }
                })
            })
        })

        /* Subscribe Newsletter */
        $('.newsletter-form').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                method: 'POST',
                url: "{{route('subscribe-newsletter')}}",
                data: $(this).serialize(),
                beforeSend: function(){
                    $('.newsletter-button').text('Loading...');
                    $('.newsletter-button').attr('disabled', true);
                },
                success: function(data){
                    if(data.status === 'success')
                    {
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        })
                        $('.newsletter-form')[0].reset();
                        $('.newsletter-button').text('sign up');
                        $('.newsletter-button').attr('disabled', false);
                    }
                },
                error: function(data){
                    $('.newsletter-button').text('Sign Up');
                    $('.newsletter-button').attr('disabled', false);
                    if(data.status === 422){
                        let errors = data.responseJSON.errors;
                        $.each(errors, function(index, value){
                            Toast.fire({
                                icon: 'error',
                                title: value[0]
                            })
                        })
                    }
                }
            })
        })


    </script>

    @stack('content')

</body>

</html>
