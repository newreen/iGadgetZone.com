<?php

function redirectToHomepage($delay = 3, $url = "index.html") {
    echo '<script>
            setTimeout(function() {
                window.location.href = "' . $url . '";
            }, ' . ($delay * 1000) . '); // Redirect after ' . $delay . ' seconds
          </script>';
}

$con = mysqli_connect('localhost', 'root', '', 'iGadgetZone');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email address from the form
    $email = $_POST["email"];

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Process the email (you can add your own logic here)
    echo "Thank you for subscribing!";
    // You may want to store the email in your database or send a confirmation email, etc.

    // Insert into the database using a prepared statement
    $sql = "INSERT INTO email (email) VALUES (?)";
    $stmt = mysqli_prepare($con, $sql);

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "s", $email);
    $result = mysqli_stmt_execute($stmt);

    // Redirect back to the homepage using the function
    redirectToHomepage();

} else {
    // Redirect or display an error message if accessed directly without a POST request
    echo "Invalid access.";
 
    // Redirect back to the homepage using the function
    redirectToHomepage();
} }

// Close the database connection
mysqli_close($con);
?>
