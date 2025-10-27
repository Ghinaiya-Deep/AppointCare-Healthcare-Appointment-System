<?php
include '../config.php'; 

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
$query = "SELECT * From appointments";

$result = $con->query($query);
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
    <link rel="stylesheet"
        href="style.css">
    <link rel="stylesheet"
        href="responsive.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        
        .container {
            margin: 10px;
            padding: 8px;
            background: #ffffff; 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow-x: auto; 
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }


        table {
            width: 100%;
            min-width: 1000px; 
            border-collapse: collapse;
            margin-top: 20px;
            text-align: left;
            font-size: 0.9em;
        }

        th,
        td {
            padding: 12px 15px;
            border: 1px solid #eeeeee;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #4f46e5;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
        }

        tbody tr {
            transition: background-color 0.3s;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f3f4f6;
        }

        td:nth-child(5) { 
            max-width: 180px;
            white-space: nowrap; 
            overflow: hidden;
            text-overflow: ellipsis; 
        }

        .status-pending {
            background-color: #f39c12; 
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }

        .status-inprogress {
            background-color: #3498db; 
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }

        .status-solved {
            background-color: #27ae60;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }

        .nav-option img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .box-container {
            margin-left: 15px;
            display: grid; 
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
    </style>
</head>


<body>

    <header>


        <div class="logo">AppointCare
            </div>


        <div class="searchbar">
            <h2>Welcome to Admin Dashboard</h2>
        </div>


        <div class="message">
            <div class="dp">
                <a href="logout.php">
                    <img src="img/logout.png" class="dpicn" alt="dp">
                </a>
            </div>
        </div>

    </header>

    <div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <a href="admin_dashboard.php" style="color: black;">
                        <div class="nav-option option1">
                            <img
                                src="https://media.geeksforgeeks.org/wp-content/uploads/20221210182148/Untitled-design-(29).png"
                                class="nav-img"
                                alt="dashboard">
                            <h3>Dashboard</h3>
                        </div>
                    </a>

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



        <br><br>
        <div class="container">
            <h2>Total Appointments of AppointCare</h2>

            <table>
                <thead>
                    <tr>
                        <th>Appt. ID</th>
                        <th>Patient Name</th>
                        <th>Patient Email</th>
                        <th>Patient Mobile</th>
                        <th>Patient Address</th>
                        <th>Appointment Date</th>
                        <th>Department</th>
                        <th>Doctor Name</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { 
                        $status_class = '';
                        if ($row['status'] == 'Pending') {
                            $status_class = 'status-pending';
                        } elseif ($row['status'] == 'Confirmed') {
                            $status_class = 'status-inprogress';
                        } elseif ($row['status'] == 'Completed') {
                            $status_class = 'status-solved';
                        }
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['unique_code']); ?></td>
                            <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['patient_email']); ?></td>
                            <td><?php echo htmlspecialchars($row['patient_phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['patient_address']); ?></td>
                            <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['department_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['doctor_id']); ?></td>
                            
                            <td>
                                <span class="<?php echo $status_class; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        </section>

    </div>
    </div>

    <script src="./index.js"></script>
</body>

</html>