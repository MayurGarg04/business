<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	@include('includes.head')
</head>
<body>
	<div class="wrapper">
			<section class="content">
				@yield('content')
			</section>

	</div>
	@include('includes.script')
	
</body>
</html>