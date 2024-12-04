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

    // Cek stok barang
    $query_check = "SELECT stock FROM products WHERE id = $product_id";
    $result_check = mysqli_query($conn, $query_check);
    $row = mysqli_fetch_assoc($result_check);

    if ($row['stock'] < $quantity) {
        echo "<script>alert('Stok tidak mencukupi!'); window.location='penjualan.php';</script>";
    } else {
        // Kurangi stok barang
        $query_update = "UPDATE products SET stock = stock - $quantity WHERE id = $product_id";
        mysqli_query($conn, $query_update);

        // Catat transaksi penjualan
        $query_sales = "INSERT INTO sales (product_id, amount) VALUES ($product_id, $quantity)";
        if (mysqli_query($conn, $query_sales)) {
            echo "<script>alert('Transaksi berhasil dicatat!'); window.location='penjualan.php';</script>";
        } else {
            echo "<script>alert('Gagal mencatat transaksi!'); window.location='penjualan.php';</script>";
        }
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
    <title>Penjualan Barang</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="sales-container">
        <h1>Penjualan Barang</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="product_id">Nama Barang</label>
                <select id="product_id" name="product_id" required>
                    <?php while ($row = mysqli_fetch_assoc($result_products)): ?>
                        <option value="<?= $row['id']; ?>"><?= $row['product_name']; ?> (Stok: <?= $row['stock']; ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Jumlah</label>
                <input type="number" id="quantity" name="quantity" required>
            </div>
            <button type="submit" class="btn">Catat Penjualan</button>
        </form>
    </div>
    <div class="form-group">
    <label for="barcode">Scan Barcode</label>
    <input type="text" id="barcode" name="barcode" oninput="handleBarcode(this.value)" placeholder="Scan barcode di sini">
</div>
<script>
    function handleBarcode(barcode) {
        const select = document.getElementById('product_id');
        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].text.includes(barcode)) {
                select.selectedIndex = i;
                break;
            }
        }
    }
</script>
<?php while ($row = mysqli_fetch_assoc($result_products)): ?>
    <?php if ($row['stock'] > 0): ?>
        <option value="<?= $row['id']; ?>"><?= $row['product_name']; ?> (Stok: <?= $row['stock']; ?>)</option>
    <?php endif; ?>
<?php endwhile; ?>

</body>
</html>
