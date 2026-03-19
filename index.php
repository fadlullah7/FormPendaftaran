<?php
include 'includes/koneksi.php';

if (isset($_POST['submit'])) {
    
    $nama     = $_POST['nama'];
    $tempat   = $_POST['tempat'];
    $tanggal  = $_POST['tanggal'];
    $agama    = $_POST['agama'];
    $alamat   = $_POST['alamat'];
    $notelp   = $_POST['notelp'];

    $jk = isset($_POST['jk']) ? $_POST['jk'] : null;
    $jkValue = ($jk === "Pria") ? 0 : (($jk === "Wanita") ? 1 : null);

    $hobi = !empty($_POST['hobi']) ? implode(", ", $_POST['hobi']) : null;

    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $target = "uploads/" . basename($_FILES['foto']['name']);
        if (!is_dir("uploads")) mkdir("uploads");
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
            $foto = $target;
        }
    }

    $sql = "INSERT INTO peserta (nama, \"tempatLahir\", \"tanggalLahir\", agama, alamat, telepon, jk, hobi, foto)
            VALUES (:nama, :tempatLahir, :tanggalLahir, :agama, :alamat, :telepon, :jk, :hobi, :foto)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nama'         => $nama,
        ':tempatLahir'  => $tempat,
        ':tanggalLahir' => $tanggal,
        ':agama'        => $agama,
        ':alamat'       => $alamat,
        ':telepon'      => $notelp,
        ':jk'           => $jkValue,
        ':hobi'         => $hobi,
        ':foto'         => $foto
    ]);
    
    header("Location: index.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran Siswa</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3">
</head>
<body>

<div class="container">
    <h2>Formulir Pendaftaran Siswa</h2>
    <form id="formPendaftaran" method="POST" enctype="multipart/form-data">
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
        <input type="file" name="foto" id="inputFoto">
        <img id="preview" src="#" alt="Preview Foto" style="display:none; width:100px; margin-top:10px; border-radius:5px; border:1px solid #ddd;">

        <button type="submit" name="submit">SUBMIT</button>
    </form>
</div>

<div class="container">
    <h2>Data Pendaftaran Siswa</h2>
    
    <input type="text" id="cariSiswa" class="search-box" placeholder="Cari nama siswa...">

    <table class="tabel-data">
        <thead>
            <tr>
                <th rowspan="2">Nama</th>
                <th colspan="2">Lahir</th>
                <th rowspan="2">No Telp</th>
                <th rowspan="2">Agama</th>
                <th rowspan="2">Aksi</th> 
            </tr>
            <tr>
                <th>Tempat</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        
        <tbody id="tabelBody">
            <?php
            $query = "SELECT * FROM peserta ORDER BY id DESC"; 
            $result = $pdo->query($query);

            foreach ($result as $data) : ?>
                <tr>
                    <td><?= htmlspecialchars($data['nama']); ?></td>
                    <td><?= htmlspecialchars($data['tempatLahir']); ?></td>
                    <td><?= date("d F Y", strtotime($data['tanggalLahir'])); ?></td>
                    <td><?= htmlspecialchars($data['telepon']); ?></td>
                    <td><?= htmlspecialchars($data['agama']); ?></td>
                    <td align="center">
                        <a href="edit.php?id=<?= $data['id']; ?>" class="btn-edit">Edit</a>
                        <button type="button" onclick="hapusData('hapus.php?id=<?= $data['id']; ?>')" class="btn-delete">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/script.js"></script>

</body>
</html>