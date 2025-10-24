<div class="header">
	<h1>Log In</h1>
</div>

<nav class="breadcrumbs">
	<ul>
		<li><a href="/">Addresses</a></li>
		<li>Log In</li>
	</ul>
</nav>

<div class="content">
	<?php
	if ($userAuth->checkToken()) {
	?>
		<div class="alert alert-success login-message">
			<pre>User: <?php echo $userAuth->user()->toString(true); ?></pre>
		</div>
	<?php
	} else {
	?>
		<form method="post" id="frm" class="form-group main-form">
			<div class="input-group">
				<label for="email" class="form-control">Email:</label>
				<input type="email" name="email" id="email" required="required" class="form-control" />
			</div>
			<div class="input-group">
				<label for="password" class="form-control">Password:</label>
				<input type="password" name="password" id="password" required="required" class="form-control" />
			</div>
			<div class="button-group">
				<button type="submit" class="button primary"><i class="fa-solid fa-right-to-bracket"></i>Log In</button>
				<!-- <a href="/authentication/signup.php">Sign Up</a> -->
			</div>
			<?php
			if ($userAuth->msg() !== null) {
			?>
				<div class="alert alert-danger">
					<p><?php echo $userAuth->msg(); ?></p>
				</div>
			<?php
			}
			?>
		</form>
	<?php
	}
	?>
</div>