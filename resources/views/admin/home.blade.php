@extends('layouts.app')

@section('content')
    @include('layouts.admin_navbar')
    <router-view></router-view>
@endsection
