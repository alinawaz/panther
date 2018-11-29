<html>
	<head>
		<title>Sleek</title>
		<link rel="shortcut icon" href="/public/logo.png">
		<link href="/public/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="/public/js/jquery331.min.js"></script>
        <script src="/public/js/bootstrap.min.js"></script>
	</head>
	<body>
        <div class="jumbotron">
			<h1 class="display-4">
		Sleek
	</h1>
			<p class="lead">
		Panther templating engine.
	</p>
		</div>
		
	<ul>
		<?php foreach($items as $item){ ?>
		<li><?php echo $item->name; ?></li>
		<?php } ?>
	</ul>
	
    </body>
</html>