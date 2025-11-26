<?php include "flowers.php"; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách các loài hoa</title>
    <style>
        body { font-family: Arial; background: #f7f7f7; }
        h1 { text-align: center; }
        .flower-box {
            width: 300px;
            background: #fff;
            border-radius: 8px;
            margin: 15px;
            padding: 10px;
            display: inline-block;
            vertical-align: top;
            box-shadow: 0 0 5px #ccc;
        }
        img { width: 100%; border-radius: 5px; }
        h3 { margin: 5px 0; }
    </style>
</head>

<body>
    <h1>14 Loài Hoa Tuyệt Đẹp Xuân – Hè</h1>

    <?php
    $stt = 1; 
    foreach ($flowers as $f): ?>
        <div class="flower-box">
            
            <img src="hoadep/<?= $f['img'] ?>" alt="<?= $f['name'] ?>">
            <h3 class='title'> <?= $stt ++?>.<?= $f['name'] ?></h3>
            <p><?= $f['desc'] ?></p>
        </div>
    <?php endforeach; ?>
    <a href="admin.php">Trang Quản Trị</a>
</body>
</html>
