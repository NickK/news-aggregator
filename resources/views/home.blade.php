@extends('layouts.app')

@section('content')
<section class="news-feed section-container">
        <div class="container-wrap">
                <div class="container">
                        @guest
                            <h1>Example Feed</h1>
                            <p>Not a real homepage</p>
                        @endguest

                        @php ($i = 0)
                        @if(!$links->isEmpty())
                            @foreach ($links as $link)
                                @php ($i++)
                                    <div class="animated fadeInUp delay-{{$i}}s faster">
                                        <div class="item row">
                                                <div class="number">{{$i}}</div>
                                                <div class="meta">
                                                    <h2>
                                                        <a href="{{$link->sourceLink}}" target="_blank">{{$link->sourceTitle}} ({{$link->sourceName}})</a>
                                                    </h2>
                                                    <p>
                                                        <span class="tags">Tag: {{$link->tags->tagName}}</span> - 

                                                        <span class="dated-posted">Added {{ \Carbon\Carbon::parse($link->sourceDate)->diffForHumans() }}</span>
                                                    </p>
                                                </div>
                                        </div>
                                    </div>
                            @endforeach
                        @else
                            <h2>Your feed</h2>
                            <p>Your feed is empty. Have you added sources and tags in your <a href="{{route('settings/dashboard')}}">settings</a>?</p>
                        @endif
                </div>
        </div>
</section>
@endsection
