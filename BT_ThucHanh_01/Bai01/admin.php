<?php include "flowers.php"; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý hoa</title>
    <style>
        body { font-family: Arial; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 8px; }
        th { background: #eee; }
        img { width: 80px; border-radius: 4px; }
        a { text-decoration: none; color: blue; }
    </style>
</head>

<body>
    <h1>Trang Quản Trị Các Loài Hoa</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Ảnh</th>
            <th>Tên hoa</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>

        <?php foreach ($flowers as $f): ?>
        <tr>
            <td><?= $f['id'] ?></td>
            <td><img src="hoadep/<?= $f['img'] ?>"></td>
            <td><?= $f['name'] ?></td>
            <td><?= $f['desc'] ?></td>
            <td>
                <a href="edit.php?id=<?= $f['id'] ?>">Sửa</a> |
                <a href="delete.php?id=<?= $f['id'] ?>">Xoá</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="add.php">+ Thêm loài hoa mới</a>
</body>
</html>
