<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $comment = htmlspecialchars(trim($_POST['comment']));
    
    // Настройки письма
    $to = "mshark579@gmail.com";   // ⚠️ ЗАМЕНИТЕ на свой email
    $subject = "Новая заявка с сайта Темп";
    $message = "Имя: $name\nТелефон: $phone\nEmail: $email\nКомментарий: $comment";
    $headers = "From: no-reply@tulatemp.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";
    
    // Отправляем письмо
    $mailSent = mail($to, $subject, $message, $headers);
    
    // Дополнительно сохраняем в файл (на случай, если письмо не дойдёт)
    $logEntry = date("Y-m-d H:i:s") . " | $name | $phone | $email | $comment\n";
    file_put_contents("leads.txt", $logEntry, FILE_APPEND);
    
    // Возвращаем ответ браузеру (скрипту на странице)
    if ($mailSent) {
        echo "OK";
    } else {
        echo "ERROR";
    }
} else {
    http_response_code(403);
    echo "Forbidden";
}
?>