@extends('layouts.app')
@section('pageTitle')
    {!! __('laravel-vimeo::titles.me.index') !!}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
        </div>
        <div class="col-12">
             @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
    <div class="text-right mb-5">
        <a href="{{route('laravel-vimeo.me.create')}}" class="btn btn-success">{!! __('laravel-vimeo::words.upload_video') !!}</a>
    </div>
    <div class="row">
        @forelse($pagination->getItems() as $item)
        <div class="col-xs-12 col-md-6 col-lg-3 mb-4">
            <div class="card" data-id="{{$item->getId()}}">
                <img class="card-img-top" data-type="thumbnail" src="{{$item->getPictureUrl('big')}}" alt="p" onclick="runIframe({{$item->getId()}})" style="cursor:pointer;">
                {!! $item->getEmbedAs('div') !!}
                <div class="card-body">
                    <h4>{{$item->get('name')}}</h4>
                    <div>
                        {!! __('laravel-vimeo::words.video_author_date', ['name' => $item->get('user.name'),'date' => $item->getCreatedTime()->diffForHumans()]) !!}
                    </div>
                    <div>
                        <b>Tags:</b>
                        @forelse($item->getTags([]) as $tag)
                            <span class="badge badge-info">{{$tag['name']}}</span>
                        @empty
                            {!! __('laravel-vimeo::words.none') !!}
                        @endforelse
                    </div>
                    <p>
                        {{$item->getId()}}
                        {{$item->getDescription(__('laravel-vimeo::words.no_description'))}}
                    </p>
                    <div class="text-center mt-5">
                        <a class="btn btn-sm btn-primary" href="{{$item->get('link')}}" target="_blank">
                            {!! __('laravel-vimeo::words.play_in_vimeo') !!}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="col-12">
                {!! __('laravel-vimeo::words.no_videos_found') !!}
            </div>
        @endforelse
    </div>
    <div class="text-right">

        <nav aria-label="pagination" class="d-inline-block">
            <ul class="pagination">
                @foreach($pagination->getRelativePagination() as $current)
                    <li class="page-item{{$current['active']?' active':''}}{{$current['disabled']?' disabled':''}}">
                        <a class="page-link" href="{{$current['url']}}">{{$current['label']}}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <br/>
        <small>
            @lang('laravel-vimeo::words.pagination_message', [ 'page' => $pagination->getCurrentPage(), 'total_pages' => $pagination->getLastPage()])
        </small>
    </div>
</div>

<script type="text/javascript">
    function runIframe(id) {
        document.querySelectorAll('[data-id="'+id+'"] [data-type="thumbnail"]').forEach(function (el) {
            el.parentNode.removeChild(el);
        });
        document.querySelectorAll('[data-id="'+id+'"] [data-type="iframe"]').forEach(function (el) {
            var d = document.createElement('iframe');
            for (var i = 0; i < el.attributes.length; i++) {
                var attrib = el.attributes[i];
                d.setAttribute(attrib.name, attrib.value);
            }
            el.parentNode.replaceChild(d, el);
            d.click();
        });
    }
</script>
@endsection
