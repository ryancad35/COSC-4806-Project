<?php require_once 'app/views/templates/header.php' ?>
<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="/reminders">Reminders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
          </ol>
        </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                <h1>Create a Reminder</h1>
            </div>
        </div>
    </div>

    <form action="/reminders/create_reminder" method="post">
        <fieldset>
            <legend>Enter Your Reminder</legend>
            <div class="form-group">
                <textarea maxlength="255" name="message" id="message" class="form-control"></textarea>
            </div>
            <input type="submit" name="action" class="btn btn-primary" value="Submit Reminder" class="btn">
        </fieldset>
    </form>
</div>
<?php require_once 'app/views/templates/footer.php'?>