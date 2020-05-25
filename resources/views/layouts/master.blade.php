<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	@include('includes.head')
</head>
<body>
	<div class="wrapper">
		@section('nav')
			@include('includes.nav')
		@show

		@section('sidebar')
			@include('includes.sidebar')
		@show

		<!-- @section('header')
			<div>
				<h1>Header part</h1>
			</div>
		@show -->

		<div class="content-wrapper">
			<section class="content">
				@yield('content')
			</section>
		</div>

		@section('footer')
		    @include('includes.footer')
		@show
	</div>
	@include('includes.script')
	
</body>
</html>