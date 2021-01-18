<?php

namespace App\Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Código adaptado
 * Recurso original encontrado em: https://www.youtube.com/watch?v=VOYnS_1qA8w
 */

use stdClass;

class Email
{
    private $mail;
    private $data;
    private $error;

    public function __construct()
    {
        // Instantiation and passing `true` enables exceptions
        $this->mail = new PHPMailer(true);
        $this->data = new stdClass;

        $this->mail->isSMTP();
        $this->mail->SMTPAuth   = true;
        $this->mail->isHTML();
        $this->mail->setLanguage('br');

        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        // $this->mail->Charset = 'utf-8';

        // Auth
        $this->mail->Host = $_ENV['MAILER_HOST'];
        $this->mail->Port = $_ENV['MAILER_PORT'];
        $this->mail->Username = $_ENV['MAILER_USERNAME'];
        $this->mail->Password = $_ENV['MAILER_PASSWORD'];
    }

    public function add(string $subject, $body, string $recipient_name, string $recipient_email): Email
    {
        $this->data->subject = utf8_decode($subject);
        $this->data->body = utf8_decode($body);
        $this->data->recipient_name = utf8_decode($recipient_name);
        $this->data->recipient_email = utf8_decode($recipient_email);

        return $this;
    }

    public function attach(string $filePath, string $fileName)
    {
        $this->data->attach[$filePath] = $fileName;
    }

    public function send(): bool
    {
        $from_name = $_ENV['MAILER_FROM_NAME'];
        $from_email = $_ENV['MAILER_FROM_EMAIL'];

        try {
            $this->mail->Subject = $this->data->subject;
            $this->mail->msgHTML($this->data->body);
            $this->mail->addAddress($this->data->recipient_email, $this->data->recipient_name);
            $this->mail->setFrom($from_email, $from_name);

            if (!empty($this->data->attach)) {
                foreach ($this->data->attach as $path => $name) {
                    $this->mail->addAttachment($path, $name);
                }
            }

            $this->mail->send();
            return true;
        } catch (Exception $exception) {
            $this->error = $exception;
            return false;
        }
    }

    public function error(): ?Exception
    {
        return $this->error;
    }
}
