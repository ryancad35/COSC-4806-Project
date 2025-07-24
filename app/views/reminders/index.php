    <?php require_once 'app/views/templates/header.php' ?>
<div class="page-header" id="banner">
    <div class="container">
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
            <h1>Reminders</h1>
            <p><a href='reminders/create'>Create a reminder</a></p>
        </div>

        <div class="reminders-list">
            <?php echo $remindersList; ?>
        </div>
    </div>
    <?php require_once 'app/views/templates/footer.php' ?>