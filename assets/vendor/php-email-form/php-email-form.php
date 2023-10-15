<?php

class PHP_Email_Form {
  public $to;
  public $from_name;
  public $from_email;
  public $subject;
  public $message;
  public $headers;
  public $smtp;

  public function send() {
    if (empty($this->to) || empty($this->from_name) || empty($this->from_email) || empty($this->subject) || empty($this->message)) {
      return false;
    }

    $this->headers = "From: $this->from_name <$this->from_email>\r\nReply-To: $this->from_email\r\n";
    
    if (!empty($this->smtp)) {
      $this->headers .= "MIME-Version: 1.0\r\n";
      $this->headers .= "Content-type: text/html; charset=utf-8\r\n";

      ini_set("SMTP", $this->smtp['host']);
      ini_set("smtp_port", $this->smtp['port']);
      ini_set("sendmail_from", $this->from_email);
      ini_set("auth_username", $this->smtp['username']);
      ini_set("auth_password", $this->smtp['password']);
    }
    
    return mail($this->to, $this->subject, $this->message, $this->headers);
  }

  public function add_message($content, $label = '', $line_breaks = 1) {
    $content = strip_tags($content);
    
    if (!empty($label)) {
      $this->message .= "<strong>$label:</strong> ";
    }
    
    $this->message .= nl2br($content) . str_repeat("<br>", $line_breaks);
  }
}

?>