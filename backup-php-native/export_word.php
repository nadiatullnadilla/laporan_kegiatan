<?php
include 'session_login.php';
admin_atau_verifikator();
include 'koneksi.php';

$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT * FROM laporan";
if ($filter_status != '' && in_array($filter_status, ['menunggu', 'disetujui', 'revisi'])) {
    $sql .= " WHERE status = '$filter_status'";
}
$sql .= " ORDER BY tanggal DESC, id DESC";

$query = mysqli_query($conn, $sql);

header("Content-type: application/msword");
header("Content-Disposition: attachment; filename=rekap_laporan.doc");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Laporan</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2, p { text-align: center; margin: 0; }
        p { margin-bottom: 20px; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            font-size: 12px;
        }
        th {
            background: #eeeeee;
        }
    </style>
</head>
<body>
    <h2>Rekap Laporan Kegiatan</h2>
    <p>Status:
        <?php echo ($filter_status != '') ? htmlspecialchars($filter_status) : 'Semua Status'; ?>
    </p>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Kegiatan</th>
            <th>Tanggal</th>
            <th>Tempat</th>
            <th>Jam</th>
            <th>Status</th>
        </tr>

        <?php if (mysqli_num_rows($query) > 0) { ?>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($query)) { ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['nama_kegiatan']); ?></td>
                <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                <td><?php echo htmlspecialchars($row['tempat']); ?></td>
                <td><?php echo htmlspecialchars($row['jam']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6" style="text-align:center;">Tidak ada data laporan.</td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>