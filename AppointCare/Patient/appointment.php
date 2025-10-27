<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../config.php';


$all_doctors = [
    "Cardiology" => ["Dr. Amit Chaudhari"],
    "Neurology" => ["Dr. Vishal Sawale"],
    "Orthopaedics" => ["Dr. Nikhil Bhamare"],
    "Dermatology" => ["Dr. Pradnya Joshi"],
    "Dentistry" => ["Dr. Nilesh Bhavsar"],
    "Gynaecology & Obstetrics" => ["Dr. Aarti Parakh"],
    "ENT" => ["Dr. Gaurav Roy", "Dr. Shabbir Indorewala"],
    "Paediatrics" => ["Dr. Ramesh Patil"],
    "Psychiatry" => ["Dr. Seema Kulkarni"],
    "Ophthalmology" => ["Dr. Rohit Deshmukh"],
    "Gastroenterology" => ["Dr. Meena Chaudhari"],
    "Urology" => ["Dr. Suresh Naik"],
    "Pulmonology" => ["Dr. Kavita Sharma"],
    "Nephrology" => ["Dr. Anil Patwardhan"],
    "General Medicine" => ["Dr. Jyoti Kamat"],
    "Rheumatology" => ["Dr. Sunil More"],
    "Endocrinology" => ["Dr. Priya Shinde"],
    "Oncology" => ["Dr. Rohit Jadhav"],
    "Hematology" => ["Dr. Deepali Sawant"],
    "Physiotherapy / Rehabilitation" => ["Dr. Rajesh Korde"]
];
$departments = array_keys($all_doctors);
$flat_doctors_list = [];
foreach ($all_doctors as $dept => $docs) {
    foreach ($docs as $doc) {
        $flat_doctors_list[] = $doc;
    }
}


define('SMTP_HOST', 'smtp.gmail.com');      // e.g., 'smtp.sendgrid.net', 'smtp.gmail.com'
define('SMTP_USERNAME', 'deep.c617.app@gmail.com'); // Your actual SMTP login username/email
define('SMTP_PASSWORD', 'khkc cfft prig jiuz');   // Your actual SMTP password or App Password
define('SMTP_PORT', 587);                       // 587 for TLS, 465 for SSL
define('SENDER_EMAIL', 'deep.c617.app@gmail.com'); // The 'From' email address
define('SENDER_NAME', 'AppointCare');


$success_message = '';
$error_message = '';
$form_data = [];



function generate_unique_code($length = 4)
{
    $characters = '0123456789';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}


function send_confirmation_email($name, $email, $phone, $datetime, $department, $doctor, $unique_code)
{
    global $error_message;
    $mail = new PHPMailer(true);

    $formatted_datetime = date('l, F jS, Y \a\t h:i A', strtotime($datetime));

    try {
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USERNAME;
        $mail->Password   = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = SMTP_PORT;

        $mail->setFrom(SENDER_EMAIL, SENDER_NAME);
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "Appointment Confirmation & Code with " . SENDER_NAME;

        $mail->Body = "
            <html>
            <head>
                <title>Appointment Confirmation</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
                    h2 { color: #1977cc; }
                    .detail { margin-bottom: 10px; padding: 10px; background-color: #f6f9fe; border-left: 3px solid #1977cc; }
                    .code-box {
                        font-size: 24px;
                        font-weight: bold;
                        color: #d9534f;
                        background-color: #fce4e4; 
                        padding: 10px 20px; 
                        border-radius: 8px; 
                        display: inline-block;
                        letter-spacing: 5px; /* Added spacing to emphasize 4 digits */
                    }
                    .footer { margin-top: 20px; padding-top: 10px; border-top: 1px solid #eee; font-size: 0.9em; color: #666; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Hello $name,</h2>
                    <p>Thank you for booking your appointment with us! Please keep your unique 4-digit code safe for future reference and check-in.</p>

                    <div class='detail'>
                        <strong>Your 4-Digit Appointment Code:</strong>
                    </div>
                    <div class='code-box'>
                        $unique_code
                    </div>
                    <br><br>
                    <p>
                        <strong>Name:</strong> $name<br>
                        <strong>Phone:</strong> $phone<br>
                        <strong>Date & Time (Slot):</strong> $formatted_datetime<br>
                        <strong>Department:</strong> $department<br>
                        <strong>Doctor:</strong> $doctor<br>
                    </p>

                    <p>
                        <strong>Thanks Line:</strong> Please arrive 15 minutes prior to your scheduled time to complete the necessary formalities. For cancellations, please call us at least 24 hours in advance, referencing your unique 4-digit code.
                    </p>
                    
                    <div class='footer'>
                        <p>AppointCare Team</p>
                    </div>
                </div>
            </body>
            </html>
        ";
        $mail->AltBody = "Appointment Confirmation\n4-Digit Appointment Code: $unique_code\nName: $name\nPhone: $phone\nDate & Time (Slot): $formatted_datetime\nDepartment: $department\nDoctor: $doctor\nPlease arrive 15 minutes prior to your scheduled time.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("PHPMailer Error: " . $mail->ErrorInfo);
        return false;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $doctor = trim($_POST['doctor'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $form_data = [
        'name' => htmlspecialchars($name),
        'email' => htmlspecialchars($email),
        'phone' => htmlspecialchars($phone),
        'address' => htmlspecialchars($address),
        'date' => htmlspecialchars($date),
        'department' => htmlspecialchars($department),
        'doctor' => htmlspecialchars($doctor),
        'message' => htmlspecialchars($message)
    ];

    if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($date) || empty($department) || empty($doctor)) {
        $error_message = "All fields except Additional Message are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif (!preg_match("/^[0-9\-\(\)\/\+\s]*$/", $phone)) {
        $error_message = "Invalid phone number format.";
    } elseif (strtotime($date) < time()) {
        $error_message = "Appointment date and time cannot be in the past.";
    }

    global $con;

    if (empty($error_message)) {
        $db_success = false;


        $unique_code = generate_unique_code(4);

        if (isset($con) && $con) {
            $sql = "INSERT INTO appointments (patient_name, patient_email, patient_phone, patient_address, appointment_date, department_id, doctor_id,message, unique_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $con->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssssssss", $name, $email, $phone, $address, $date, $department, $doctor, $message, $unique_code);

                if ($stmt->execute()) {
                    $db_success = true;
                } else {
                    $error_message = "Database error: Could not process your request. Please try again. " . $con->error;
                }
                $stmt->close();
            } else {
                $error_message = "Database error: Could not prepare statement. Check table/column names.";
            }
            $con->close();
        } else {
            $error_message = "An internal server error occurred. Please try again later. (DB Connection missing)";
        }

        if ($db_success) {

            if (send_confirmation_email($name, $email, $phone, $date, $department, $doctor, $unique_code)) {
                $success_message = "Your appointment has been booked successfully. A confirmation email with your unique **4-digit code** has been sent to **$email**.";
                $form_data = [];
            } else {
                $success_message = "Your appointment was booked, but the confirmation email could not be sent. Please check your spam folder and ensure your SMTP settings are correct. Your unique **4-digit code** is **$unique_code**.";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment | ?AppointCare </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1977cc;
            --secondary-color: #3291e6;
            --light-color: #f6f9fe;
            --dark-color: #124265;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #444;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .appointment-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .appointment-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-color) 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .appointment-header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .appointment-header p {
            font-size: 16px;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .appointment-body {
            padding: 40px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-color);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 8px;
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
            pointer-events: none;
        }

        .form-control,
        .form-select {
            padding: 12px 15px 12px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(25, 119, 204, 0.25);
        }

        #department,
        #doctor {
            padding: 12px 15px 12px 15px !important;
        }

        .submit-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .submit-btn i {
            margin-right: 8px;
        }

        .submit-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 119, 204, 0.3);
        }

        .message {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            line-height: 1.4;
        }

        .message i {
            margin-right: 10px;
            font-size: 18px;
        }

        .success-message {
            background: #e8f7ef;
            color: #0d6832;
            border: 1px solid #a3e6c5;
        }

        .error-message {
            background: #fde8e8;
            color: #c53030;
            border: 1px solid #fbb6b6;
        }

        .features {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .feature {
            text-align: center;
            flex: 1;
            min-width: 150px;
            padding: 10px;
        }

        .feature i {
            font-size: 24px;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .feature p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }

        @media (max-width: 768px) {
            .appointment-body {
                padding: 25px;
            }

            .features {
                flex-direction: column;
            }

            .feature {
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="appointment-container">
        <div class="appointment-header">
            <h1>Book Your Appointment</h1>
            <p>Schedule your visit with top doctors quickly and securely</p>
        </div>

        <div class="appointment-body">

            <?php if (!empty($success_message)): ?>
                <div id="successMessage" class="message success-message">
                    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_message)): ?>
                <div id="errorMessage" class="message error-message">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form id="appointmentForm" method="POST" action="">
                <div class="form-section">
                    <h3 class="section-title">Personal Information</h3>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="name">Full Name</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required value="<?php echo $form_data['name'] ?? ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="email">Email Address</label>
                            <div class="input-with-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required value="<?php echo $form_data['email'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="phone">Phone Number</label>
                            <div class="input-with-icon">
                                <i class="fas fa-phone"></i>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="e.g., +91 98765 43210" required value="<?php echo $form_data['phone'] ?? ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="address">Address</label>
                            <div class="input-with-icon">
                                <i class="fas fa-home"></i>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required value="<?php echo $form_data['address'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">Appointment Details</h3>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="date">Appointment Date & Time</label>
                            <div class="input-with-icon">
                                <i class="fas fa-calendar-alt"></i>
                                <input type="datetime-local" class="form-control" id="date" name="date" required value="<?php echo $form_data['date'] ?? ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="department">Department</label>
                            <select id="department" name="department" class="form-select" required>
                                <option value="">Select Department</option>
                                <?php
                                foreach ($departments as $dept) {
                                    $selected = ($form_data['department'] ?? '') == $dept ? 'selected' : '';
                                    echo "<option value=\"" . htmlspecialchars($dept) . "\" $selected>" . htmlspecialchars($dept) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="doctor">Select Doctor</label>
                            <select id="doctor" name="doctor" class="form-select" required>
                                <option value="">Select Doctor</option>
                                <?php
                                $current_dept = $form_data['department'] ?? '';
                                $display_doctors = $current_dept && isset($all_doctors[$current_dept]) ? $all_doctors[$current_dept] : $flat_doctors_list;

                                foreach ($display_doctors as $doc) {
                                    $selected = ($form_data['doctor'] ?? '') == $doc ? 'selected' : '';
                                    echo "<option value=\"" . htmlspecialchars($doc) . "\" $selected>" . htmlspecialchars($doc) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message">Additional Message (Optional)</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Any additional information or special requests"><?php echo $form_data['message'] ?? ''; ?></textarea>
                    </div>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-calendar-check"></i> Book Appointment
                </button>
            </form>

            <div class="features">
                <div class="feature">
                    <i class="fas fa-user-md"></i>
                    <p>Expert Certified Doctors</p>
                </div>
                <div class="feature">
                    <i class="fas fa-clock"></i>
                    <p>24/7 Service Available</p>
                </div>
                <div class="feature">
                    <i class="fas fa-envelope-open-text"></i>
                    <p>Instant Email Confirmation</p>
                </div>
                <div class="feature">
                    <i class="fas fa-shield-alt"></i>
                    <p>Secure Booking Process</p>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const departmentSelect = document.getElementById('department');
            const doctorSelect = document.getElementById('doctor');

            const allDoctors = <?php echo json_encode($all_doctors); ?>;

            function filterDoctors() {
                const selectedDepartment = departmentSelect.value;
                const currentDoctor = doctorSelect.value;

                doctorSelect.innerHTML = '<option value="">Select Doctor</option>';

                if (selectedDepartment && allDoctors[selectedDepartment]) {
                    const doctorsForDept = allDoctors[selectedDepartment];

                    doctorsForDept.forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor;
                        option.textContent = doctor;
                        if (doctor === currentDoctor) {
                            option.selected = true;
                        }
                        doctorSelect.appendChild(option);
                    });
                }

                if (currentDoctor && !doctorSelect.querySelector(`option[value="${currentDoctor}"]`)) {
                    doctorSelect.value = '';
                }
            }

            departmentSelect.addEventListener('change', filterDoctors);

            filterDoctors();
        });
    </script>
</body>

</html>