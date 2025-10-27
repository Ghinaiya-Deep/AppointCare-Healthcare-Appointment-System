<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Patient Registration</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">

        <?php 

        include("../config.php");

        function validateInput($username, $email, $age, $mobile, $password) {
            $errors = [];

            if (!is_numeric($age) || $age < 0 || $age > 120 || floor($age) != $age) {
                $errors[] = "Please enter a valid age (between 0 and 120, not in decimal).";
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Please enter a valid email address.";
            }

            if (!preg_match('/^[0-9]{10}$/', $mobile)) {
                $errors[] = "Please enter a valid 10-digit mobile number.";
            }

            $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/';
            if (!preg_match($passwordRegex, $password)) {
                $errors[] = "Password must be at least 8 characters long, containing uppercase, lowercase, number, and special character.";
            }

            return $errors;
        }

        if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $mobile = $_POST['mobile'];
            $password = $_POST['password'];

            $errors = validateInput($username, $email, $age, $mobile, $password);

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<div class='message'><p>$error</p></div><br>";
                }
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
            } else {
                $verify_query = mysqli_query($con, "SELECT Email FROM users WHERE Email='$email'");

                if(mysqli_num_rows($verify_query) != 0) {
                    echo "<div class='message'>
                              <p>This email is used, Try another One Please!</p>
                          </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                } else {
                    mysqli_query($con, "INSERT INTO users(Username,Email,Age,Mobile,Password) VALUES('$username','$email','$age','$mobile','$password')") or die("Error Occurred");

                    echo "<div class='message' style='color: green;'>
                              <p>Registration successful! Now You can Login</p>
                          </div> <br>";
                    echo "<a href='login.php'><button class='btn' style='background-color: rgba(76,68,182,0.808); color: white;'>Login Now</button></a>";
                }
            }
        } else {

        ?>

            <header style="text-align: center;">Patient Registration</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="mobile">Mobile Number</label>
                    <input type="text" name="mobile" id="mobile" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    Already a member? <a href="login.php">Sign In</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>
