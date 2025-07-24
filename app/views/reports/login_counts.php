<?php require_once 'app/views/templates/header.php' ?>
<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="/reports">Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">Login Counts</li>
          </ol>
        </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h1>Login Counts by Username</h1>
                <p class="lead">Number of successful logins for each user</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <canvas id="loginChart" width="400" height="200"></canvas>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Successful Logins</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result['username']); ?></td>
                        <td><?php echo $result['login_count']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    // Simple chart data
    const usernames = [<?php foreach($results as $result) echo '"' . $result['username'] . '",'; ?>];
    const counts = [<?php foreach($results as $result) echo $result['login_count'] . ','; ?>];

    // Simple pie chart
    const ctx = document.getElementById('loginChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: usernames,
            datasets: [{
                data: counts,
                backgroundColor: ['red', 'blue', 'green', 'yellow', 'purple']
            }]
        }
    });
    </script>
</div>
<?php require_once 'app/views/templates/footer.php' ?> 