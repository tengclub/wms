<?php
namespace App\Lib;
class Smtp
{
	public function sendmail($mail_to, $mail_subject, $mail_message) {
		$mail1 = config('ztconfig')['mail'];
		$bfconfig = Array (
				'sitename' => 'cozybook',
		);
		$mail = Array (
				'state' => 1,
				'server' => $mail1['host'],
				'port' => $mail1['port'],
				'auth' => 1,
				'username' => $mail1['user'],
				'password' => $mail1['password'],
				'charset' => 'utf-8',
				'mailfrom' => $mail1['from']
		);
	
	
		date_default_timezone_set('PRC');
	
		$mail_subject = '=?'.$mail['charset'].'?B?'.base64_encode($mail_subject).'?=';
		$mail_message = chunk_split(base64_encode(preg_replace("/(^|(\r\n))(\.)/", "\1.\3", $mail_message)));
	
		$headers = "";
		$headers .= "MIME-Version:1.0\r\n";
		$headers .= "Content-type:text/html\r\n";
		$headers .= "Content-Transfer-Encoding: base64\r\n";
		$headers .= "From: ".$bfconfig['sitename']."<".$mail['mailfrom'].">\r\n";
		$headers .= "Date: ".date("r")."\r\n";
		list($msec, $sec) = explode(" ", microtime());
		$headers .= "Message-ID: <".date("YmdHis", $sec).".".($msec * 1000000).".".$mail['mailfrom'].">\r\n";
	
		if(!$fp = fsockopen($mail['server'], $mail['port'], $errno, $errstr, 30)) {
// 			exit("CONNECT - Unable to connect to the SMTP server");
			return false;
		}
	
		stream_set_blocking($fp, true);
	
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != '220') {
// 			exit("CONNECT - ".$lastmessage);
			return false;
		}
	
		fputs($fp, ($mail['auth'] ? 'EHLO' : 'HELO')." befen\r\n");
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != 220 && substr($lastmessage, 0, 3) != 250) {
// 			exit("HELO/EHLO - ".$lastmessage);
			return false;
		}
	
		while(1) {
			if(substr($lastmessage, 3, 1) != '-' || empty($lastmessage)) {
				break;
			}
			$lastmessage = fgets($fp, 512);
		}
	
		if($mail['auth']) {
			fputs($fp, "AUTH LOGIN\r\n");
			$lastmessage = fgets($fp, 512);
			if(substr($lastmessage, 0, 3) != 334) {
// 				exit($lastmessage);
				return false;
			}
			 
			fputs($fp, base64_encode($mail['username'])."\r\n");
			$lastmessage = fgets($fp, 512);
			if(substr($lastmessage, 0, 3) != 334) {
// 				exit("AUTH LOGIN - ".$lastmessage);
				return false;
			}
			 
			fputs($fp, base64_encode($mail['password'])."\r\n");
			$lastmessage = fgets($fp, 512);
			if(substr($lastmessage, 0, 3) != 235) {
// 				exit("AUTH LOGIN - ".$lastmessage);
				return false;
			}
			 
			$email_from = $mail['mailfrom'];
		}
	
		fputs($fp, "MAIL FROM: <".preg_replace("/.*\<(.+?)\>.*/", "\\1", $email_from).">\r\n");
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != 250) {
			fputs($fp, "MAIL FROM: <".preg_replace("/.*\<(.+?)\>.*/", "\\1", $email_from).">\r\n");
			$lastmessage = fgets($fp, 512);
			if(substr($lastmessage, 0, 3) != 250) {
// 				exit("MAIL FROM - ".$lastmessage);
				return false;
			}
		}
	
		foreach(explode(',', $mail_to) as $touser) {
			$touser = trim($touser);
			if($touser) {
				fputs($fp, "RCPT TO: <".preg_replace("/.*\<(.+?)\>.*/", "\\1", $touser).">\r\n");
				$lastmessage = fgets($fp, 512);
				if(substr($lastmessage, 0, 3) != 250) {
					fputs($fp, "RCPT TO: <".preg_replace("/.*\<(.+?)\>.*/", "\\1", $touser).">\r\n");
					$lastmessage = fgets($fp, 512);
// 					exit("RCPT TO - ".$lastmessage);
					return false;
				}
			}
		}
	
		fputs($fp, "DATA\r\n");
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != 354) {
// 			exit("DATA - ".$lastmessage);
			return false;
		}
	
		fputs($fp, $headers);
		fputs($fp, "To: ".$mail_to."\r\n");
		fputs($fp, "Subject: $mail_subject\r\n");
		fputs($fp, "\r\n\r\n");
		fputs($fp, "$mail_message\r\n.\r\n");
		$lastmessage = fgets($fp, 512);
		if(substr($lastmessage, 0, 3) != 250) {
// 			exit("END - ".$lastmessage);
			return false;
		}
	
		fputs($fp, "QUIT\r\n");
		return true;
	}
}
