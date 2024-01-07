<?php

// Start the session (this should be at the beginning of your script)
session_start();

function redirectToHomepage($delay = 2, $url = "index.html") {
    echo '<script>
            setTimeout(function() {
                window.location.href = "' . $url . '";
            }, ' . ($delay * 1000) . '); // Redirect after ' . $delay . ' seconds
          </script>';
}

$con = mysqli_connect('localhost', 'root', '', 'iGadgetZone');

// Check the connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $telephone = mysqli_real_escape_string($con, $_POST['tel']);
    $productNumber = mysqli_real_escape_string($con, $_POST['product_number']);
    $totalPrice = mysqli_real_escape_string($con, $_POST['total_price']);

    // Insert user data into the database
    $sql = "INSERT INTO checkout (name, email, address, telephone, product_number, total_price)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($con);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $address, $telephone, $productNumber, $totalPrice);
        mysqli_stmt_execute($stmt);

        echo "Record added successfully";

        // Redirect to homepage
        redirectToHomepage();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($con);
?>
