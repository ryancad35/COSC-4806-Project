<?php require_once 'app/views/templates/headerPublic.php'?>
<main role="main" class="container">
	<?php if (!empty($error)): ?>
		<div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
	<?php endif; ?>

	<div class="page-header" id="banner">
		<div class="row">
			<div class="col-lg-12">
				<h1>Please Log In</h1>
				<p class="lead">Enter your credentials below.</p>
			</div>
		</div>
	</div>

	<form action="/login/verify" method="post">
		<?php if (!empty($locked)): ?>
			<fieldset disabled>
		<?php else: ?>
			<fieldset>
		<?php endif; ?>
			<div class="form-group">
				<label for="username">Username</label>
				<input required type="text" class="form-control" id="username" name="username">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input required type="password" class="form-control" id="password" name="password">
			</div>
			<button type="submit" class="btn btn-primary">Login</button><br><br>
		</fieldset>
	</form>
	<p>Don't have an account? <a href="/create">Create one here</a></p>
</main>
<?php require_once 'app/views/templates/footer.php' ?>