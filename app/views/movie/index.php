<?php require_once 'app/views/templates/headerHybrid.php' ?>
<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo ucwords($_SESSION['controller']); ?></li>
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

        <!-- Success Message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

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
                                <label for="movie">Movie Title *</label>
                                <input type="text" class="form-control" id="movie" name="movie" 
                                       value="<?php if (isset($_REQUEST['movie'])) { 
                                        echo htmlspecialchars($_REQUEST['movie']); 
                                        } ?>" 
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="release_date">Release Year (optional)</label>
                                <input type="text" class="form-control" id="release_date" name="release_date" 
                                       value="<?php if (isset($_REQUEST['release_date'])) { 
                                        echo htmlspecialchars($_REQUEST['release_date']); 
                                        } ?>" 
                                       placeholder="e.g. 1999">
                            </div>
                            <button type="submit" class="btn btn-primary">Search Movie</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php require_once 'app/views/templates/footer.php' ?> 