<?php
include '../config.php'; 
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $doctor_id = $_GET['id'];

    $query = $con->prepare("SELECT * FROM doctors WHERE id = ?");
    $query->bind_param("i", $doctor_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $doctor = $result->fetch_assoc();
    } else {
        echo "<script>console.error('Invalid Doctor ID'); window.location.href='doctors.php';</script>";
        exit;
    }
} else {
    echo "<script>console.error('No Doctor ID provided'); window.location.href='doctors.php';</script>";
    exit;
}

$departments = $con->query("SELECT id, name FROM departments ORDER BY name ASC");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];
    $hospital_name = $_POST['hospital_name'];
    $hospital_address = $_POST['hospital_address'];

    $stmt = $con->prepare("
        UPDATE doctors 
        SET 
            name=?, email=?, phone=?, specialization=?, hospital_name=?, hospital_address=?, department_id=? 
        WHERE id=?
    ");
    
    $stmt->bind_param(
        "ssssssii", 
        $name, 
        $email, 
        $phone, 
        $specialization, 
        $hospital_name, 
        $hospital_address, 
        $department_id, 
        $doctor_id
    );
    
    if ($stmt->execute()) {
        echo "<script>alert('Doctor updated successfully!'); window.location.href='doctors.php';</script>";
    } else {
        echo "<script>alert('Error updating doctor. Please try again or check the database connection.');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor Details</title>
    <link rel="stylesheet" href="style.css"> 
</head>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f0f2f5;
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

    input,
    select {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
        box-sizing: border-box;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    input:focus,
    select:focus {
        border-color: #1a73e8;
        box-shadow: 0 0 5px rgba(26, 115, 232, 0.2);
        outline: none;
    }

    button {
        background: #00b894;
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
        box-shadow: 0 4px 10px rgba(0, 184, 148, 0.3);
    }

    button:hover {
        background: #00a082;
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
        <h2>Edit Doctor Details (ID: <?= $doctor_id ?>)</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $doctor_id ?>">
            
            <input type="text" name="name" value="<?= htmlspecialchars($doctor['name']) ?>" placeholder="Full Name" required>
            
            <input type="email" name="email" value="<?= htmlspecialchars($doctor['email']) ?>" placeholder="Email Address" required>
            
            <input type="text" name="phone" value="<?= htmlspecialchars($doctor['phone']) ?>" placeholder="Phone Number" required>
            
            <input type="text" name="specialization" value="<?= htmlspecialchars($doctor['specialization']) ?>" placeholder="Specialization (e.g., Cardiology)" required>

            <input type="text" name="hospital_name" value="<?= htmlspecialchars($doctor['hospital_name']) ?>" placeholder="Hospital Name" required>
            
            <input type="text" name="hospital_address" value="<?= htmlspecialchars($doctor['hospital_address']) ?>" placeholder="Hospital Address" required>

            <select name="department_id" required>
                <option value="">Select Department</option>
                <?php while ($row = $departments->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>" <?= ($row['id'] == $doctor['department_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
            <button type="submit">Update Doctor</button>
        </form>
        <a href="doctors.php" class="back-link">← Back to Doctors List</a>
    </div>
</body>

</html>
