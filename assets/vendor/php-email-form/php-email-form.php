<?php
class PHP_Email_Form
{
  public $ajax = true;
  public $to;
  public $from_name;
  public $from_email;
  public $subject;
  public $smtp = array('host' => '', 'username' => '', 'password' => '', 'port' => '');
  public $mailer = array('sendmail', '-t');
  public $message = '';

  public function add_message($content, $label, $newline = true)
  {
    if ($newline) {
      $this->message .= '<p><strong>' . $label . ':</strong> ' . nl2br($content) . '</p>';
    } else {
      $this->message .= '<p><strong>' . $label . ':</strong> ' . $content . '</p>';
    }
  }

  public function send()
  {
    $subject = $this->subject;
    $to = $this->to;
    $from_name = $this->from_name;
    $from_email = $this->from_email;

    if (!empty($this->smtp['host']) && !empty($this->smtp['username']) && !empty($this->smtp['password']) && !empty($this->smtp['port'])) {
      ini_set('SMTP', $this->smtp['host']);
      ini_set('smtp_port', $this->smtp['port']);
      ini_set('sendmail_from', $from_email);
      ini_set('smtp_user', $this->smtp['username']);
      ini_set('smtp_pass', $this->smtp['password']);
    } elseif (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
      $this->mailer = array('smtp', '-i', '-t');
    }

    if ($this->ajax) {
      echo $this->message;
      return true;
    } else {
      $headers = array(
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=utf-8',
        'From: ' . $from_name . ' <' . $from_email . '>',
        'Reply-To: ' . $from_email,
        'Subject: ' . $subject,
        'X-Mailer: PHP/' . phpversion()
      );

      $message = '<html><body>';
      $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
      $message .= "<tr style='background: #eee;'><td><strong>Field</strong></td><td><strong>Value</strong></td></tr>";
      $message .= $this->message;
      $message .= "</table>";
      $message .= "</body></html>";

      $success = mail($to, $subject, $message, implode("\r\n", $headers));

      if ($success) {
        return true;
      } else {
        return false;
      }
    }
  }
}
?>