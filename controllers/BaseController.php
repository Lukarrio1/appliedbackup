<?php

require_once '../core/Database.php';
require_once '../traits/validation.php';
require_once '../helpers/query.php';
require_once '../traits/sanitize.php';
require_once '../traits/file.php';
require_once '../traits/tempStorage.php';
require_once '../traits/Notification.php';
require_once '../traits/User.php';

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Base extends Database
{
    use validator;
    use Sanitize;
    use Helpers;
    use File;
    use State;
    use Notification;
    use User_trait;

    public function getDate()
    {
        return date('M j, Y h:ia', strtotime("now"));
    }

    public function mail($subject, $body, $email)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
            $mail->isSMTP(); // Send using SMTP
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'tomennis1997@gmail.com'; // SMTP username
            $mail->Password = 'Terrybinns1'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port = 587; // TCP port to connect to

            //Recipients
            $mail->setFrom('Carrium@gmail.com', 'Carrium');
            $mail->addAddress($email);
            $mail->addReplyTo('noreply@gmail.com', 'Information');
            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
        } catch (Exception $e) {
            die("Message could not be sent. Mailer Error: $mail->ErrorInfo");
        }
    }
}
