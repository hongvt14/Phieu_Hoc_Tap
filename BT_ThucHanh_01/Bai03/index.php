<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đọc Tệp Tin CSV Bằng PHP</title>
    <style>
        /* CSS đơn giản để dễ nhìn */
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f8f9fa; }
        .container { max-width: 1200px; margin: auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #dee2e6; padding: 10px; text-align: left; }
        th { background-color: #007bff; color: white; font-weight: bold; position: sticky; top: 0; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #ddd; }
        .error { color: red; font-weight: bold; margin-top: 15px; }
    </style>
</head>
<body>

    <div class="container">
        <h2>📚 Danh Sách Tài Khoản Đọc Từ Tệp CSV</h2>

        <?php
        // 1. Khai báo đường dẫn đến tệp tin CSV
        $filename = '65HTTT_Danh_sach_diem_danh.csv';
        
        // 2. Kiểm tra sự tồn tại của tệp tin
        if (!file_exists($filename)) {
            echo "<p class='error'>Lỗi: Không tìm thấy tệp tin **{$filename}**. Vui lòng đảm bảo tệp tin nằm cùng thư mục.</p>";
        } else {
            // 3. Mở tệp tin để đọc
            // 'r' là chế độ chỉ đọc.
            // Cú pháp '@' dùng để ngăn chặn hiển thị lỗi nếu không mở được file (ví dụ: permission denied)
            $file = @fopen($filename, 'r');
            
            if ($file === false) {
                echo "<p class='error'>Lỗi: Không thể mở tệp tin **{$filename}**. Vui lòng kiểm tra quyền truy cập.</p>";
            } else 
            {
                // Khởi tạo biến để lưu trữ dữ liệu
                $header = [];
                $data = [];
                $row_count = 0;

                // 4. Đọc dữ liệu từ tệp tin, sử dụng fgetcsv() để xử lý các dấu phẩy, kể cả khi chúng nằm trong dấu ngoặc kép.
                // Hàm này tự động phân tách các cột dựa trên dấu phân cách (mặc định là ',').
                while (($row = fgetcsv($file)) !== false) {
                    // Dòng đầu tiên là tiêu đề
                    if ($row_count === 0) {
                        $header = $row;
                    } else {
                        // Các dòng còn lại là dữ liệu
                        $data[] = $row;
                    }
                    $row_count++;
                }

                // 5. Đóng tệp tin
                fclose($file);

                // 6. Hiển thị dữ liệu
                if (count($data) > 0 || !empty($header)) {
                    echo '<table>';
    
                    // Khởi tạo biến đếm số thứ tự
                    $stt = 1; // <--- KHỞI TẠO BIẾN STT TẠI ĐÂY

                    // Hiển thị Tiêu đề (Header)
                    echo '<thead><tr>';
                    
                    // THÊM CỘT STT VÀO TIÊU ĐỀ
                    echo '<th>STT</th>'; // <--- THÊM THẺ TH NÀY
                    
                    foreach ($header as $col_name) {
                        // Thêm htmlspecialchars để phòng tránh XSS và trim() để loại bỏ khoảng trắng dư thừa.
                        echo '<th>' . htmlspecialchars(trim($col_name)) . '</th>';
                    }
                    echo '</tr></thead>';

                    // Hiển thị Nội dung (Body)
                    echo '<tbody>';
                    foreach ($data as $row) {
                        echo '<tr>';
                        
                        // THÊM CỘT STT VÀO NỘI DUNG
                        echo '<td>' . $stt . '</td>'; // <--- THÊM THẺ TD NÀY
                        
                        foreach ($row as $cell) {
                            echo '<td>' . htmlspecialchars(trim($cell)) . '</td>';
                        }
                        echo '</tr>';
                        
                        // Tăng số thứ tự cho dòng tiếp theo
                        $stt++; // <--- TĂNG BIẾN ĐẾM
                    }
                    echo '</tbody>';
                    echo '</table>';
                    
                    echo "<p style='margin-top: 20px;'>Tổng số tài khoản đã đọc: **" . count($data) . "**</p>";
                } else {
                    echo "<p>Tệp tin CSV không có dữ liệu.</p>";
                }
             }
        }
        ?>
    </div>

</body>
</html>