<?php
include '../config.php'; 
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$department = null;
if (isset($_GET['id'])) {
    $department_id = $_GET['id'];

    $query = $con->prepare("SELECT id, name, description FROM departments WHERE id = ?");
    $query->bind_param("i", $department_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $department = $result->fetch_assoc();
    } else {
        echo "<script>console.error('Invalid Department ID'); window.location.href='departments.php';</script>";
        exit;
    }
    $query->close();
} else {
    echo "<script>console.error('No Department ID provided'); window.location.href='departments.php';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department_name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $is_valid = true;

    if (empty($department_name) || !preg_match('/^[A-Za-z\s-]+$/', $department_name)) {
        echo "<script>alert('Department Name must contain only letters, spaces, or hyphens!');</script>";
        $is_valid = false;
    }
    
    if (empty($description) || strlen($description) < 10) {
         echo "<script>alert('Description is required and must be at least 10 characters long.');</script>";
        $is_valid = false;
    }

    if ($is_valid) {
        $checkQuery = $con->prepare("SELECT COUNT(*) as total FROM departments WHERE name = ? AND id != ?");
        $checkQuery->bind_param("si", $department_name, $department_id);
        $checkQuery->execute();
        $checkResult = $checkQuery->get_result()->fetch_assoc();
        $checkQuery->close();

        if ($checkResult['total'] > 0) {
             echo "<script>alert('A department with this name already exists!');</script>";
        } else {
            $stmt = $con->prepare("UPDATE departments SET name=?, description=? WHERE id=?");
            
            $stmt->bind_param(
                "ssi", 
                $department_name, 
                $description, 
                $department_id
            );
            
            if ($stmt->execute()) {
                echo "<script>alert('Department updated successfully!'); window.location.href='departments.php';</script>";
            } else {
                echo "<script>alert('Error updating department. Please try again or check the database connection.');</script>";
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
    <title>Edit Department Details</title>
    <link rel="stylesheet" href="style.css">
</head>

<style>

    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .container {
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: 90%;
        text-align: center;
    }

    h2 {
        color: #1a73e8;
        margin-bottom: 25px;
        font-weight: 600;
        border-bottom: 2px solid #f0f2f5;
        padding-bottom: 10px;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        box-sizing: border-box;
        transition: border-color 0.3s, box-shadow 0.3s;
        resize: vertical;
    }

    input:focus,
    textarea:focus {
        border-color: #1a73e8;
        box-shadow: 0 0 5px rgba(26, 115, 232, 0.2);
        outline: none;
    }

    button {
        background: #4f46e5;
        color: white;
        border: none;
        padding: 12px 20px;
        width: 100%;
        margin-top: 15px;
        border-radius: 8px;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
    }

    button:hover {
        background: #4338ca;
    }

    .back-link {
        display: block;
        margin-top: 20px;
        color: #1a73e8;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<body>
    <div class="container">
        <h2>Edit Department Details (ID: <?= $department_id ?>)</h2>
        <form method="POST">
            <input type="text" name="name" 
                   value="<?= htmlspecialchars($department['name'] ?? '') ?>" 
                   placeholder="Department Name" 
                   required>
            
            <textarea name="description" 
                      placeholder="Description of the department" 
                      rows="4" 
                      required><?= htmlspecialchars($department['description'] ?? '') ?></textarea>
            
            <button type="submit">Update Department</button>
        </form>
        <a href="departments.php" class="back-link">← Back to Departments List</a>
    </div>
</body>

</html>
