@if (!$isAjax)
    @extends('layouts.master')

    @section('page-wrapper')

    @stop
@else
    @yield('page-wrapper')
@endif