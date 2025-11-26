<?php
// Đọc file Quiz.txt
$filename = "Quiz.txt";
$questions = [];

if (file_exists($filename)) {

    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $temp = [];

    foreach ($lines as $line) {

        // Nếu gặp ANSWER → hoàn tất 1 câu
        if (strpos($line, "ANSWER:") === 0) {

            $question = $temp[0];
            $choices = [];

            // Xử lý các đáp án A,B,C,D,E...
            for ($i = 1; $i < count($temp); $i++) {
                $label = substr($temp[$i], 0, 1);     // lấy ký tự A/B/C/D/E
                $text  = substr($temp[$i], 3);        // bỏ "A. "
                $choices[$label] = $text;
            }

            // Lấy đáp án đúng, hỗ trợ nhiều đáp án
            $answer = trim(str_replace("ANSWER:", "", $line));
            $answerArray = array_map('trim', explode(',', $answer));

            $questions[] = [
                "question" => $question,
                "choices" => $choices,
                "answer" => $answerArray
            ];

            $temp = [];
        } else {
            $temp[] = $line;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>CÂU HỎI TRẮC NGHIỆM</title>
    <style>
        body { font-family: Arial; width: 900px; margin: auto; }
        .question-box { background: #f4f4f4; padding: 15px; margin-bottom: 20px; border-radius: 8px; }
        .correct { background: #d2ffd2; padding: 10px; margin-top: 10px; border-left: 5px solid #2ecc71; }
        .wrong { background: #ffd2d2; padding: 10px; margin-top: 10px; border-left: 5px solid #e74c3c; }
        .result-box { font-size: 20px; margin-top: 30px; padding: 15px; background: #d5fdd5; border-left: 6px solid green; display:none; }
        button { padding: 10px 20px; font-size: 16px; cursor: pointer; }
    </style>
</head>
<body>

<h1>CÂU HỎI TRẮC NGHIỆM</h1>

<?php foreach ($questions as $i => $q): ?>
<div class="question-box">
    <h3><?= ($i + 1) . ". " . $q['question'] ?></h3>

    <?php foreach ($q['choices'] as $key => $value): ?>
        <label>
            <input type="checkbox" name="q<?= $i ?>[]" value="<?= $key ?>" 
                onclick="checkAnswer(<?= $i ?>)">
            <?= $key ?>. <?= $value ?>
        </label><br>
    <?php endforeach; ?>

    <div id="result<?= $i ?>"></div>
</div>

<script>
    window.correct<?= $i ?> = <?= json_encode($q['answer'], JSON_UNESCAPED_UNICODE) ?>;
    window.text<?= $i ?> = <?= json_encode($q['choices'], JSON_UNESCAPED_UNICODE) ?>;
</script>

<?php endforeach; ?>

<!-- Nút nộp bài -->
<button onclick="submitExam()">Nộp bài</button>
<div id="finalResult" class="result-box"></div>

<script>
function checkAnswer(index) {
    let correct = window["correct" + index]; // mảng đáp án đúng
    let answers = window["text" + index];   // nội dung các đáp án
    let box = document.getElementById("result" + index);

    // Lấy tất cả checkbox đã chọn
    let checked = Array.from(document.querySelectorAll(`input[name='q${index}[]']:checked`))
                       .map(c => c.value);

    // Chỉ đánh giá khi đã chọn đủ số lượng đáp án đúng
    if (checked.length < correct.length) {
        box.innerHTML = ""; // chưa đủ số đáp án → không hiện gì
        return;
    }

    // Kiểm tra: chọn đủ và không thừa
    let isCorrect = checked.length === correct.length &&
                    checked.every(c => correct.includes(c));

    if (isCorrect) {
        box.innerHTML = `<div class="correct">✔ Chính xác!<br>Đáp án: <strong>${correct.join(', ')}</strong></div>`;
    } else {
        box.innerHTML = `<div class="wrong">✘ Sai rồi!<br>Đáp án: <strong>${correct.join(', ')}</strong></div>`;
    }
}


// Nộp bài, tính điểm
function submitExam() {
    let total = <?= count($questions) ?>;
    let score = 0;

    for (let i = 0; i < total; i++) {
        let correct = window["correct" + i];
        let checked = Array.from(document.querySelectorAll(`input[name='q${i}[]']:checked`))
                           .map(c => c.value);

        if (checked.length === correct.length &&
            checked.every(c => correct.includes(c))) {
            score++;
        }
    }

    let grade = (score / total) * 10;
    grade = grade.toFixed(1);

    let box = document.getElementById("finalResult");
    box.style.display = "block";
    box.innerHTML = `
        <div>
            Bạn trả lời đúng <strong>${score} / ${total}</strong> câu<br>
            Điểm của bạn: <strong>${grade} / 10</strong>
        </div>
    `;
}
</script>

</body>
</html>
