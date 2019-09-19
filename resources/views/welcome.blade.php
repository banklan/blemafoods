@extends('layouts.app')

@section('content')
    @include('layouts.home_navbar')
    @include('welcome.top_banner')
    @include('welcome.our_services')
    @include('welcome.how_works')
    @include('welcome.popular')
    @include('welcome.why_choose')
    @include('layouts.footer')
@endsection
