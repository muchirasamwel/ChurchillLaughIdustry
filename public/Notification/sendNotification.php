<?php
function mailthis($to,$subject,$message)
	{
		require 'PHPMailer-5.2-stable/PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPKeepAlive = true;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 25;
		$mail->SMTPDebug = 4;
		$mail->Username = 'samkan.sk1.sm@gmail.com';
		$mail->Password = '33151912';
		$mail->setFrom('samkan.sk1.sm@gmail.com',"Samkan");
		$mail->addAddress($to);
		//$mail->addAddress('254714730819@txt.att.net');
		$mail->Subject = $subject;
		$mail->Body = $message;
		//send the message, check for errors
		if (!$mail->send()) {
		    return "error: " . $mail->ErrorInfo;
		} else {
		    return "success";
		}
	}
	if(isset($_POST['to'])&& !is_null($_POST['to'])){

		$data=mailthis($_POST['to'],$_POST['subject'],$_POST['message']);
		echo $data;
	}
	else
	{
		echo mailthis("samkan.sk1.sm@gmail.com","testing","Well i have the message then");
		//$retval = mail ('muchirasamwe@gmail.com',"PHPMailer","testing");
		//echo "$retval";
	}
	
 ?>