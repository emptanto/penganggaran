<?php
include 'views/layouts/header.php';
require 'config/db.php';
require_once 'controllers/RencanaController.php';

$rencanaController = new RencanaController($conn);
$isSuperadmin = ($_SESSION['role'] === 'superadmin');
$userId = $_SESSION['user_id'];

$filter_kegiatan = $_GET['filter_kegiatan'] ?? '';
$filter_rekening = $_GET['filter_rekening'] ?? '';
$filter_bulan = $_GET['filter_bulan'] ?? '';
$filter_user = $_GET['filter_user'] ?? '';

if (isset($_GET['export']) && $_GET['export'] === 'excel') {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=rencana_penganggaran.xls");
    echo "<table border='1'>";
    echo "<tr><th>No</th><th>Nama Kegiatan</th><th>Nama Rekening</th><th>Nama Rencana</th><th>Jumlah Rencana</th><th>Jumlah Kegiatan</th><th>Satuan</th><th>Total</th><th>Bulan</th><th>Pengaju</th></tr>";

    $query = "SELECT rencana.*, kegiatan.nama_kegiatan, rekening.nama_rekening, users.username
              FROM rencana
              JOIN kegiatan ON rencana.kegiatan_id = kegiatan.id
              JOIN rekening ON rencana.rekening_id = rekening.id
              JOIN users ON rencana.user_id = users.id
              WHERE 1=1";

    if (!$isSuperadmin) {
        $query .= " AND rencana.user_id = $userId";
    }
    if (!empty($filter_kegiatan)) {
        $query .= " AND kegiatan.id = '$filter_kegiatan'";
    }
    if (!empty($filter_rekening)) {
        $query .= " AND rekening.id = '$filter_rekening'";
    }
    if (!empty($filter_bulan)) {
        $query .= " AND bulan = '$filter_bulan'";
    }
    if ($isSuperadmin && !empty($filter_user)) {
        $query .= " AND users.id = '$filter_user'";
    }

    $result = $conn->query($query);
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        $total = $row['jumlah_rencana'] * $row['jumlah_kegiatan'] * $row['harga_satuan'];
        echo "<tr>
                <td>$no</td>
                <td>{$row['nama_kegiatan']}</td>
                <td>{$row['nama_rekening']}</td>
                <td>{$row['nama_rencana']}</td>
                <td>{$row['jumlah_rencana']}</td>
                <td>{$row['jumlah_kegiatan']}</td>
                <td>{$row['satuan']}</td>
                <td>" . number_format($total, 2) . "</td>
                <td>{$row['bulan']}</td>
                <td>{$row['username']}</td>
              </tr>";
        $no++;
    }
    echo "</table>";
    exit;
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$query = "SELECT rencana.*, kegiatan.kode_kegiatan, kegiatan.nama_kegiatan, rekening.kode_rekening, rekening.nama_rekening, users.username
          FROM rencana
          JOIN kegiatan ON rencana.kegiatan_id = kegiatan.id
          JOIN rekening ON rencana.rekening_id = rekening.id
          JOIN users ON rencana.user_id = users.id
          WHERE 1=1";

if (!$isSuperadmin) {
    $query .= " AND rencana.user_id = $userId";
}
if (!empty($filter_kegiatan)) {
    $query .= " AND kegiatan.id = '$filter_kegiatan'";
}
if (!empty($filter_rekening)) {
    $query .= " AND rekening.id = '$filter_rekening'";
}
if (!empty($filter_bulan)) {
    $query .= " AND bulan = '$filter_bulan'";
}
if ($isSuperadmin && !empty($filter_user)) {
    $query .= " AND users.id = '$filter_user'";
}

$query .= " ORDER BY rencana.id DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

$countQuery = "SELECT COUNT(*) as total FROM rencana
               JOIN kegiatan ON rencana.kegiatan_id = kegiatan.id
               JOIN rekening ON rencana.rekening_id = rekening.id
               JOIN users ON rencana.user_id = users.id
               WHERE 1=1";
if (!$isSuperadmin) {
    $countQuery .= " AND rencana.user_id = $userId";
}
if (!empty($filter_kegiatan)) {
    $countQuery .= " AND kegiatan.id = '$filter_kegiatan'";
}
if (!empty($filter_rekening)) {
    $countQuery .= " AND rekening.id = '$filter_rekening'";
}
if (!empty($filter_bulan)) {
    $countQuery .= " AND bulan = '$filter_bulan'";
}
if ($isSuperadmin && !empty($filter_user)) {
    $countQuery .= " AND users.id = '$filter_user'";
}
$totalResult = $conn->query($countQuery)->fetch_assoc();
$totalPages = ceil($totalResult['total'] / $limit);

$kegiatanList = $conn->query("SELECT * FROM kegiatan");
$rekeningList = $conn->query("SELECT * FROM rekening");
$userList = $conn->query("SELECT id, username FROM users");
$bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
?>

<div class="container mt-4">
  <h2 class="mb-4">Rencana Penganggaran</h2>

  <div class="card mb-4">
    <div class="card-body">
      <?php include 'rencana_form.php'; ?>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-body">
      <?php include 'rencana_filter.php'; ?>
      <a href="?filter_kegiatan=<?= $filter_kegiatan ?>&filter_rekening=<?= $filter_rekening ?>&filter_bulan=<?= $filter_bulan ?>&filter_user=<?= $filter_user ?>&export=excel" class="btn btn-success mb-3">Export ke Excel</a>

      <table class="table table-bordered table-striped table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Kegiatan</th>
            <th>Nama Rekening</th>
            <th>Nama Rencana</th>
            <th>Jumlah Rencana</th>
            <th>Jumlah Kegiatan</th>
            <th>Satuan</th>
            <th>Total</th>
            <th>Bulan</th>
            <th>Pengaju</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = $offset + 1; $grandTotal = 0; ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <?php $total = $row['jumlah_rencana'] * $row['jumlah_kegiatan'] * $row['harga_satuan']; ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $row['nama_kegiatan'] ?></td>
              <td><?= $row['nama_rekening'] ?></td>
              <td><?= $row['nama_rencana'] ?></td>
              <td><?= $row['jumlah_rencana'] ?></td>
              <td><?= $row['jumlah_kegiatan'] ?></td>
              <td><?= $row['satuan'] ?></td>
              <td><?= number_format($total, 2) ?></td>
              <td><?= $row['bulan'] ?></td>
              <td><?= $row['username'] ?></td>
              <td>
                <a href="rencana_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="rencana_delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
              </td>
            </tr>
            <?php $grandTotal += $total; ?>
          <?php endwhile; ?>
        </tbody>
      </table>
      <p><strong>Grand Total: <?= number_format($grandTotal, 2) ?></strong></p>

      <nav>
        <ul class="pagination">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>&filter_kegiatan=<?= $filter_kegiatan ?>&filter_rekening=<?= $filter_rekening ?>&filter_bulan=<?= $filter_bulan ?>&filter_user=<?= $filter_user ?>"> <?= $i ?> </a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    </div>
  </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
