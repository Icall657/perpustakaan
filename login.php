<?php
session_start();
require 'koneksi.php';

$alert = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, nama, password, peran FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nama, $hashed_password, $peran);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['nama'] = $nama;
            $_SESSION['peran'] = $peran;

            $alert = "<div class='bg-green-500 text-white text-center p-3 rounded-lg mb-4'>Login berhasil! Selamat datang, $nama!</div>";
            header("refresh:2;url=index.php"); // redirect setelah 2 detik
            exit;
        } else {
            $alert = "<div class='bg-red-500 text-white text-center p-3 rounded-lg mb-4'>Password salah! Coba lagi.</div>";
        }
    } else {
        $alert = "<div class='bg-red-500 text-white text-center p-3 rounded-lg mb-4'>Email tidak ditemukan! Pastikan email yang dimasukkan benar.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Login Perpustakaan</h2>

        <?php echo $alert; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-600">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" placeholder="Masukkan email" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Login</button>
        </form>

        <p class="mt-4 text-center text-gray-600">
            Belum punya akun? <a href="register.php" class="text-blue-500 hover:underline">Daftar</a>
        </p>
    </div>

</body>
</html>
