@extends('layouts.app')

@section('pageTitle')
    {!! __('laravel-vimeo::titles.me.create') !!}
@endsection

@section('content')
<div class="container">
    <h1> @lang('laravel-vimeo::titles.me.create') </h1>
    @if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form action="{{route('laravel-vimeo.me.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">@lang('laravel-vimeo::words.name')</label>
            <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}" maxlength="100">
            @if($errors->has('name'))
            <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="video">@lang('laravel-vimeo::words.video')</label>
            <input type="file" class="form-control-file" id="video" name="video" accept=".mp4">
            @if($errors->has('video'))
            <p class="text-danger">{{$errors->first('video')}}</p>
            @endif
        </div>
        <div class="form-group">
            <label>@lang('laravel-vimeo::words.access')</label>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="access_view"  id="access_view_anybody" value="anybody" checked>
                <label class="form-check-label" for="access_view_anybody">
                    @lang('laravel-vimeo::words.anybody')
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="access_view"  id="access_view_private" value="private">
                <label class="form-check-label" for="access_view_private">
                    @lang('laravel-vimeo::words.private')
                </label>
            </div>
        </div>
        <div>
            <button class="btn btn-primary" type="submit">
                @lang('laravel-vimeo::words.upload')
            </button>
            &nbsp;

            <a href="{{route('laravel-vimeo.me.index')}}">
                @lang('laravel-vimeo::words.back')
            </a>
        </div>
    </form>

</div>
@endsection
