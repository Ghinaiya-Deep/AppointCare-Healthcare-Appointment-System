<?php
require "../config.php";
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

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
    <title>Feedbacks</title>
    <link rel="stylesheet"
        href="style.css">
    <link rel="stylesheet"
        href="responsive.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>
<style>
    .main-container {
        display: flex;
        justify-content: center;
    }

    .container {
        max-width: 80%;
        margin: 20px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow-x: auto;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        overflow-x: auto;
        border: 1px solid #ccc;
    }

    th,
    td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ccc;
    }

    th {
        background-color: #cadcfc;
        color: black;
        border: 1px solid #ccc;
    }

    tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    tr:nth-child(odd) {
        background-color: #ffffff;
    }

    tr:hover {
        background-color: #e9ecef;
    }

    .edit-btn {
        background-color: #27ae60;
        color: white;
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        display: inline-block;
        transition: 0.3s ease-in-out;
        border: none;
    }

    .edit-btn:hover {
        background-color: #219150;
    }

    .delete-btn {
        background-color: #e74c3c;
        color: white;
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        display: inline-block;
        transition: 0.3s ease-in-out;
        border: none;
    }

    .delete-btn:hover {
        background-color: #c0392b;
    }

    td a {
        margin: 3px;
    }
</style>

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


        <br><br>
        <div class="container">
            <h2>Total Feedback</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Feedback ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Message</th>
                        <th>Rating</th>
                        <th>Create At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $sql = "SELECT * FROM feedback"; 
                    $result = mysqli_query($con, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['patient_name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['message']}</td>
                        <td>{$row['rating']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a href='delete_feedback.php?id={$row['id']}' class='delete-btn' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>


        </div>

        </section>

    </div>
    </div>

    <script src="./index.js"></script>
</body>

</html>