<?php
require 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    if ($conn->query("DELETE FROM kategori_buku WHERE id = $id")) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
