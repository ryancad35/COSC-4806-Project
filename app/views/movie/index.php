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
                <h1>Movie Search & Rating</h1>
                <p class="lead">Search for movies and rate them</p>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Search for a Movie</h5>
                </div>
                <div class="card-body">
                    <form action="/movie/search" method="POST">
                        <div class="form-group">
                            <label for="movie">Movie Title</label>
                            <input type="text" class="form-control" id="movie" name="movie" 
                                   value="<?= isset($_REQUEST['movie']) ? htmlspecialchars($_REQUEST['movie']) : '' ?>" 
                                   required>
                        </div>
                        <div class="form-group">
                            <!-- Optional release date field for potential movies with same title -->
                            <label for="release_date">Release Year (optional)</label>
                            <input type="text" class="form-control" id="release_date" name="release_date" 
                                   value="<?= isset($_REQUEST['release_date']) ? htmlspecialchars($_REQUEST['release_date']) : '' ?>" 
                                   placeholder="e.g. 2012">
                        </div>
                        <button type="submit" class="btn btn-primary">Search Movie</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php require_once 'app/views/templates/footer.php' ?> 