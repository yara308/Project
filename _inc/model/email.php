<?php
/*
| -----------------------------------------------------
| PRODUCT NAME: 	Onzwo
| -----------------------------------------------------
| AUTHOR:			ONZWO.COM
| -----------------------------------------------------
| EMAIL:			info@ONZWO.COM
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY ONZWO.COM
| -----------------------------------------------------
| WEBSITE:			http://ONZWO.COM
| -----------------------------------------------------
*/
class ModelEmail extends Model 
{
	public function send() 
	{
		// DEBUG START
        
        $subject = 'text email from pos';
        $title = 'text email from pos';
        $body = '<h1>This is email body</h1>';
        $recipient_name ='techbuzz69@gmail.com';
        $recipient_email = 'techbuzz69@gmail.com';
        $template_name = 'default';

        // DEBUG END

        $store_name = store('name');
        $store_address = store('address');
        $from_name = get_preference('email_from');
        $from_address = get_preference('email_address');

        if (!file_exists(DIR_EMAIL_TEMPLATE . $template_name . '.php') || !is_file(DIR_EMAIL_TEMPLATE . $template_name . '.php')) {
            throw new Exception(trans('error_email_template_not_found'));
        }

        ob_start();
        require(DIR_EMAIL_TEMPLATE . $template_name . '.php');
        $body = ob_get_contents();
        ob_end_clean();

        $driver = get_preference('email_driver');
        if ($driver == 'smtp_server') {

            require_once(DIR_VENDOR . 'PHPMailer/PHPMailerAutoload.php');

            $smtp_host = get_preference('smtp_host');
            $smtp_username = get_preference('smtp_username');
            $smtp_password = get_preference('smtp_password');
            $smtp_port = get_preference('smtp_port');
            $ssl_tls = get_preference('ssl_tls');

            $mail = new PHPMailer;

            if ($driver == 'smtp_server') {
                $mail->IsSMTP(); // telling the class to use SMTP
                $mail->SMTPDebug = 3; // Debugging: 1 = errors and messages, 2 = messages only
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->SMTPSecure = $ssl_tls; // Sets the prefix to the servier
                $mail->Host = $smtp_host; // Sets GMAIL as the SMTP server
                $mail->Port = $smtp_port; // Set the SMTP port for the GMAIL server
                $mail->Username = $smtp_username; // GMAIL username
                $mail->Password = $smtp_password; // GMAIL password
            }
            $mail->AddAddress($recipient_email, $recipient_name);
            $mail->SetFrom($smtp_username, $from_name);
            $mail->Subject = $subject;
            $mail->IsHTML(true);
            $mail->Body = $body;
            if ($mail->Send()) {
                $message = trans('text_success_email_sent');
            } else {
                throw new Exception(trans('error_email_not_sent'));
            }

        } else {

            $mail = new Email();
            $config['useragent'] = store('name');
            $config['protocol'] = 'mail';
            $config['mailtype'] = "html";
            $config['crlf'] = "\r\n";
            $config['newline'] = "\r\n";
            $mail->initialize($config);
            $mail->from($from_address, $from_name);
            $mail->to($recipient_email);
            $mail->subject($subject);
            $mail->message($body);
            if ($mail->send()) {
                $message = trans('text_success_email_sent') . '. To prevent spam setup your SMTP server.';
            } else {
                throw new Exception($mail->print_debugger(array('headers', 'subject')));
            }
        }
	}
}