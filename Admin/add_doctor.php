<?php
include '../config.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}


$departmentsQuery = "SELECT id, name FROM departments ORDER BY name ASC";
$departmentsResult = $con->query($departmentsQuery);

$hospitalsQuery = "SELECT id, hospital_name, hospital_address FROM doctors GROUP BY hospital_name ORDER BY hospital_name ASC";
$hospitalsResult = $con->query($hospitalsQuery);

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$specialization = $_POST['specialization'] ?? '';
$department_id = $_POST['department_id'] ?? '';
$hospital_id = $_POST['hospital_id'] ?? '';
$address = $_POST['address'] ?? ''; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $specialization = trim($_POST['specialization']);
    $department_id = filter_var($_POST['department_id'], FILTER_VALIDATE_INT);
    $hospital_id = filter_var($_POST['hospital_id'], FILTER_VALIDATE_INT);
    $address = trim($_POST['address']); 
    $is_valid = true;
    $errors = [];

    if (empty($name) || empty($email) || empty($phone) || empty($specialization) || empty($address)) { // <-- UPDATED: Added address check
        $errors[] = 'All main fields (including Address) are required!';
        $is_valid = false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format!';
        $is_valid = false;
    }

    if (!preg_match('/^[0-9]{10,}$/', $phone)) {
        $errors[] = 'Invalid phone number. Must be at least 10 digits.';
        $is_valid = false;
    }
    
    if (strlen($address) < 5) {
        $errors[] = 'Address must be at least 5 characters long.';
        $is_valid = false;
    }


    if ($department_id === false || $hospital_id === false) {
        $errors[] = 'Please select a valid Department and Hospital.';
        $is_valid = false;
    }

    if (!$is_valid) {
        echo "<script>alert('Validation Errors:\\n- " . implode('\\n- ', $errors) . "');</script>";
    }


    if ($is_valid) {
        $checkQuery = $con->prepare("SELECT COUNT(*) as total FROM doctors WHERE email = ?");
        if ($checkQuery) {
            $checkQuery->bind_param("s", $email);
            $checkQuery->execute();
            $checkResult = $checkQuery->get_result()->fetch_assoc();
            $checkQuery->close();
        } else {
            die("Database Error (Check Query): " . $con->error);
        }

        if ($checkResult['total'] > 0) {
            echo "<script>alert('A doctor with this email already exists!');</script>";
        } else {

            $insertQuery = $con->prepare("INSERT INTO doctors (name, email, phone, specialization, department_id, hospital_name, hospital_address) VALUES (?, ?, ?, ?, ?, ?, ?)"); 

            if ($insertQuery) {

                $insertQuery->bind_param("ssssiis", $name, $email, $phone, $specialization, $department_id, $hospital_id, $address); 

                if ($insertQuery->execute()) {

                    echo "<script>alert('Doctor added successfully!'); window.location.href='doctors.php';</script>";
                    exit;
                } else {
                    echo "<script>alert('Error adding doctor: " . $insertQuery->error . "');</script>";
                }
                $insertQuery->close();
            } else {
                die("Database Error (Insert Query): " . $con->error);
            }
        }
    }
}


if (!$departmentsResult || $departmentsResult->num_rows === 0) {
    $departmentsResult = $con->query($departmentsQuery); 
}
if (!$hospitalsResult || $hospitalsResult->num_rows === 0) {
    $hospitalsResult = $con->query($hospitalsQuery);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Doctor</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #f4f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            max-width: 550px; 
            width: 90%;
            text-align: center;
        }

        h2 {
            color: #4f46e5;
            margin-bottom: 30px;
            font-weight: 700;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 14px;
            margin: 10px 0;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box; 
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }
        
        select {
            appearance: none;
            background-color: #fff;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%234f46e5%22%20d%3D%22M287%20177.3l-131.7%20111.4c-3.7%203.1-8.3%204.6-13.8%204.6s-10.1-1.5-13.8-4.6L5.4%20177.3c-4.9-4.2-7.5-9.8-7.5-15.6s2.6-11.4%207.5-15.6l131.7-111.4c3.7-3.1%208.3-4.6%2013.8-4.6s10.1%201.5%2013.8%204.6L287%20146.1c4.9%204.2%207.5%209.8%207.5%2015.6s-2.6%2011.4-7.5%2015.6z%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 10px auto;
        }


        button {
            background: #6366f1; 
            color: white;
            border: none;
            padding: 14px;
            width: 100%;
            margin-top: 20px;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
        }

        button:hover {
            background: #4f46e5;
            box-shadow: 0 6px 12px rgba(99, 102, 241, 0.4);
        }


        .back-link {
            display: block;
            margin-top: 25px;
            color: #6366f1;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #4f46e5;
            text-decoration: underline;
        }
    </style>

</head>

<body>
    <div class="container">
        <h2>Add New Doctor / Officer</h2>
        <form method="POST">

            <input type="text" name="name" placeholder="Full Name" required value="<?php echo htmlspecialchars($name); ?>">
            <input type="email" name="email" placeholder="Email Address" required value="<?php echo htmlspecialchars($email); ?>">
            <input type="tel" name="phone" placeholder="Mobile Number (e.g., 9876543210)" required value="<?php echo htmlspecialchars($phone); ?>">
            <input type="text" name="specialization" placeholder="Specialization (e.g., General Surgery)" required value="<?php echo htmlspecialchars($specialization); ?>">
            <input type="text" name="address" placeholder="Hospital/Clinic Address (Street, City, Zip)" required value="<?php echo htmlspecialchars($address); ?>">


            <select name="department_id" required>
                <option value="" disabled <?php echo empty($_POST['department_id']) ? 'selected' : ''; ?>>Select Department</option>
                <?php 

                if ($departmentsResult) $departmentsResult->data_seek(0);
                
                if ($departmentsResult && $departmentsResult->num_rows > 0) {
                    while ($depRow = $departmentsResult->fetch_assoc()) {

                        $selected = ($department_id == $depRow['id']) ? 'selected' : '';
                        echo "<option value=\"" . htmlspecialchars($depRow['id']) . "\" $selected>" . htmlspecialchars($depRow['name']) . "</option>";
                    }
                } else {
                    echo "<option value=\"\" disabled>No Departments found</option>";
                }
                ?>
            </select>


            <select name="hospital_id" required>
                <option value="" disabled <?php echo empty($_POST['hospital_id']) ? 'selected' : ''; ?>>Select Associated Hospital</option>
                <?php 

                if ($hospitalsResult) $hospitalsResult->data_seek(0);
                
                if ($hospitalsResult && $hospitalsResult->num_rows > 0) {
                    while ($hospRow = $hospitalsResult->fetch_assoc()) {
                        $selected = ($hospital_id == $hospRow['id']) ? 'selected' : '';
                        echo "<option value=\"" . htmlspecialchars($hospRow['id']) . "\" $selected>" . htmlspecialchars($hospRow['hospital_name']) . " (" . htmlspecialchars(substr($hospRow['hospital_address'] ?? 'No Address', 0, 30)) . "...)</option>";
                    }
                } else {
                    echo "<option value=\"\" disabled>No Hospitals found</option>";
                }
                ?>
            </select>
            
            <button type="submit">Add Doctor</button>
        </form>
        <a href="doctors.php" class="back-link">← Back to Doctors List</a>
    </div>
</body>

</html>
<?php

$con->close(); 
?>
