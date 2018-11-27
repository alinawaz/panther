<?php
namespace Panther\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{

	public static function send($from, $subject, $body)
	{
		$mail = new PHPMailer(true);
		try {
		    $mail->SMTPDebug = 2;
		    $mail->isSMTP();
		    $mail->Host = getenv('MAIL_SMTP_HOST');
		    $mail->SMTPAuth = getenv('MAIL_SMTP_AUTH');
		    $mail->Username = getenv('MAIL_SMTP_USERNAME');
		    $mail->Password = getenv('MAIL_SMTP_PASSWORD');
		    $mail->SMTPSecure = getenv('MAIL_SMTP_SECURE');
		    $mail->Port = getenv('MAIL_SMTP_PORT');

		    $mail->setFrom('test@panther.com', 'Panther');
		    $mail->addAddress($from, $from);
		    //$mail->addReplyTo('info@example.com', 'Information');
		    //$mail->addCC('cc@example.com');
		    //$mail->addBCC('bcc@example.com');

		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = $subject;
		    $mail->Body    = $body;

		    $mail->send();
		} catch (Exception $e) {
		    echo 'Mailer Error: ', $mail->ErrorInfo;
		}  
	}

}