
@extends('frontend.layout.index')
@section('body')
	<div class="container-fluid tintuc">
			<div class="container">
				<div class="row">
					<div class="col-md-12 tieudetintuc">
				
						<h3 style="text-transform: uppercase;"> {{$category->name}}</h3>
					</div>
				</div>

				@forelse ($articles as $article)
					<div class="row tintuc_first">
						<div class="col-md-2 col_ngaydang">
							<span class="ngaydang">{{date_time_format($article->created_date,'YYYY-MM-DD','DD/MM/YYYY') }}</span>
						</div>
						<div class="col-md-1">
							<img src="{{ asset('imgs/lienket_tt.png') }}" alt="" class="anh_lienket" >
						</div>
						<div class="col-md-4">
							<a href="/article/{{$article->blog_slug}}">
								<img src="{{ asset($article->blog_image ? $article->blog_image : ('tintuc'.rand(1,6).'.jpg')) }}" class="img_tintuc">
							</a>
						</div>
						<div class="col-md-5 trichdoan">
							<a href="/article/{{$article->blog_slug}}" style="color: #000">
								<h4>{{$article->blog_title}}</h4>
							</a>

							<p>{{substr(strip_tags($article->description), 0, 500)}}...</p>

							{{--<p class="time_cmt"><i class="far fa-eye"></i> 123 &nbsp;&nbsp; <i class="far fa-comment"></i> 123 &nbsp;&nbsp; <i class="far fa-file-alt"></i> 1234</p>--}}
						</div>

					</div>
				@empty
					<p>Không có bài viết nào được tìm thấy</p>
				@endforelse

				{{--<div class="phantrangtintuc">--}}
					{{--<a href="tintuc"><span><i class="fas fa-angle-double-left"></i></span></a>--}}
					{{--<a href="tintuc"><span>1</span></a>--}}
					{{--<a href="tintuc"><span><i class="fas fa-angle-double-right"></i></span></a>--}}
				{{--</div>--}}
				{{ $articles->links() }}
			</div>
		</div>

@stop
