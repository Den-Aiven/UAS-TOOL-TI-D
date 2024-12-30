<?php
$host = 'localhost';
$dbname = 'kerjasama_db'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'read') {
    try {
        $stmt = $pdo->query("SELECT * FROM kerjasama");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($action == 'create') {
    try {
        $stmt = $pdo->prepare("INSERT INTO kerjasama (nama_kerjasama, jenis_kerjasama, nilai_kerjasama, detail_kerjasama, dokumen_kerjasama)
                               VALUES (:nama_kerjasama, :jenis_kerjasama, :nilai_kerjasama, :detail_kerjasama, :dokumen_kerjasama)");
        $stmt->execute([
            ':nama_kerjasama' => $_POST['nama_kerjasama'],
            ':jenis_kerjasama' => $_POST['jenis_kerjasama'],
            ':nilai_kerjasama' => $_POST['nilai_kerjasama'],
            ':detail_kerjasama' => $_POST['detail_kerjasama'],
            ':dokumen_kerjasama' => $_POST['dokumen_kerjasama']
        ]);
        echo "Data kerjasama berhasil ditambahkan!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($action == 'update') {
    try {
        $stmt = $pdo->prepare("UPDATE kerjasama SET 
                               nama_kerjasama = :nama_kerjasama, 
                               jenis_kerjasama = :jenis_kerjasama,
                               nilai_kerjasama = :nilai_kerjasama,
                               detail_kerjasama = :detail_kerjasama,
                               dokumen_kerjasama = :dokumen_kerjasama
                               WHERE id = :id");
        $stmt->execute([
            ':id' => $_POST['id'],
            ':nama_kerjasama' => $_POST['nama_kerjasama'],
            ':jenis_kerjasama' => $_POST['jenis_kerjasama'],
            ':nilai_kerjasama' => $_POST['nilai_kerjasama'],
            ':detail_kerjasama' => $_POST['detail_kerjasama'],
            ':dokumen_kerjasama' => $_POST['dokumen_kerjasama']
        ]);
        echo "Data kerjasama berhasil diperbarui!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($action == 'delete') {
    try {
        $stmt = $pdo->prepare("DELETE FROM kerjasama WHERE id = :id");
        $stmt->execute([':id' => $_GET['id']]);
        echo "Data kerjasama berhasil dihapus!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
