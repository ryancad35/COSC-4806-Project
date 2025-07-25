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

        <!-- Session Error Message -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
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

        <!-- Movie Results -->
        <?php if (isset($movie)): ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Movie Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <?php if (isset($movie['Poster']) && $movie['Poster'] !== 'N/A'): ?>
                                    <img src="<?php echo htmlspecialchars($movie['Poster']); ?>" class="img-fluid rounded" alt="Movie Poster">
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                        <span class="text-muted">No Poster Available</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <h4><?php echo htmlspecialchars($movie['Title']); ?></h4>
                                <p><strong>Release Year:</strong> <?php echo htmlspecialchars($movie['Year']); ?></p>

                                <p><strong>Description:</strong></p>
                                <p><?php echo htmlspecialchars($movie['Plot']); ?></p>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <p><strong>Metascore:</strong> 
                                            <?php 
                                            if (isset($movie['Metascore']) && $movie['Metascore'] !== 'N/A') {
                                                echo htmlspecialchars($movie['Metascore']) . '/100';
                                            } else {
                                                echo 'Not Available';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><strong>IMDB Rating:</strong> 
                                            <?php 
                                            if (isset($movie['imdbRating']) && $movie['imdbRating'] !== 'N/A') {
                                                echo htmlspecialchars($movie['imdbRating']) . '/10';
                                            } else {
                                                echo 'Not Available';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>

                                <!-- Rating Section -->
                                <div class="mt-4">
                                    <h6>Rate this Movie:</h6>
                                    <div id="star-rating" 
                                         data-movie-title="<?php echo htmlspecialchars($movie['Title']); ?>" 
                                         data-movie-year="<?php echo htmlspecialchars($movie['Year']); ?>">
                                    </div>
                                    <small class="text-muted">
                                        <?php if (isset($user_score) && $user_score > 0): ?>
                                            ✅ You already rated this movie <?php echo $user_score; ?>/5 stars. You cannot rate it again.
                                        <?php else: ?>
                                            Click on a star to submit your rating
                                        <?php endif; ?>
                                    </small>
                                </div>

                                <!-- AI Review Section -->
                                <?php if (isset($user_score) && $user_score > 0): ?>
                                <div class="mt-4">
                                    <h6>AI Review:</h6>
                                    <p class="text-muted mb-2">Generate an AI review based on your <?php echo $user_score; ?>/5 star rating:</p>
                                    <a href="/movie/ai_review/<?php echo urlencode($movie['Title']); ?>/<?php echo htmlspecialchars($movie['Year']); ?>/<?php echo $user_score; ?>#ai-review" 
                                       class="btn btn-primary">
                                        🤖 Generate Review (<?php echo $user_score; ?>/5 ⭐)
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- AI Review Results -->
                    <?php if (isset($ai_review)): ?>
                    <div class="row mt-4" id="ai-review">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>AI-Generated Review - <?php echo htmlspecialchars($ai_rating); ?>/5 Stars</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <strong>Note:</strong> This review was generated by AI from your perspective based on your <?php echo htmlspecialchars($ai_rating); ?> out of 5 star rating.
                        </div>
                        <div style="font-size: 1.1em; line-height: 1.6;">
                            <?php echo nl2br(htmlspecialchars($ai_review)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Raty CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/raty/2.9.0/jquery.raty.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raty/2.9.0/jquery.raty.min.js"></script>

    <script>
    $(document).ready(function() {
        <?php if (isset($user_score) && $user_score > 0): ?>
        // User has already rated - show read-only stars
        $('#star-rating').raty({
            starType: 'icon',
            number: 5,
            score: <?php echo $user_score; ?>,
            readOnly: true,
            hints: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars']
        });
        <?php else: ?>
        // User hasn't rated - allow rating
        $('#star-rating').raty({
            starType: 'icon',
            number: 5,
            score: 0,
            hints: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'],
            click: function(score, evt) {
                var movieTitle = $('#star-rating').data('movie-title');
                var movieYear = $('#star-rating').data('movie-year');

                // Redirect to review URL
                window.location.href = '/movie/review/' + encodeURIComponent(movieTitle) + '/' + movieYear + '/' + score;
            }
        });
        <?php endif; ?>
    });
    </script>

    <?php require_once 'app/views/templates/footer.php' ?> 