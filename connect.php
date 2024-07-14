<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "career_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        $resume = $_FILES['resume']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($resume);

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $target_file)) {
            $sql = "INSERT INTO applications (name, email, phone, resume) VALUES ('$name', '$email', '$phone', '$resume')";
            if ($conn->query($sql) === TRUE) {
                echo "Application submitted successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "No file uploaded or upload error.";
    }
}
include("thank.html");
$conn->close();
?>
