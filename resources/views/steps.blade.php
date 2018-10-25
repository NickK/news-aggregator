@extends('layouts.app')

@section('content')
<section class="news-feed section-container">
        <div class="container-wrap">
                <div class="container">
                        <h1>Steps</h1>


	                    <section class="settings-news section-container">
	                            <h4>1. News Sources</h4>
	                            <sources></sources>
	                    </section>

	                    <section class="basic-information section-container">
	                            <h4>2. Tags</h4>
	                            <p>Tags to look out in articles for</p>
	                            <tags></tags>
	                    </section>
			
						<section class="section-container">
							<a href="{{route('home')}}" class="btn dark">Go to newsfeed</a>
						</section>
                </div>
        </div>
</section>
@endsection
