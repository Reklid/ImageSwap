@extends('app')
@section('head_title', 'Images Show')

@section('content')
    <image-show
            image-path="{{ $path }}"
            :has-like="{{ json_encode($hasLike) }}">
    </image-show>
@endsection