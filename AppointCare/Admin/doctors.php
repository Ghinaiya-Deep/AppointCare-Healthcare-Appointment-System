<?php
include '../config.php'; 

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
$query = " SELECT * From doctors";

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
    <title>Doctor Appointment Admin Panel - Doctors</title>
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
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
            min-height: 50vh;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            min-width: 1200px;
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

        td:nth-child(8) {
            max-width: 300px;
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
        }

        .action-btn {
            display: inline-block;
            padding: 5px 10px;
            margin: 2px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.85em;
            transition: background-color 0.2s;
        }

        .edit-btn {
            background-color: #3498db;
            color: white;
        }

        .edit-btn:hover {
            background-color: #2980b9;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .main-container {
            display: flex;
        }

        .navcontainer {
            width: 250px;
            flex-shrink: 0;
        }

        .container-wrapper {
            flex-grow: 1;
            padding: 10px;
        }

        .box-container {
            margin-left: 15px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .container h2 {
            padding-top: 10px;
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
                        <div class="option2 nav-option active">
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



        <div class="container-wrapper">
            <br>
            <div class="container">
                <h2>Manage Hospital Doctors</h2>
                <a href="add_doctor.php" style="float: right; padding: 10px 15px; background: green; color: white; text-decoration: none; border-radius: 5px;">
                    + Add Doctors
                </a>
                <br><Br>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Specialization</th>
                            <th>Department</th>
                            <th>Hospital Name</th>
                            <th>Hospital Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($row['specialization']); ?></td>
                                    <td><?php echo htmlspecialchars($row['department_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['hospital_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['hospital_address']); ?></td>
                                    <td>
                                        <a href="edit_doctor.php?id=<?php echo $row['id']; ?>" class="action-btn edit-btn">Edit</a>
                                        <a href="delete_doctor.php?id=<?php echo $row['id']; ?>" class="action-btn delete-btn">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="9" style="text-align: center;">No doctor records found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="./index.js"></script>
</body>

</html>