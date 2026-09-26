<?php
header('Content-Type: application/json; charset=utf-8');

$formType = $_POST['form_type'] ?? '';
$name     = strip_tags(trim($_POST['name'] ?? ''));
$phone    = strip_tags(trim($_POST['phone'] ?? ''));
$question = strip_tags(trim($_POST['question'] ?? ''));
$city     = strip_tags(trim($_POST['city'] ?? ''));
$company  = strip_tags(trim($_POST['company'] ?? ''));
$email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);

$to      = $email ?: 'info@mir-robot.by';
$subject = 'Новая заявка с сайта Мир Робот';

switch ($formType) {
    case 'trial':
        $subject = 'Запись на пробный урок';
        $body = "Имя ребёнка: $name\nТелефон родителя: $phone\nГород: $city\nКомпания: $company\nEmail: $email";
        break;
    case 'franchise':
        $subject = 'Запрос на франшизу';
        $body = "Имя: $name\nТелефон: $phone\nГород: $city\nКомпания: $company\nEmail: $email";
        break;
    case 'question':
        $subject = 'Вопрос от клиента';
        $body = "Имя: $name\nВопрос: $question\nГород: $city\nКомпания: $company\nEmail: $email";
        break;
    case 'signup':
        $subject = 'Запись на пробный урок';
        $body = "Имя ребёнка: $name\nТелефон родителя: $phone\nГород: $city\nКомпания: $company\nEmail: $email";
        break;
    default:
        $subject = 'Новая заявка с сайта';
        $body = "Имя: $name\nТелефон: $phone\nВопрос: $question\nГород: $city\nКомпания: $company\nEmail: $email";
}

$headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";

$sent = @mail($to, $subject, $body, $headers);

if ($sent) {
    echo json_encode(['success' => true, 'message' => 'Заявка отправлена!']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Ошибка отправки.']);
}
