<head>
	<title>密院活动假人排行榜</title>
	<link href="//cdn.bootcss.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" rel="stylesheet">

</head>


<body>

<nav class="navbar navbar-light bg-faded">
	<div class="container">
		<a class="navbar-brand" href="/gpa">GPA</a>
		<ul class="nav navbar-nav float-xs-right">
			<li class="nav-item">
				<?php if (!isset($_SESSION['userid']) || $_SESSION['userid'] == ''): ?>
					<a class="nav-link" href="/gpa/login">Login</a>
				<?php else: ?>
					<a class="nav-link" href="/gpa/edit">Edit</a>
				<?php endif; ?>
			</li>
		</ul>
	</div>
</nav>

<br>