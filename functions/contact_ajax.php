<?php

add_action( 'wp_ajax_nopriv_send-the-mail', 'wip_sent_the_email' );
add_action( 'wp_ajax_send-the-mail', 'wip_sent_the_email' );
function wip_sent_the_email(){
		
		if( isset( $_POST['data'] ) ){
			$eData = $_POST['data'];
			parse_str($eData, $e);
		}
		
		//explode the data
		$name = esc_attr($e['hname']);
		$mail = esc_attr($e['hmail']);
		$subjects = stripslashes($e['hsubj']);
		$message_text = stripslashes($e['hmess']);
		$sendTo = get_wip_option_by('bd_cf_email', get_option('admin_email'));
		
		if( ! forcontact_isValidEmail( $mail ) ) { echo "email_error"; exit; } //email is fake? break the process!!!!

		$subject = $subjects;	
		$message = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head></head>
		<body>
		<table>
			<tr><td valign="top"><b>Name</b></td><td valign="top">:</td><td valign="top">' . stripslashes($name) . '</td></tr>
			<tr><td valign="top"><b>Mail</b></td><td valign="top">:</td><td valign="top">' . $mail . '</td></tr>
			<tr><td valign="top"><b>Subject</b></td><td valign="top">:</td><td valign="top">' . stripslashes($subject) . '</td></tr>
		</table>
		' . wpautop( $message_text ) . '
		</body>
		</html>';
		
		$headers = "MIME-Version: 1.0" . "\r\n";  
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";  
		$headers .= "From: " . stripslashes($name) . " <" . $mail . ">" . "\r\n";  	
		$headers .= "Sender-IP: " . $_SERVER["SERVER_ADDR"] . "\r\n";
		$headers .= "Priority: normal" . "\r\n";
		$headers .= "X-Mailer: PHP/" . phpversion();
		
		$Message_Body    = $message;
		
	//send the mail
		wp_mail( $sendTo, $subject, $Message_Body, $headers );
		
		
		/** if autoresponder active */
		if( get_option('bd_cf_auto') === "1" ){
			$default_respond = "Hello {name} - {email},". Chr(13) . Chr(13) ."Thankyou for contacting me via contact form in my contact page. I will make respond into your message as soon as possible" . Chr(13) . Chr(13) . "Sincerely," . Chr(13) . "Site Owner.";
			$message_to = get_wip_option_by('bd_cf_auto_res', $default_respond);
			$message_to = str_replace('{name}', $name, $message_to);
			$message_to = str_replace('{email}', $mail, $message_to);
			
			$message_body_to = '
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
			"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head></head>
			<body>
			' . wpautop( $message_to ) . '
			</body>
			</html>';
			
			$headers_to = "MIME-Version: 1.0" . "\r\n";  
			$headers_to .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";  
			$headers_to .= "From: " . get_bloginfo( 'name' ) . " <" .$sendTo. ">" . "\r\n";  	
			$headers_to .= "Sender-IP: " . $_SERVER["SERVER_ADDR"] . "\r\n";
			$headers_to .= "Priority: normal" . "\r\n";
			$headers_to .= "X-Mailer: PHP/" . phpversion();
			
			$subject_to = get_wip_option_by('bd_cf_subject_res', 'Thankyou for contacting me!');
			
			wp_mail( $mail, $subject_to, $message_body_to, $headers_to );
		}
		
		$success = get_wip_option_by('bd_cf_success', 'Thankyou, your message has been sent!');
			
		echo $success;
			
		exit;
		
		
}


function forcontact_isValidEmail($email){
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email);
}

?>