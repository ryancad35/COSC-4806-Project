<?php require_once 'app/views/templates/header.php' ?>
<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="/reports">Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">Most Reminders</li>
          </ol>
        </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h1>Users with Most Reminders</h1>
                <p class="lead">Ranking of users by number of reminders created</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body">
                    <canvas id="remindersChart" width="400" height="200"></canvas>
                </div>
            </div>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Username</th>
                        <th>Number of Reminders</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rank = 1; ?>
                    <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo $rank; ?></td>
                        <td><?php echo htmlspecialchars($result['username']); ?></td>
                        <td><?php echo $result['reminder_count']; ?></td>
                    </tr>
                    <?php $rank++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    // Simple chart data
    const usernames = [<?php foreach($results as $result) echo '"' . $result['username'] . '",'; ?>];
    const counts = [<?php foreach($results as $result) echo $result['reminder_count'] . ','; ?>];

    // Create simple bar chart
    const ctx = document.getElementById('remindersChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: usernames,
            datasets: [{
                label: 'Reminders',
                data: counts,
                backgroundColor: 'blue'
            }]
        }
    });
    </script>
</div>
<?php require_once 'app/views/templates/footer.php' ?> 