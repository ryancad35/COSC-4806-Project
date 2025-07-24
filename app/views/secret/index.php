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
                    <h1>You are at a secret page</h1>
                    <p class="lead"> <?= date("F jS, Y"); ?></p>
                </div>
            </div>
        </div>

        <?php require_once 'app/views/templates/footer.php' ?>
