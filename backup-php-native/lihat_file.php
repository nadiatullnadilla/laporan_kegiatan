<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filepath = "uploads/" . $file;

    if (!file_exists($filepath)) {
        echo "File tidak ditemukan.";
        exit;
    }
} else {
    echo "File tidak valid.";
    exit;
}

$ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat File</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
            text-align: center;
            margin: 0;
        }
        .btn {
            display: inline-block;
            margin: 5px;
            padding: 10px 16px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }
        .download {
            background: #fd7e14;
        }
        .box {
            max-width: 1000px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }
        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        iframe {
            width: 100%;
            height: 600px;
            border: none;
            border-radius: 8px;
        }
        p {
            color: #555;
        }
    </style>
</head>
<body>

    <a href="lihat_laporan.php" class="btn">Kembali ke Lihat Laporan</a>
    <a href="download.php?file=<?php echo urlencode($file); ?>" class="btn download">Download</a>

    <div class="box">
        <p><strong>Nama File:</strong> <?php echo $file; ?></p>
        <p><strong>Ekstensi:</strong> <?php echo $ext; ?></p>

        <?php
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            echo "<img src='$filepath' alt='Preview Gambar'>";
        } elseif ($ext == 'pdf') {
            echo "<iframe src='$filepath'></iframe>";
        } else {
            echo "<p>File ini tidak bisa dipreview. Silakan download file untuk melihat isinya.</p>";
        }
        ?>
    </div>

</body>
</html>