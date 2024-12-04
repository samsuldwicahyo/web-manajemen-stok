<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Query untuk mendapatkan data stok barang
$query_stock = "SELECT * FROM products";
$result_stock = mysqli_query($conn, $query_stock);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Stok Barang</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="stock-container">
        <h1>Cek Stok Barang</h1>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_stock)): ?>
                    <tr>
                        <td><?= $row['product_name']; ?></td>
                        <td><?= $row['stock']; ?></td>
                        <td>
                            <?php 
                            if ($row['stock'] == 0) echo 'Out of Stock';
                            elseif ($row['stock'] <= $row['min_stock']) echo 'Low Stock';
                            else echo 'Normal';
                            ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
