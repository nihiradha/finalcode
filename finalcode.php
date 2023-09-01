<?php
// Establish a database connection
$conn = mysqli_connect("localhost", "root", "", "zzz");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Check if the username is available
    $checkNameQuery = "SELECT * FROM vvv WHERE Name = '$name'";
    $resultName = mysqli_query($conn, $checkNameQuery);

    // Check if the email is available
    $checkEmailQuery = "SELECT * FROM vvv WHERE Email = '$email'";
    $resultEmail = mysqli_query($conn, $checkEmailQuery);

    // Check if the username and email already exist
    if (mysqli_num_rows($resultName) > 0 && mysqli_num_rows($resultEmail) > 0) {
        echo "The name and email already exist";
    } elseif (mysqli_num_rows($resultEmail) > 0) {
        echo "The email already exists";
    } elseif (mysqli_num_rows($resultName) > 0) {
        echo "Username already exists";
    } else {
        // Insert data into the database
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
        $phone = $_POST['phone'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $city = $_POST['city'];
        $pincode = $_POST['pincode'];
        $country = $_POST['country'];

        $sql = "INSERT INTO `vvv` (`Name`, `Firstname`, `Lastname`, `Email`, `Password`, `Repassword`, `Phone`, `Address1`, `Address2`, `City`, `Pincode`, `Country`) VALUES ('$name', '$firstname', '$lastname', '$email', '$password', '$repassword', '$phone', '$address1', '$address2', '$city', '$pincode', '$country')";

        if (mysqli_query($conn, $sql)) {
            echo "Data saved";
        } else {
            echo "Error in saving";
        }
    }
} elseif (isset($_POST['check_username'])) {
    // AJAX request
    $username = $_POST['check_username'];
    $checkNameQuery = "SELECT * FROM vvv WHERE Name = '$username'";
    $resultName = mysqli_query($conn, $checkNameQuery);
    if (mysqli_num_rows($resultName) > 0) {
        echo "Username already exists";
    } else {
        echo "Username available";
    }
} elseif (isset($_POST['check_email'])) {
    // AJAX request
    $email = $_POST['check_email'];
    $checkEmailQuery = "SELECT * FROM vvv WHERE Email = '$email'";
    $resultEmail = mysqli_query($conn, $checkEmailQuery);
    if (mysqli_num_rows($resultEmail) > 0) {
        echo "Email already exists";
    } else {
        echo "Email available";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register form</title>
</head>
<body>
    <center>
        <form method="post" action="">
            <table border="0">
                <tr>
                    <td>Name:</td>
                    <td><input type="text" name="name" placeholder="Enter your name" required></td>
                </tr>
                <tr>
                    <td>First Name:</td>
                    <td><input type="text" name="firstname" placeholder="Enter your first name" required></td>
                </tr>
                <tr>
                    <td>Last Name:</td>
                    <td><input type="text" name="lastname" placeholder="Enter your last name" required></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" placeholder="Enter your email" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Enter your password" required></td>
                </tr>
                <tr>
                    <td>Re-enter Password:</td>
                    <td><input type="password" name="repassword" placeholder="Re-enter your password" required></td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td><input type="text" name="phone" placeholder="Enter your phone number" required></td>
                </tr>
                <tr>
                    <td>Address Line 1:</td>
                    <td><input type="text" name="address1" placeholder="Enter your address line 1" required></td>
                </tr>
                <tr>
                    <td>Address Line 2:</td>
                    <td><input type="text" name="address2" placeholder="Enter your address line 2"></td>
                </tr>
                <tr>
                    <td>City:</td>
                    <td><input type="text" name="city" placeholder="Enter your city" required></td>
                </tr>
                <tr>
                    <td>Pincode:</td>
                    <td><input type="text" name="pincode" placeholder="Enter your pincode" required></td>
                </tr>
                <tr>
                    <td>Country:</td>
                    <td><input type="text" name="country" placeholder="Enter your country" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" value="Submit">
                        <input type="reset" name="reset" value="Reset">
                    </td>
                </tr>
            </table>
        </form>
    </center>
    <script>
        document.querySelector('input[name="name"]').addEventListener("input", function () {
            var username = this.value;
            var usernameStatus = document.getElementById("username-status");

            // AJAX to check the availability of the username
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    usernameStatus.innerHTML = xhr.responseText;
                }
            };
            xhr.send("check_username=" + username);
        });

        document.querySelector('input[name="email"]').addEventListener("input", function () {
            var email = this.value;
            var emailStatus = document.getElementById("email-status");

            // AJAX to check the availability of the email
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    emailStatus.innerHTML = xhr.responseText;
                }
            };
            xhr.send("check_email=" + email);
        });
    </script>
</body>
</html>