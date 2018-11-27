<html>
	<head>
		<title>Sleek Layout</title>
		<link rel="shortcut icon" href="~logo.png">
		<link href="~css/bootstrap.min.css" rel="stylesheet"/>
        <script src="~js/jquery331.min.js"></script>
        <script src="~js/bootstrap.min.js"></script>
	</head>
	<body>
        <div class="jumbotron">
			<h1 class="display-4">@yield('title')</h1>
			<p class="lead">@yield('content')</p>
		</div>
    </body>
</html>