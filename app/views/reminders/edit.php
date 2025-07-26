<?php require_once 'app/views/templates/header.php' ?>
<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="/reminders">Reminders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
          </ol>
        </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Display error if there is one -->
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                <h1>Edit Your Reminder</h1>
            </div>
        </div>
    </div>

    <form action="/reminders/edit_reminder" method="post">
        <fieldset>
            <legend>Enter Your Reminder</legend>
            <textarea maxlength="255" name="message" id="message"><?php echo $reminder['subject']; ?></textarea><br>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="action" class="btn btn-primary" value="Edit Reminder">
        </fieldset>
    </form>
    <br>
</div>
<?php require_once 'app/views/templates/footer.php'?>