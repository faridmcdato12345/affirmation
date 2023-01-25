@extends('layouts.mobile')

@section('content')
	<!--start of page content, add your stuff here-->
	<div class="card mb-0" style="background-image: url({{ asset('images/the-river-gfd490d610_1280.jpg') }});" data-card-height="cover">
		<div class="card-center px-3">
			<h1 class="color-white font-24 opacity-50">Today's Affirmation:</h1>
			<h1 class="color-white font-40" style="letter-spacing: 0.1rem; line-height: 1em">{{ $affirmation->text }}</h1>
			<a href="#" data-menu="sheet-wizard-step-1" class="mt-5 btn btn-xxl bg-blue-dark border-blue-dark shadow-s rounded-m font-900">Begin Exercise</a>
		</div>
		<div class="card-overlay bg-gradient"></div>
		<div class="card-overlay bg-black opacity-30"></div>
	</div>
@endsection

@section('popups')
@include('components.affirmation-exercise')
@endsection