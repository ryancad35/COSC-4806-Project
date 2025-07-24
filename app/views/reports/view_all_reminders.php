<?php require_once 'app/views/templates/header.php' ?>
<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="/reports">Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Reminders</li>
          </ol>
        </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h1>All Reminders</h1>
                <p class="lead">Complete list of all reminders in the system</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Reminder</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reminders as $reminder): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($reminder['username']); ?></td>
                        <td><?php echo htmlspecialchars($reminder['subject']); ?></td>
                        <td><?php echo $reminder['created_at']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once 'app/views/templates/footer.php' ?> 