<?php
require 'koneksi.php';
$result = $conn->query("SELECT * FROM kategori_buku");
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
    <title>Daftar Kategori Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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


    <div class="container mx-auto mt-8 p-4 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Daftar Kategori Buku</h2>

        <a href="kategori_tambah.php" class="mb-4 inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah Kategori</a>

        <table class="w-full border-collapse border border-gray-300 mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">No</th>
                    <th class="border p-2">Nama Kategori</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody id="kategoriTable">
                <?php $no = 1;
                while ($row = $result->fetch_assoc()): ?>
                    <tr class="border text-center" id="row-<?= $row['id']; ?>">
                        <td class="border p-2"><?= $no++; ?></td>
                        <td class="border p-2"><?= htmlspecialchars($row['nama_kategori']); ?></td>
                        <td class="border p-2">
                            <a href="kategori_edit.php?id=<?= $row['id']; ?>" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                            <button onclick="hapusKategori(<?= $row['id']; ?>)" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function hapusKategori(id) {
            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "kategori_hapus.php",
                        type: "POST",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Kategori berhasil dihapus.",
                                icon: "success",
                                confirmButtonText: "OK"
                            });
                            $("#row-" + id).remove();
                        },
                        error: function() {
                            Swal.fire({
                                title: "Gagal!",
                                text: "Terjadi kesalahan saat menghapus data.",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    });
                }
            });
        }
    </script>

</body>

</html>