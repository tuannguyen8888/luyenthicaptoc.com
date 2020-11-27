@extends('frontend.layout.index')
@section('body')

		<div class="container-fluid tintuc">
			<div class="container">
				<div class="row">
					<div class="col-md-12 tieudetintuc">
				
						<h3 style="text-transform: uppercase;"> {{$article->category_name}}</h3>
					</div>
				</div>

				<div class="main_gioithieu">
					
					<h4>	<b>{{$article->blog_title}}</b></h4>

					{!!$article->description!!}

				</div>

			

				
			</div>
		</div>

@endsection
