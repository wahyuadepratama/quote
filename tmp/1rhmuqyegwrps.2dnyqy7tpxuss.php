<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>F3 Tutorial</title>
	</head>
	<body>
		<ul>
		<?php foreach (($users?:[]) as $item): ?>
		    <li><?= ($item['username']) ?></li>
		<?php endforeach; ?>
		</ul>
	</body>
</html>
