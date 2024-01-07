<?php

// Start the session (this should be at the beginning of your script)
session_start();

function redirectToHomepage($delay = 3, $url = "index.html") {
    echo '<script>
            setTimeout(function() {
                window.location.href = "' . $url . '";
            }, ' . ($delay * 500) . '); // Redirect after ' . $delay . ' seconds
          </script>';
}

$con = mysqli_connect('localhost', 'root', '', 'iGadgetZone');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $usernameOrEmail = $_POST["username_or_email"];
    $password = $_POST["password"];

   // Hash the password before storing it in the database
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert into the database using a prepared statement
$sql = "INSERT INTO signup (username_or_email, password) VALUES (?, ?)";
$stmt = mysqli_prepare($con, $sql);

// Bind parameters and execute the statement
mysqli_stmt_bind_param($stmt, "ss", $usernameOrEmail, $hashedPassword);
$result = mysqli_stmt_execute($stmt);


    // Check if the insertion was successful
    if ($result) {
        // Redirect to the homepage upon successful signup
        redirectToHomepage();
    } else {
        // Display an error message for unsuccessful signup
        echo "Signup failed. Please try again.";
    }

} else {
    // Redirect or display an error message if accessed directly without a POST request
    echo "Invalid access.";

    // Redirect back to the homepage using the function
    redirectToHomepage();
}

// Close the database connection
mysqli_close($con);

?>
