<?php
include_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $address = $_POST["address"];
    $phone = isset($_POST["phone"]) ? $_POST["phone"] : '';

    // Check if the email already exists
    $checkExistingEmailQuery = "SELECT id FROM users WHERE email = ?";
    $checkExistingEmailStmt = $conn->prepare($checkExistingEmailQuery);
    $checkExistingEmailStmt->bind_param("s", $email);
    $checkExistingEmailStmt->execute();
    $checkExistingEmailStmt->store_result();

    if ($checkExistingEmailStmt->num_rows > 0) {
        echo "<script>alert('User with this email already exists. Please use a different email.');</script>";
    } else {
        // Proceed with the registration
        $insertUserQuery = "INSERT INTO users (name, email, password, address, phone_number) VALUES (?, ?, ?, ?, ?)";
        $insertUserStmt = $conn->prepare($insertUserQuery);
        $insertUserStmt->bind_param("sssss", $name, $email, $password, $address, $phone);

        if ($insertUserStmt->execute()) {
            echo "Registration successful! Welcome, $name!";
        } else {
            echo "<script>alert('Error during registration. Please try again.');</script>";
        }

        $insertUserStmt->close();
    }

    $checkExistingEmailStmt->close();
    $conn->close();
}
?>
