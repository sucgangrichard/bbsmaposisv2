<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['name']) &&
isset($_POST['email']) &&
isset($_POST['subject']) &&

isset($_POST['text'])) {
	
	$name = $_POST['name'];
	$email = $_POST['email'];
	$subject = $_POST['subject'];
	$text = $_POST['text'];
	$file = $_FILES['attachment'];

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "Error uploading file.";
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	$em = "Invalid email format";
    	header("Location: contactform.php?error=$em");
    }

    if (empty($name) || empty($subject) || empty($text) ) {
    	$em = "Fill out all required entry fields";
    	header("Location: contactform.php?error=$em");
    }

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
	    $mail->isSMTP();                               
	    $mail->Host = 'smtp.gmail.com'; 
	    $mail->SMTPAuth   = true;
	    //Your Email
	    $mail->Username= 'richard.l.sucgang@gmail.com';
	    //App password
	    $mail->Password = 'gwiitdscznvhptue'; 
	    $mail->SMTPSecure = "ssl";          
	    $mail->Port       = 465;                                  
	    //Recipients
	    $mail->setFrom($email, $name);   
	    // your Email
	    $mail->addAddress($email); 

		// Check if file was uploaded
		if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
			$fileTmpPath = $_FILES['attachment']['tmp_name'];
			$fileName = $_FILES['attachment']['name'];
			$fileSize = $_FILES['attachment']['size'];
			$fileType = $_FILES['attachment']['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileExtension = strtolower(end($fileNameCmps));
  
			// Sanitize file name
			$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
  
			// Check file size (e.g., max 5MB)
			if ($fileSize < 5242880) {
				// Allowed file types
				$allowedfileExtensions = array('jpg', 'gif', 'png', 'pdf', 'doc', 'docx');
				if (in_array($fileExtension, $allowedfileExtensions)) {
					$mail->addAttachment($fileTmpPath, $newFileName);
				} else {
					error_log('File type not allowed: ' . $fileExtension);
				}
			} else {
				error_log('File size exceeds limit: ' . $fileSize);
			}
		} else {
			// Debugging code
			error_log('File upload error: ' . $_FILES['attachment']['error']);
		}

		// Attachment
		$fileContent = file_get_contents($file['tmp_name']);
		$fileName = basename($file['name']);
		$fileContentEncoded = chunk_split(base64_encode($fileContent));
	
		$body .= "--$boundary\r\n";
		$body .= "Content-Type: application/octet-stream; name=\"$fileName\"\r\n";
		$body .= "Content-Transfer-Encoding: base64\r\n";
		$body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n\r\n";
		$body .= "$fileContentEncoded\r\n\r\n";
		$body .= "--$boundary--\r\n";
	

	    //Content
	    $mail->isHTML(true);                             
	    $mail->Subject = $subject;
	    $mail->Body    = "
	           <h3>Site: Company CK Restaurant</h3>
			   <p><strong>Name</strong>: $name</p>
			<p><strong>To</strong>: $email</p>
			   <p><strong>Subject</strong>: $subject</p>
			   <p><strong></strong> $text</p>
			   $newFileName
	                     ";
	    $mail->send();
	    $sm= 'Message has been sent';
    	header("Location: contactform.php?success=$sm");
	} catch (Exception $e) {
	    $em = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    	header("Location: contactform.php?error=$em");
	}

}