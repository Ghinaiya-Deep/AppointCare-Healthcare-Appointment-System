<?php
include '../config.php'; // Include database connection

session_start();
// Check if the user is logged in
if (!isset($_SESSION['admin'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department_name = trim($_POST['department_name']);
    $description = trim($_POST['description']);
    $is_valid = true;

    // 1. Validation: Department Name (Letters, spaces, hyphens only)
    if (empty($department_name)) {
        echo "<script>alert('Department Name is required!');</script>";
        $is_valid = false;
    } elseif (!preg_match('/^[A-Za-z\s-]+$/', $department_name)) {
        echo "<script>alert('Department Name must contain only letters, spaces, or hyphens!');</script>";
        $is_valid = false;
    }

    // 2. Validation: Description (Required, minimum length of 10 characters)
    if (empty($description)) {
        echo "<script>alert('Description is required!');</script>";
        $is_valid = false;
    } elseif (strlen($description) < 10) {
        echo "<script>alert('Description must be at least 10 characters long.');</script>";
        $is_valid = false;
    }

    if ($is_valid) {

        $checkQuery = $con->prepare("SELECT COUNT(*) as total FROM departments WHERE name = ?");
        $checkQuery->bind_param("s", $department_name);
        $checkQuery->execute();
        $checkResult = $checkQuery->get_result()->fetch_assoc();
        $checkQuery->close();

        if ($checkResult['total'] > 0) {
            echo "<script>alert('Department already exists!');</script>";
        } else {
            $stmt = $con->prepare("INSERT INTO departments (name, description) VALUES (?, ?)");
            $stmt->bind_param("ss", $department_name, $description);

            if ($stmt->execute()) {
                echo "<script>alert('Department added successfully!'); window.location.href='departments.php';</script>";
            } else {
                echo "<script>alert('Error adding department. Please try again!');</script>";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Department</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>

    body {
        font-family: Arial, sans-serif;
        background: #f4f4f4;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        max-width: 450px;
        width: 100%;
        text-align: center;
    }

    h2 {
        color: #333;
        margin-bottom: 20px;
    }

    input[type="text"],
    textarea {
        width: calc(100% - 20px);
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        resize: vertical;
    }

    button {
        background: #4f46e5;
        color: white;
        border: none;
        padding: 12px;
        width: 100%;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: bold;
    }

    button:hover {
        background: #4338ca;
    }

    .back-link {
        display: block;
        margin-top: 15px;
        color: #007bff;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="container">
        <h2>Add New Hospital Department</h2>
        <form method="POST">

            <input type="text" name="department_name" placeholder="Department Name (e.g., Cardiology)" required>

            <textarea name="description" placeholder="A brief description of the department's focus and services (min 10 characters)" rows="4" required></textarea>

            <button type="submit">Add Department</button>
        </form>
        <a href="departments.php" class="back-link">← Back to Departments List</a>
    </div>
</body>

</html>