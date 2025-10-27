<?php

$success_message = '';
$error_message = '';
$form_data = [];

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../config.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$smtp_host = 'smtp.gmail.com'; // Use smtp.gmail.com for Gmail
$smtp_username = 'deep.c617.app@gmail.com';
$smtp_password = 'khkc cfft prig jiuz'; // This MUST be an App Password
$smtp_port = 587; 
$smtp_secure = 'tls'; // Use 'tls' for port 587

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $date = trim($_POST['appointmentDate'] ?? '');
    $code = trim($_POST['cancellationCode'] ?? '');
    $reason = trim($_POST['reason'] ?? ''); 

    $form_data = [
        'phone' => htmlspecialchars($phone),
        'email' => htmlspecialchars($email),
        'date' => htmlspecialchars($date), 
        'code' => htmlspecialchars($code), 
        'reason' => htmlspecialchars($reason)
    ];

    if (empty($phone) || empty($email) || empty($date) || empty($code) || empty($reason)) {
        $error_message = "All fields are required to process the cancellation.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format provided.";
    } elseif (!preg_match("/^\d{4}$/", $code)) {
        $error_message = "The cancellation code must be exactly 4 digits.";
    }

    global $con;

    if (empty($error_message) && isset($con) && $con) {
        $sql = "DELETE FROM appointments 
                WHERE patient_phone = ? 
                AND patient_email = ? 
                AND DATE(appointment_date) = ? 
                AND unique_code = ?";

        $stmt = $con->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssss", $phone, $email, $date, $code);

            if ($stmt->execute()) {
                if ($stmt->affected_rows === 1) {
                    
                    $mail_status_ok = true; 
                    
                    $subject = "Appointment Cancellation Confirmation";
                    $message_body = "Dear Patient,\n\n";
                    $message_body .= "This email confirms the successful cancellation of your appointment scheduled for " . date('F jS, Y', strtotime($date)) . ".\n\n";
                    $message_body .= "Reason provided: " . ucfirst(htmlspecialchars($reason)) . ".\n\n";
                    $message_body .= "If this was a mistake, please contact us immediately to rebook.\n\n";
                    $message_body .= "Thank you,\nAppointCre Team";
                    
                    try {
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host       = $smtp_host;
                        $mail->SMTPAuth   = true;
                        $mail->Username   = $smtp_username;
                        $mail->Password   = $smtp_password;
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                        $mail->Port       = $smtp_port;

                        $mail->setFrom('deep.c617.app@gmail.com', 'AppointCare');
                        $mail->addAddress($email);
                        $mail->Subject = $subject;
                        $mail->Body    = $message_body;
                        $mail->isHTML(false); 

                        $mail->send();
                        
                    } catch (Exception $e) {
                        $mail_status_ok = false;
                        error_log("PHPMailer Error: " . $e->getMessage()); 
                    }
                    
                    if ($mail_status_ok) {
                        $success_message = "Your appointment has been successfully cancelled. A confirmation email has been sent to {$email}.";
                    } else {
                        $success_message = "Your appointment has been successfully cancelled in our system. However, we could not send the confirmation email due to an error. Please check your email settings or contact support.";
                    }

                    $form_data = [];
                } else {
                    $error_message = "Cancellation failed. No appointment was found matching the provided Phone Number, Email, Date, and 4-digit Code combination. Please verify your details.";
                }
            } else {
                $error_message = "Database execution error: Could not cancel appointment. Please try again. " . $con->error;
            }
            $stmt->close();
        } else {
            $error_message = "Database error: Could not prepare statement. Check table/column names.";
        }
    } elseif (empty($error_message)) {
        $error_message = "An internal server error occurred. (Database connection missing or failed.)";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Appointment | Medical Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            width: 100%;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
            background: white;
        }

        .form-panel {
            padding: 50px 40px;
        }

        .form-header {
            margin-bottom: 30px;
        }

        .form-header h2 {
            color: #1a6fc4;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #666;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #444;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        input, select {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
        }
        
        select {
            padding: 14px 15px 14px 15px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #1a6fc4;
            box-shadow: 0 0 0 3px rgba(26, 111, 196, 0.1);
        }

        .btn {
            background: #d9534f; 
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn:hover {
            background: #c9302c;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(217, 83, 79, 0.3);
        }

        .message {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex; 
            align-items: center;
        }
        
        .message i {
            margin-right: 10px;
            font-size: 18px;
        }

        .success {
            background: #e8f7ef;
            color: #0d6832;
            border: 1px solid #a3e6c5;
        }

        .error {
            background: #fde8e8;
            color: #c53030;
            border: 1px solid #fbb6b6;
        }

        .help-text {
            font-size: 13px;
            color: #888;
            margin-top: 5px;
        }

        @media (max-width: 900px) {
            .form-panel {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="form-panel">
            <div class="form-header">
                <h2>Cancel Appointment</h2>
                <p>Please fill in the details below to cancel your appointment. You need the unique **4-digit code** from your confirmation email.</p>
            </div>
            
            <?php if (!empty($success_message)): ?>
            <div id="successMessage" class="message success">
                <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($error_message)): ?>
            <div id="errorMessage" class="message error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
            </div>
            <?php endif; ?>
            
            <form id="cancellationForm" method="POST" action="">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone"></i>
                        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required value="<?php echo $form_data['phone'] ?? ''; ?>">
                    </div>
                    <div class="help-text">The phone number you used when booking the appointment</div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required value="<?php echo $form_data['email'] ?? ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="appointmentDate">Appointment Date</label>
                    <div class="input-with-icon">
                        <i class="fas fa-calendar-alt"></i>
                        <input type="date" id="appointmentDate" name="appointmentDate" required value="<?php echo $form_data['date'] ?? ''; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="cancellationCode">4-Digit Cancellation Code</label>
                    <div class="input-with-icon">
                        <i class="fas fa-key"></i>
                        <input type="text" id="cancellationCode" name="cancellationCode" maxlength="4" pattern="\d{4}" title="Please enter the 4-digit numeric code" placeholder="Enter 4-digit code" required value="<?php echo $form_data['code'] ?? ''; ?>">
                    </div>
                    <div class="help-text">Check your appointment confirmation email for this code</div>
                </div>
                
                <div class="form-group">
                    <label for="reason">Reason for Cancellation</label>
                    <select id="reason" name="reason" required>
                        <option value="">Select a reason</option>
                        <option value="schedule" <?php echo ($form_data['reason'] ?? '') == 'schedule' ? 'selected' : ''; ?>>Schedule Conflict</option>
                        <option value="health" <?php echo ($form_data['reason'] ?? '') == 'health' ? 'selected' : ''; ?>>Health Issues</option>
                        <option value="travel" <?php echo ($form_data['reason'] ?? '') == 'travel' ? 'selected' : ''; ?>>Travel Problems</option>
                        <option value="financial" <?php echo ($form_data['reason'] ?? '') == 'financial' ? 'selected' : ''; ?>>Financial Reasons</option>
                        <option value="other" <?php echo ($form_data['reason'] ?? '') == 'other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                
                
                <div class="form-group">
                    <button type="submit" class="btn">
                        <i class="fas fa-times-circle"></i> Cancel Appointment
                    </button>
                </div>
                
                <div style="text-align: center; margin-top: 20px; color: #666; font-size: 14px;">
                    Changed your mind? <a href="appointment.php" style="color: #1a6fc4; text-decoration: none;">Reschedule your appointment instead</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
