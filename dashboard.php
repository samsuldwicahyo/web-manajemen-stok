<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Query untuk mendapatkan data stok rendah
$query_low_stock = "SELECT * FROM products WHERE stock <= min_stock";
$result_low_stock = mysqli_query($conn, $query_low_stock);

// Query untuk grafik penjualan harian
$query_sales = "SELECT DATE(sale_date) AS date, SUM(amount) AS total FROM sales GROUP BY DATE(sale_date) ORDER BY date DESC LIMIT 7";
$result_sales = mysqli_query($conn, $query_sales);

// Query untuk barang populer
$query_popular = "SELECT product_name, COUNT(product_id) AS sold FROM sales GROUP BY product_id ORDER BY sold DESC LIMIT 5";
$result_popular = mysqli_query($conn, $query_popular);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Manajemen Stok dan Penjualan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Dashboard</h1>
        <div class="card">
            <h3>Stok Barang Rendah</h3>
            <ul>
                <?php while ($row = mysqli_fetch_assoc($result_low_stock)): ?>
                    <li><?= $row['product_name']; ?> (Stok: <?= $row['stock']; ?>)</li>
                <?php endwhile; ?>
            </ul>
        </div>
        <div class="card">
            <h3>Penjualan Harian</h3>
            <canvas id="salesChart"></canvas>
        </div>
        <div class="card">
            <h3>Barang Populer</h3>
            <ul>
                <?php while ($row = mysqli_fetch_assoc($result_popular)): ?>
                    <li><?= $row['product_name']; ?> (Terjual: <?= $row['sold']; ?>)</li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesData = {
            labels: [
                <?php
                mysqli_data_seek($result_sales, 0);
                while ($row = mysqli_fetch_assoc($result_sales)) {
                    echo "'" . $row['date'] . "',";
                }
                ?>
            ],
            datasets: [{
                label: 'Penjualan Harian',
                data: [
                    <?php
                    mysqli_data_seek($result_sales, 0);
                    while ($row = mysqli_fetch_assoc($result_sales)) {
                        echo $row['total'] . ",";
                    }
                    ?>
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };
        const salesChart = new Chart(ctx, {
            type: 'bar',
            data: salesData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
