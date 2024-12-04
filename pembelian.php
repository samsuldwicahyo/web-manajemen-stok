<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Update stok barang
    $query_update = "UPDATE products SET stock = stock + $quantity WHERE id = $product_id";
    if (mysqli_query($conn, $query_update)) {
        echo "<script>alert('Stok berhasil ditambahkan!'); window.location='pembelian.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan stok!'); window.location='pembelian.php';</script>";
    }
}

// Query untuk mendapatkan data barang
$query_products = "SELECT * FROM products";
$result_products = mysqli_query($conn, $query_products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Barang</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="purchase-container">
        <h1>Pembelian Barang</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="product_id">Nama Barang</label>
                <select id="product_id" name="product_id" required>
                    <?php while ($row = mysqli_fetch_assoc($result_products)): ?>
                        <option value="<?= $row['id']; ?>"><?= $row['product_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Jumlah</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <button type="submit" class="btn">Tambah Stok</button>
        </form>
    </div>
</body>
</html>
