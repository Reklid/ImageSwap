@extends('app')
@section('head_title', 'Images List')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-auto" style="margin: 20px">
                @foreach ($images as $image)
                    <img src="{{ $image->image_url }}" alt="">
                @endforeach
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-auto">
                {{ $images->links() }}
            </div>
        </div>
    </div>
@endsection