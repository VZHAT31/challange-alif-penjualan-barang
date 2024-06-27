<?php
include "koneksi.php";
session_start();

// Tentukan jumlah data per halaman
$jumlahDataPerHalaman = 5;
$jumlahData = mysqli_num_rows(mysqli_query($kon, "SELECT * FROM barang"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? (int)$_GET["halaman"] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$query = "SELECT * FROM barang ORDER BY kode_barang LIMIT $awalData, $jumlahDataPerHalaman";
$hasil = mysqli_query($kon, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>TABLE BARANG PENJUALAN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="logotrkjbg.png">
    <style>
        /* Menambahkan gradasi pada header tabel */
        .table-primary {
            background-color: #6f42c1; /* Warna ungu */
            color: black; /* Mengubah warna teks menjadi hitam */
            font-weight: bold; /* Membuat teks menjadi tebal */
        }
        /* Menambahkan bayangan pada tabel */
        .table {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.3);
            color: black; /* Mengubah warna teks seluruh tabel menjadi hitam */
        }
        /* Menambahkan gradasi pada navbar */
        .navbar-dark.bg-dark {
            background-image: linear-gradient(to right, #434343 0%, black 100%);
        }
        /* Menambahkan efek hover pada tombol */
        .btn:hover {
            opacity: 0.7;
            transition: opacity 0.3s ease; /* Menambahkan transisi pada efek hover */
        }
        /* Menambahkan efek teks pada judul */
        h4 {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        /* Mengubah font seluruh halaman ke Times New Roman dengan warna hitam dan tebal */
        body {
            font-family: 'Times New Roman', Times, serif;
            color: black; /* Menetapkan warna teks menjadi hitam */
            font-weight: bold; /* Membuat teks menjadi tebal */
        }
        /* Menambahkan efek hover dengan bayangan pada tombol khusus */
        .btn-primary, .btn-warning, .btn-danger, .btn-info {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: box-shadow 0.3s ease; /* Transisi untuk efek bayangan */
        }
        .btn-primary:hover, .btn-warning:hover, .btn-danger:hover, .btn-info:hover {
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.4);
        }
        /* Menambahkan transisi halus pada navigasi halaman */
        .pagination a {
            transition: background-color 0.3s ease;
        }
        .pagination a:hover {
            background-color: #ddd; /* Warna latar saat hover */
        }
        /* Menambahkan kelas CSS untuk rounded button */
        .btn-rounded {
            border-radius: 20px; /* Memberikan efek rounded */
        }
        /* Menambahkan efek hover pada baris tabel */
        .table-hover tbody tr:hover {
            background-color: #f1f1f1; /* Warna latar saat hover */
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">CHALLANGE ALIF RIDWAN PAHLEFI</span>
        <a href="create.php" class="btn btn-primary btn-rounded" role="button">Tambah Data</a>
    </nav>
    <div class="container text-center"> 
        <br>
        <h4><center>DATA BARANG PENJUALAN</center></h4>
        <?php
        if (isset($_GET['kode_barang'])) {
            $kode_barang = htmlspecialchars($_GET["kode_barang"]);
            $sql = "DELETE FROM barang WHERE kode_barang='$kode_barang'";
            $hasil = mysqli_query($kon, $sql);

            if ($hasil) {
                header("Location: index.php");
            } else {
                echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
            }
        }
        ?>

        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr class="table-primary">
                    <th style="text-align:center;">NO</th>
                    <th style="text-align:center;">KODE BARANG</th>
                    <th style="text-align:center;">NAMA BARANG</th>
                    <th style="text-align:center;">PERSEDIAAN</th>
                    <th style="text-align:center;">HARGA AWAL</th>
                    <th style="text-align:center;">JUMLAH</th>
                    <th colspan='2' style="text-align:center;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM barang ORDER BY kode_barang ASC";
                $hasil = mysqli_query($kon, $sql);
                $no = 0;
                while ($data = mysqli_fetch_array($hasil)) {
                    $no++;
                    $jumlah = $data["persediaan"] * $data["harga_awal"]; // Perkalian otomatis
                    ?>
                    <tr>
                        <td style="text-align:center;"><?php echo $no; ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["kode_barang"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["nama_barang"]); ?></td>
                        <td style="text-align:center;"><?php echo htmlspecialchars($data["persediaan"]); ?></td>
                        <td style="text-align:center;">Rp. <?php echo htmlspecialchars($data["harga_awal"]); ?></td>
                        <td style="text-align:center;">Rp. <?php echo htmlspecialchars($jumlah); ?></td> <!-- Tampilkan hasil perkalian -->
                        <td style="text-align:center;">
                            <a href="update.php?kode_barang=<?php echo htmlspecialchars($data['kode_barang']); ?>" class="btn btn-warning btn-rounded" role="button">Update</a>
                            <a href="javascript:void(0);" onclick="confirmDelete('<?php echo htmlspecialchars($data['kode_barang']); ?>')" class="btn btn-danger btn-rounded" role="button">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function confirmDelete(kode_barang) {
            if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                window.location.href = '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?kode_barang=' + kode_barang;
            }
        }
    </script>
</body>
</html>