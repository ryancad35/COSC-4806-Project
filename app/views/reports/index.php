<?php require_once 'app/views/templates/header.php' ?>
<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= ucwords($_SESSION['controller']);?></li>
          </ol>
        </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h1>Reports</h1>
                <p class="lead">Choose a report to view:</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="list-group">
                <a href="/reports/view_all_reminders" class="list-group-item list-group-item-action">
                    <h5>View All Reminders</h5>
                    <p>See all reminders in the system</p>
                </a>
                <a href="/reports/most_reminders" class="list-group-item list-group-item-action">
                    <h5>Who Has the Most Reminders</h5>
                    <p>See which users have created the most reminders</p>
                </a>
                <a href="/reports/login_counts" class="list-group-item list-group-item-action">
                    <h5>Login Counts by Username</h5>
                    <p>See how many times each user has logged in</p>
                </a>
            </div>
        </div>
    </div>
</div>
<?php require_once 'app/views/templates/footer.php' ?> 