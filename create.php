<!DOCTYPE html>
<html>
<head>
    <title>Data Barang Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url('tumpukanbarang.jpg') no-repeat center center fixed; /* Menggunakan gambar sebagai background */
            background-size: cover; /* Menyesuaikan gambar dengan ukuran layar */
            color: white;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            background: white;
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0,0,0,0.3), 0 6px 20px rgba(0,0,0,0.19); /* Gradasi bayangan */
            padding: 20px; /* Padding lebih kecil */
            margin-top: 40px; /* Margin atas lebih besar */
            color: black;
            max-width: 400px; /* Lebar maksimum kontainer */
            margin-left: auto;
            margin-right: auto;
        }
        .form-control, .btn-primary, .btn-secondary {
            border-radius: 10px; /* Rounded corners lebih kecil */
            box-shadow: 0 4px 8px rgba(0,0,0,0.3), 0 6px 20px rgba(0,0,0,0.19); /* Gradasi bayangan */
            padding: 12px; /* Padding lebih besar */
            margin-bottom: 10px; /* Margin bawah */
        }
        .btn-primary {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
        }
        .btn-secondary {
            background: linear-gradient(to right, #ff416c, #ff4b2b); /* Gradasi merah */
            border: none;
        }
        .form-control:focus, .btn-primary:focus, .btn-secondary:focus {
            transform: scale(1.05); /* Pembesaran saat fokus */
            transition: transform 0.3s ease; /* Transisi yang halus */
        }
        .btn-secondary:hover {
            transform: scale(1.1); /* Pembesaran saat hover */
            transition: transform 0.3s ease; /* Transisi yang halus */
        }

        @keyframes bergerak {
            0% { transform: translateX(0); }
            50% { transform: translateX(20px); }
            100% { transform: translateX(0); }
        }

        .h2-animasi {
            animation: bergerak 2s ease-in-out infinite;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5); /* Menambahkan bayangan teks */
            text-align: center;
        }
    </style>
</head>
<body onload="stopAnimation()">
<div class="container">
    <?php
    include "koneksi.php"; // Pastikan file ini terhubung ke database penjualanbarang

    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $kode_barang = input($_POST["kode_barang"]);
        $nama_barang = input($_POST["nama_barang"]);
        $persediaan = input($_POST["persediaan"]);
        $harga_awal = input($_POST["harga_awal"]);

        // Cek apakah kode_barang sudah ada
        $cekKodeBarang = mysqli_query($kon, "SELECT kode_barang FROM barang WHERE kode_barang = '$kode_barang'");
        if (mysqli_num_rows($cekKodeBarang) > 0) {
            echo "<div class='alert alert-danger'>Kode Barang sudah terdaftar.</div>";
        } else {
            $sql = "INSERT INTO barang (kode_barang, nama_barang, persediaan, harga_awal) VALUES ('$kode_barang', '$nama_barang', '$persediaan', '$harga_awal')";
            $hasil = mysqli_query($kon, $sql);

            if ($hasil) {
                echo "<div class='alert alert-success'>Data berhasil disimpan.</div>";
                header("Location: index.php");
            } else {
                echo "<div class='alert alert-danger'>Data gagal disimpan.</div>";
            }
        }
    }
    ?>
    <h2 class="h2-animasi">Input Data Barang</h2>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>Kode Barang:</label>
            <input type="text" name="kode_barang" class="form-control" placeholder="Masukan Kode Barang" required>
        </div>
        <div class="form-group">
            <label>Nama Barang:</label>
            <input type="text" name="nama_barang" class="form-control" placeholder="Masukan Nama Barang" required>
        </div>
        <div class="form-group">
            <label>Persediaan:</label>
            <input type="text" name="persediaan" class="form-control" placeholder="Masukan Persediaan" required>
        </div>
        <div class="form-group">
            <label>Harga Awal:</label>
            <input type="number" name="harga_awal" class="form-control" placeholder="Masukan Harga Awal" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" onclick="window.location='index.php';">Cancel</button>
    </form>
</div>
<script>
    function stopAnimation() {
        document.querySelector('.h2-animasi').style.animation = 'none';
    }
</script>
</body>
</html>
