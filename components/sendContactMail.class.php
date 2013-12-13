<?php
class sendContactMail
{
    public function __construct($From, $FromName, $AddAddress, $Subject, $Body, $AltBody)
	{
	    $path=TURL::URLBASEROOT;
	    require("{$path}/app.components/class.phpmailer.php");
		
	    $mail = new PHPMailer();
		$mail->IsSMTP();
        $mail->Host=MailEspec::Host;
        $mail->SMTPAuth=true;   
        $mail->Username=MailEspec::Username;
        $mail->Password=MailEspec::Password;
        $mail->From = $From;
        $mail->FromName = $FromName;
        $mail->AddAddress($AddAddress, MailEspec:: AddAddress);
        $mail->IsHTML(true);
        $mail->Subject = $Subject;
        $mail->Body    = $Body;
        $mail->AltBody = $AltBody;
        if(!$mail->Send())
        {
			unset($mail);
            throw new TCoreException ('erro no envio de email');
		}
	}
}
?>