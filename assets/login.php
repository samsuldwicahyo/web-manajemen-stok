<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Stok dan Penjualan</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="auth.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Peran</label>
                <select id="role" name="role" required>
                    <option value="gudang">Gudang</option>
                    <option value="pembelian">Pembelian</option>
                    <option value="penjualan">Penjualan</option>
                    <option value="pemilik">Pemilik Toko</option>
                    <option value="kasir">Kasir</option>
                    <option value="bendahara">Bendahara Toko</option>
                </select>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
