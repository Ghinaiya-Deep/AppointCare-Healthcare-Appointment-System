<?php
session_start();
require '../config.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

function getAppointmentCount($con, $status = null)
{
    if ($status) {
        $stmt = $con->prepare("SELECT COUNT(*) AS count FROM appointments WHERE status = ?");
        if ($stmt === false) {
            error_log("Prepare failed: " . $con->error);
            return 0;
        }
        $stmt->bind_param("s",  $status);
    } else {
        $stmt = $con->prepare("SELECT COUNT(*) AS count FROM appointments");
        if ($stmt === false) {
            error_log("Prepare failed: " . $con->error);
            return 0;
        }
    }
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'] ?? 0;
}

function getTotalUsersCount($con, $table)
{
    $stmt = $con->prepare("SELECT COUNT(*) AS count FROM {$table}");
    if ($stmt === false) {
        error_log("Prepare failed: " . $con->error);
        return 0;
    }
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'] ?? 0;
}


function getTotalFeedbackCount($con, $table)
{
    $stmt = $con->prepare("SELECT COUNT(*) AS count FROM feedback");
    if ($stmt === false) {
        error_log("Prepare failed: " . $con->error);
        return 0;
    }
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['count'] ?? 0;
}
$total_appointments = getAppointmentCount($con);


$total_doctors = getTotalUsersCount($con, 'doctors'); 
$total_patients = getTotalUsersCount($con, 'users');
$total_feedback = getTotalFeedbackCount($con, 'feedback');


$doctors = [];
$patients = [];


$stmt = $con->prepare("SELECT id, name FROM doctors");
$stmt->execute();
$result_doctors = $stmt->get_result();
while ($row = $result_doctors->fetch_assoc()) {
    $doctors[$row['id']] = $row['name'];
}

$stmt = $con->prepare("SELECT Username, Email FROM users");
$stmt->execute();
$result_patients = $stmt->get_result();
while ($row = $result_patients->fetch_assoc()) {
    $patients[$row['Username']] = $row['Username'];
}


$stmt = $con->prepare("SELECT id,patient_name, unique_code, doctor_id, appointment_date, status FROM appointments ORDER BY appointment_date DESC LIMIT 10");
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
        content="IE=edge">
    <meta name="viewport"
        content="width=device-width, 
        initial-scale=1.0">
    <title>Doctor Appointment Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="responsive.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        .report-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .crime-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: left;
            font-size: 0.9em;
        }

        .crime-table th,
        .crime-table td {
            border: none;
            padding: 12px 15px;
            border-color: black;
        }

        .crime-table thead tr {
            background-color: #4f46e5;
            color: #ffffff;
            text-align: left;
        }

        .crime-table tbody tr {
            border-bottom: 1px solid #eeeeee;
            transition: background-color 0.3s;
        }

        .crime-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .crime-table tbody tr:hover {
            background-color: #f3f4f6;
        }

        .crime-table tbody tr:last-of-type {
            border-bottom: 2px solid #e5e7eb;
        }

        .box-container {
            margin-left: 15px;
            display: center;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
    </style>
</head>


<body>
    <header>
        <div class="logo">AppointCare</div>
        <div class="searchbar">
            <h2>Welcome to Admin Dashboard</h2>
        </div>

        <div class="message">
            <div class="dp">
                <a href="admin_logout.php">
                    <img src="img/logout.png" class="dpicn" alt="dp">
                </a>
            </div>
        </div>

    </header>

    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <div class="nav-option option1">
                        <img
                            src="https://media.geeksforgeeks.org/wp-content/uploads/20221210182148/Untitled-design-(29).png"
                            class="nav-img"
                            alt="dashboard">
                        <h3>Dashboard</h3>
                    </div>

                    <a href="appointments.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/schedule.png" class="nav-img" alt="Appointments">
                            <h3>Appointments</h3>
                        </div>
                    </a>

                    <a href="doctors.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/doctor.png" class="nav-img" alt="Doctors">
                            <h3>Doctors</h3>
                        </div>
                    </a>
                    <a href="patients.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/hospitalisation.png" class="nav-img" alt="Patients">
                            <h3>Patients</h3>
                        </div>
                    </a>
                    <a href="departments.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/medical.png" class="nav-img" alt="Departments">
                            <h3>Departments</h3>
                        </div>
                    </a>

                    <a href="feedback.php" style="color: black;">
                        <div class="option2 nav-option">
                            <img src="img/feedback.png" class="nav-img" alt="Feedback">
                            <h3>Patient Feedback</h3>
                        </div>
                    </a>
                </div>

            </nav>
        </div>


        <div class="main">
            <div class="box-container">
                <div class="box box1">
                    <div class="text">
                        <h2 class="topic-heading"><?php echo number_format($total_appointments); ?></h2>
                        <h2 class="topic">Total Appointments</h2>
                    </div>

                    <img src="img/schedule.png" alt="Appointments">
                </div>



                <div class="box box5">
                    <div class="text">
                        <h2 class="topic-heading"><?php echo number_format($total_doctors); ?></h2>
                        <h2 class="topic">Total Doctors</h2>
                    </div>
                    <img src="img/doctor.png" alt="Total Doctors">
                </div>

                <div class="box box6">
                    <div class="text">
                        <h2 class="topic-heading"><?php echo number_format($total_patients); ?></h2>
                        <h2 class="topic">Total Patients</h2>
                    </div>
                    <img src="img/hospitalisation.png" alt="Total Patients">
                </div>

                <div class="box box6">
                    <div class="text">
                        <h2 class="topic-heading"><?php echo number_format($total_patients); ?></h2>
                        <h2 class="topic">Total Feedback</h2>
                    </div>
                    <img src="img/hospitalisation.png" alt="Total Patients">
                </div>
            </div>

            <div class="report-container">
                <div class="report-header">
                    <h1 class="recent-Articles">Recent Appointments</h1>
                    <a href="appointments.php">
                        <button class="view">View All</button>
                    </a>
                </div>

                <div class="report-body">

                    <table class="crime-table">
                        <thead>
                            <tr>
                                <th>Appt. ID</th>
                                <th>Date & Time</th>
                                <th>Patient Name</th>
                                <th>Doctor Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                                    <td><?php
                                        $patient_id = $row['patient_name'];
                                        echo htmlspecialchars($patients[$patient_id] ?? " " . $patient_id);
                                        ?></td>
                                    <td><?php
                                        $doctor_id = $row['doctor_id'];
                                        echo htmlspecialchars($doctors[$doctor_id] ?? " " . $doctor_id);
                                        ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <script src="./index.js"></script>
</body>

</html>