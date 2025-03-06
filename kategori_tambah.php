<?php
require 'koneksi.php';

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kategori = $_POST['nama_kategori'];

    $sql = "INSERT INTO kategori_buku (nama_kategori) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nama_kategori);

    if ($stmt->execute()) {
        echo "<script>
                setTimeout(() => { window.location.href = 'index.php'; }, 2000);
              </script>";
        $pesan = "<div class='bg-green-100 text-green-700 p-3 rounded mb-4'>Kategori berhasil ditambahkan! Mengalihkan...</div>";
    } else {
        $pesan = "<div class='bg-red-100 text-red-700 p-3 rounded mb-4'>Gagal menambahkan kategori.</div>";
    }
}
?>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <nav class="bg-blue-500 p-4 text-white flex justify-between">
        <h1 class="text-lg font-semibold">Perpustakaan</h1>
        <div>
            <a href="buku_tampil.php" class="px-4 py-2 hover:bg-blue-600 rounded">Buku</a>
            <a href="index.php" class="px-4 py-2 hover:bg-blue-600 rounded">Kategori</a>
            <a href="logout.php" class="px-4 py-2 bg-red-600 rounded hover:bg-red-700">Logout</a>
        </div>
    </nav>


    <div class="container mx-auto mt-8 p-6 bg-white shadow-md rounded-lg w-96">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Tambah Kategori</h2>

        <!-- Alert -->
        <?= $pesan ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-600">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" placeholder="Masukkan nama kategori" required>
            </div>

            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition">Tambah</button>
        </form>
    </div>

</body>

</html>