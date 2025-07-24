<?php require_once 'app/views/templates/headerPublic.php'?>
<main role="main" class="container">
    <?php if (!empty($success)): ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Create an Account</h1>
                <p class="lead">Create your account below.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-auto">

            <form action="/create" method="post" >
            <fieldset>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input required type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input required type="password" class="form-control" name="password">
                </div>
                <button type="submit" class="btn btn-primary" name="action" value="Submit Registration">Create Account</button><br><br>
            </fieldset>
            </form> 
            <p>Already have an account? <a href="/login">Login here</a></p>
        </div>
    </div>
<?php require_once 'app/views/templates/footer.php' ?>