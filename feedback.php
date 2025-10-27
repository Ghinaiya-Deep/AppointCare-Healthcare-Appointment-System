<?php
include("../config.php"); 

$success_message = "";
$error_message = "";
$form_submitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_submitted = true;
    
    $patient_name = trim(filter_input(INPUT_POST, 'patient_name', FILTER_SANITIZE_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS));
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS));

    if (empty($patient_name) || strlen($patient_name) < 2) {
        $error_message .= "Full Name is required and must be at least 2 characters. ";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message .= "A valid Email Address is required. ";
    }
    if (empty($phone) || !preg_match("/^[0-9\-\(\)\/\+\s]{6,20}$/", $phone)) {
        $error_message .= "A valid Phone Number is required. ";
    }
    if ($rating === false || $rating < 1 || $rating > 5) {
        $error_message .= "A valid Overall Rating (1-5) is required. ";
    }
    if (empty($message) || strlen($message) < 10) {
        $error_message .= "Feedback message must be at least 10 characters long. ";
    }
    
    if (empty($error_message)) {
        
        $table_name = "feedback"; 
        
        $stmt = $con->prepare("INSERT INTO $table_name (patient_name, email, phone, rating, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        
        $stmt->bind_param("sssis", $patient_name, $email, $phone, $rating, $message);
        
        if ($stmt->execute()) {
            $success_message = "Thank you for your feedback! Your input has been securely recorded.";
            $_POST = array();
        } else {
            $error_message = "We apologize, but there was a database error recording your feedback. Please try again later.";
        }
        
        $stmt->close();
        
    } else {
        $error_message = "Submission failed. Please correct the following: " . $error_message;
    }
    
    if (isset($con) && $con instanceof mysqli) {
        $con->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Feedback | Medical Center</title>
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

        .feedback-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .feedback-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-color) 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .feedback-header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .feedback-header p {
            font-size: 16px;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .feedback-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .required::after {
            content: " *";
            color: #e74c3c;
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

        .form-control {
            padding: 12px 15px 12px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(25, 119, 204, 0.25);
        }

        textarea.form-control {
            padding: 12px 15px; 
            min-height: 120px;
            resize: vertical;
        }
        
        #phone, #email, #patient_name {
             padding: 12px 15px 12px 45px;
        }


        .rating-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .rating-stars {
            display: flex;
            gap: 5px;
        }

        .rating-stars input {
            display: none;
        }

        .rating-stars label {
            font-size: 30px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
            margin: 0;
            order: 5; 
        }
        
        #star5 + label { order: 5; }
        #star4 + label { order: 4; }
        #star3 + label { order: 3; }
        #star2 + label { order: 2; }
        #star1 + label { order: 1; }


        .rating-stars input:checked ~ label,
        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: #ffc107;
        }

        .rating-stars input:checked + label {
            color: #ffc107;
        }

        .rating-labels {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #666;
            margin-top: 5px;
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
        }
        
        .message i {
            margin-right: 10px;
        }

        .success-message {
            background: #e8f7ef;
            color: #0d6832;
            border: 1px solid #a3e6c5;
        }

        .error-message-box {
            background: #fde8e8;
            color: #c53030;
            border: 1px solid #fbb6b6;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 15px;
            background: #fff3cd;
            color: #856404;
            border-radius: 8px;
            margin-bottom: 20px;
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
            .feedback-body {
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
    <div class="feedback-container">
        <div class="feedback-header">
            <h1>Patient Feedback</h1>
            <p>Your feedback helps us improve our services and provide better care</p>
        </div>
        
        <div class="feedback-body">
            
            <?php if (!empty($success_message)): ?>
                <div id="successMessage" class="message success-message" style="display: flex;">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php elseif (!empty($error_message)): ?>
                <div id="errorMessage" class="message error-message-box" style="display: flex;">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <?php if (empty($success_message) || !$form_submitted): ?>
            
            <form id="feedbackForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="patient_name" class="required">Full Name</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" class="form-control" id="patient_name" name="patient_name" placeholder="Enter your full name" value="<?php echo isset($_POST['patient_name']) ? htmlspecialchars($_POST['patient_name']) : ''; ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="email" class="required">Email Address</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="phone" class="required">Phone Number</label>
                    <div class="input-with-icon">
                        <i class="fas fa-phone"></i>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="rating" class="required">Overall Rating</label>
                    <div class="rating-container">
                        <div class="rating-stars">
                            <?php 
                                $posted_rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
                                for ($i = 5; $i >= 1; $i--): 
                            ?>
                                <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" <?php echo $posted_rating === $i ? 'checked' : ''; ?> required>
                                <label for="star<?php echo $i; ?>"><i class="fas fa-star"></i></label>
                            <?php endfor; ?>
                        </div>
                        <div class="rating-labels">
                            <span>Poor</span>
                            <span>Fair</span>
                            <span>Good</span>
                            <span>Very Good</span>
                            <span>Excellent</span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="message" class="required">Your Feedback</label>
                    <textarea class="form-control" id="message" name="message" placeholder="Please share your experience, suggestions, or any concerns..." required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>
                
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Submit Feedback
                </button>
            </form>
            
            <?php endif; // End form display condition ?>

            <div class="features">
                <div class="feature">
                    <i class="fas fa-lock"></i>
                    <p>Confidential & Secure</p>
                </div>
                <div class="feature">
                    <i class="fas fa-heart"></i>
                    <p>Patient-Centered</p>
                </div>
                <div class="feature">
                    <i class="fas fa-chart-line"></i>
                    <p>Helps Us Improve</p>
                </div>
                <div class="feature">
                    <i class="fas fa-comments"></i>
                    <p>We Value Your Opinion</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>