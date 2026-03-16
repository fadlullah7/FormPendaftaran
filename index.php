<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    
    $nama     = $_POST['nama'];
    $tempat   = $_POST['tempat'];
    $tanggal  = $_POST['tanggal'];
    $agama    = $_POST['agama'];
    $alamat   = $_POST['alamat'];
    $notelp   = $_POST['notelp'];

    
    $jk = isset($_POST['jk']) ? $_POST['jk'] : null;
    if ($jk === "Pria") {
        $jkValue = 0;
    } elseif ($jk === "Wanita") {
        $jkValue = 1;
    } else {
        $jkValue = null;
    }

   
    $hobi = null;
    if (!empty($_POST['hobi'])) {
        $hobi = implode(", ", $_POST['hobi']);
    }

   
    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $target = "uploads/" . basename($_FILES['foto']['name']);
        if (!is_dir("uploads")) {
            mkdir("uploads");
        }
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
            $foto = $target;
        }
    }

    
    $sql = "INSERT INTO peserta (nama, \"tempatLahir\", \"tanggalLahir\", agama, alamat, telepon, jk, hobi, foto)
            VALUES (:nama, :tempatLahir, :tanggalLahir, :agama, :alamat, :telepon, :jk, :hobi, :foto)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama'        => $nama,
        ':tempatLahir' => $tempat,
        ':tanggalLahir'=> $tanggal,
        ':agama'       => $agama,
        ':alamat'      => $alamat,
        ':telepon'     => $notelp,
        ':jk'          => $jkValue,
        ':hobi'        => $hobi,
        ':foto'        => $foto
    ]);
    
    echo "<p>Data berhasil disimpan ke database!</p>";
     header("Location: index.php"); 
    exit;

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulir Pendaftaran Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Formulir Pendaftaran Siswa</h2>

    <form method="POST" enctype="multipart/form-data">
        <label>Nama Calon Siswa</label>
        <input type="text" name="nama" required>

        <label>Tempat Lahir</label>
        <input type="text" name="tempat" required>

        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal" required>

        <label>Agama</label>
        <select name="agama">
            <option>Islam</option>
            <option>Kristen</option>
            <option>Katolik</option>
            <option>Hindu</option>
            <option>Buddha</option>
            <option>Konghucu</option>
        </select>

        <label>Alamat</label>
        <textarea name="alamat"></textarea>

        <label>No Telp/HP</label>
        <input type="text" name="notelp">

        <label>Jenis Kelamin</label>
        <div class="inline">
            <input type="radio" name="jk" value="Pria"> Pria
            <input type="radio" name="jk" value="Wanita"> Wanita
        </div>
        
        <label>Hobi</label>
        <div class="inline">
            <input type="checkbox" name="hobi[]" value="Membaca"> Membaca
            <input type="checkbox" name="hobi[]" value="Menulis"> Menulis
            <input type="checkbox" name="hobi[]" value="Olahraga"> Olahraga
        </div>

        <label>Pas Foto</label>
        <input type="file" name="foto">

        <button type="submit" name="submit">SUBMIT</button>
    </form>
</div>

<div class="container">
    <h2>Data Pendaftaran Siswa</h2>

    <table border="1" cellpadding="5">
        <tr>
            <th rowspan="2">Nama</th>
            <th colspan="2">Lahir</th>
            <th rowspan="2">No Telp</th>
            <th rowspan="2">Agama</th>
        </tr>
        <tr>
            <th>Tempat</th>
            <th>Tanggal</th>
        </tr>

        <?php
        $query = "SELECT * FROM peserta";
        $result = $pdo->query($query);

        foreach ($result as $data) : ?>
            <tr>
                <td><?= htmlspecialchars($data['nama']); ?></td>
                <td><?= htmlspecialchars($data['tempatLahir']); ?></td>
                <td><?= date("d F Y", strtotime($data['tanggalLahir'])); ?></td>
                <td><?= htmlspecialchars($data['telepon']); ?></td>
                <td><?= htmlspecialchars($data['agama']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>

