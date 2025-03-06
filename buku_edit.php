<?php
require 'koneksi.php';

$pesan = "";
$id = $_GET['id'] ?? null;
$data = null;

if ($id) {
    $result = $conn->query("SELECT * FROM buku WHERE id = $id");
    $data = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $id_kategori = $_POST['id_kategori'];

    $sql = "UPDATE buku SET judul=?, penulis=?, penerbit=?, tahun=?, id_kategori=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $judul, $penulis, $penerbit, $tahun, $id_kategori, $id);

    if ($stmt->execute()) {
        echo "<script>
                setTimeout(() => { window.location.href = 'buku_tampil.php'; }, 2000);
              </script>";
        $pesan = "<div class='bg-green-100 text-green-700 p-3 rounded mb-4'>Buku berhasil diperbarui! Mengalihkan...</div>";
    } else {
        $pesan = "<div class='bg-red-100 text-red-700 p-3 rounded mb-4'>Gagal memperbarui buku.</div>";
    }
}

$kategori = $conn->query("SELECT * FROM kategori_buku");
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
    <title>Edit Buku</title>
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
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Edit Buku</h2>

        <!-- Alert -->
        <?= $pesan ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-600">Judul</label>
                <input type="text" name="judul" value="<?= $data['judul'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600">Penulis</label>
                <input type="text" name="penulis" value="<?= $data['penulis'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600">Penerbit</label>
                <input type="text" name="penerbit" value="<?= $data['penerbit'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600">Tahun</label>
                <input type="number" name="tahun" value="<?= $data['tahun'] ?? '' ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600">Kategori</label>
                <select name="id_kategori" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                    <?php while ($row = $kategori->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>" <?= ($data['id_kategori'] == $row['id']) ? 'selected' : '' ?>>
                            <?= $row['nama_kategori'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Update</button>
        </form>
    </div>

</body>

</html>