<?php
include_once("config.php");
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $email =$_POST["loginEmail"];
    $password= $_POST["loginPassword"];

    $sql="SELECT id,name,email,password FROM users WHERE email= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id,$name,$email,$hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            echo "Login successful! Welcome, $name!";
        } else {
            echo "Entered Password: $password<br>";
            echo "Hashed Password from DB: $hashed_password<br>";
            echo "<script>alert('Invalid email or password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password. Please try again.');</script>";
    }

    $stmt-> close();
    $conn-> close();
}
?>