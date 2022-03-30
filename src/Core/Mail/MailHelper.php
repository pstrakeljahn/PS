<?php

namespace PS\Source\Core\Mail;

use PS\Source\Core\ExternalScripts\PHPMailer\PHPMailer;
use PS\Source\Settings\Config;

class MailHelper extends PHPMailer
{
    public function __construct()
    {
        $this->Host = Config::MAIL_HOST;
        $this->Port = Config::MAIL_PORT;
        $this->Username = Config::MAIL_USERNAME;
        $this->Password = Config::MAIL_PASSWORD;
        $this->SMTPSecure = self::ENCRYPTION_STARTTLS;
        $this->isSMTP();
        $this->SMTPAuth = true;
    }

    /**
	* Prepares a Mail, ready to be send
	* 
	* @param string $to Recipient of the mail
    * @param string $subject Subject of the mail
    * @param string $body Body of the mail
    * @param bool $isHtml $body is interpreted as html
    * @param string $altBody Alternative body if display as html fails
	* @return self
	*/
    public function createMail(string $to, string $subject, string $body, bool $isHtml = false, string $altBody = ''): self
    {
        $this->addAddress($to);
        $this->Subject = $subject;
        $this->Body    = $body;
        $this->setFrom(Config::MAIL_USERNAME, Config::MAIL_SENDER);
        $this->isHTML($isHtml);
        $this->AltBody = $altBody;
        return $this;
    }

}
