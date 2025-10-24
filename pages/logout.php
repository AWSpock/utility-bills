<div class="header">
	<h1>Home</h1>
</div>

<nav class="breadcrumbs">
	<ul>
		<li><a href="/">Addresses</a></li>
		<li>Log Out</li>
	</ul>
</nav>

<div class="content">
	<?php
	if ($userAuth->checkToken()) {
	?>
		<div class="alert alert-danger logout-message">
			<p>Failed to log out</p>
		</div>
	<?php
	} else {
	?>
		<div class="alert alert-success logout-message">
			<p>You have been logged out!</p>
		</div>
	<?php
	}
	?>
</div>