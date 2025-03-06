<?php
require 'koneksi.php';

$alert = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $peran = 'peminjam'; // default role

    $sql = "INSERT INTO users (nama, email, password, peran) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $alert = "<div class='bg-red-500 text-white text-center p-3 rounded-lg mb-4'>Terjadi kesalahan pada sistem. Coba lagi nanti!</div>";
    } else {
        $stmt->bind_param("ssss", $nama, $email, $password, $peran);
        if ($stmt->execute()) {
            header("refresh:2;url=login.php");
            $alert = "<div class='bg-green-500 text-white text-center p-3 rounded-lg mb-4'>Pendaftaran Berhasil! Silakan <a href='login.php' class='underline'>login</a>.</div>";
            exit;
        } else {
            if ($stmt->errno == 1062) { 
                $alert = "<div class='bg-red-500 text-white text-center p-3 rounded-lg mb-4'>Email sudah terdaftar. Gunakan email lain!</div>";
            } else {
                $alert = "<div class='bg-red-500 text-white text-center p-3 rounded-lg mb-4'>Gagal mendaftar. Pastikan data yang diinput benar!</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-4">Register Perpustakaan</h2>

        <?php echo $alert; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-600">Nama</label>
                <input type="text" name="nama" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" placeholder="Masukkan nama" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" placeholder="Masukkan email" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition">Daftar</button>
        </form>

        <p class="mt-4 text-center text-gray-600">
            Sudah punya akun? <a href="login.php" class="text-blue-500 hover:underline">Login</a>
        </p>
    </div>

</body>
</html>
