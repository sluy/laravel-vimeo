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
            <label for="name" class="font-weight-bold">@lang('laravel-vimeo::words.name')</label>
            <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}" maxlength="100">
            @if($errors->has('name'))
            <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="description"  class="font-weight-bold">@lang('laravel-vimeo::words.description')</label>
            <textarea class="form-control" type="text" name="description" id="description" maxlength="1000">{{old('description')}}</textarea>
            @if($errors->has('description'))
            <p class="text-danger">{{$errors->first('description')}}</p>
            @endif
        </div>

        <div class="form-group">
            <label for="video" class="font-weight-bold">@lang('laravel-vimeo::words.video')</label>
            <input type="file" class="form-control-file" id="video" name="video" accept=".mp4">
            @if($errors->has('video'))
            <p class="text-danger">{{$errors->first('video')}}</p>
            @endif
        </div>

        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="privacy_download" value="1" id="privacy_download"{{old('privacy_download') === '1' ? ' checked':''}}>
                <label class="form-check-label" for="privacy_download">
                    @lang('laravel-vimeo::words.downloable_question')
                </label>
            </div>
            @if($errors->has('privacy_download'))
                <p class="text-danger">{{$errors->first('privacy_download')}}</p>
            @endif
        </div>
        

        <div class="form-group">
            <label class="font-weight-bold">@lang('laravel-vimeo::words.view_access')</label>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="privacy_view"  id="privacy_view_anybody" value="anybody"{{empty(old('privacy_view')) || old('privacy_view') === 'anybody' ? ' checked' : ''}}>
                <label class="form-check-label" for="privacy_view_anybody">
                    @lang('laravel-vimeo::words.anybody')
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="privacy_view"  id="privacy_view_contacts" value="contacts"{{old('privacy_view') === 'contacts' ? ' checked' : ''}}>
                <label class="form-check-label" for="privacy_view_contacts">
                    @lang('laravel-vimeo::words.contacts')
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="privacy_view"  id="privacy_view_disable" value="disable"{{old('privacy_view') === 'disable' ? ' checked' : ''}}>
                <label class="form-check-label" for="privacy_view_disable">
                    @lang('laravel-vimeo::words.disable')
                </label>
            </div>


            <div class="form-check">
                <input class="form-check-input" type="radio" name="privacy_view"  id="privacy_view_nobody" value="nobody"{{old('privacy_view') === 'nobody' ? ' checked' : ''}}>
                <label class="form-check-label" for="privacy_view_nobody">
                    @lang('laravel-vimeo::words.nobody')
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="privacy_view"  id="privacy_view_unlisted" value="unlisted"{{old('privacy_view') === 'unlisted' ? ' checked' : ''}}>
                <label class="form-check-label" for="privacy_view_unlisted">
                    @lang('laravel-vimeo::words.unlisted')
                </label>
            </div>

            <div class="form-group">
                @if($errors->has('privacy_view'))
                    <p class="text-danger">{{$errors->first('privacy_view')}}</p>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="font-weight-bold">@lang('laravel-vimeo::words.embed_access')</label>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="privacy_embed"  id="privacy_embed_public" value="public"{{empty(old('privacy_embed')) || old('privacy_embed') === 'private' ? ' checked' : ''}}>
                <label class="form-check-label" for="privacy_embed_public">
                    @lang('laravel-vimeo::words.public')
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="privacy_embed"  id="privacy_embed_private" value="private"{{old('privacy_embed') === 'private' ? ' checked' : ''}}>
                <label class="form-check-label" for="privacy_embed_private">
                    @lang('laravel-vimeo::words.private')
                </label>
            </div>

            <div class="form-group">
                @if($errors->has('privacy_embed'))
                    <p class="text-danger">{{$errors->first('privacy_embed')}}</p>
                @endif
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
