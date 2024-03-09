@extends('frontend.layouts.master')
@section('content')
<!-- Breaking news  carousel-->
@include('frontend.home-components.breaking-news')
<!-- End Breaking news carousel -->

<!-- Hero Slider news -->
@include('frontend.home-components.hero-slider')
<!-- End Hero Slider news -->

<div class="large_add_banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="large_add_banner_img">
                    <img src="{{asset('frontend/assets/images/placeholder_large.jpg')}}" alt="adds">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main news category -->
@include('frontend.home-components.main-news')
<!-- End main news category -->
@endsection
