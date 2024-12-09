<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Prevent caching
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

include_once("connections/connection.php");

$con = connection();

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $address = $_POST['address']; // New field for Address
    $facebook = $_POST['facebook']; // New field for Facebook URL
    $email = $_POST['email']; // New field for Email
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];

    // Handle photo upload or external file path
    $photo_path = '';

    // Check if a file has been uploaded
    if (!empty($_FILES['image']['name'])) {
        // Handle file upload
        $photo_name = basename($_FILES['image']['name']);
        $photo_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $photo_name);
        $photo_tmp_name = $_FILES['image']['tmp_name'];

        // Generate a unique name for the uploaded image
        $unique_name = uniqid() . "_" . $photo_name;

        // Validate file type
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $photo_extension = pathinfo($photo_name, PATHINFO_EXTENSION);
        if (!in_array(strtolower($photo_extension), $allowed_extensions)) {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
            exit();
        }

        // Create uploads folder if it doesn't exist
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Move the uploaded file to the uploads folder
        $photo_folder = "uploads/" . $unique_name;
        if (move_uploaded_file($photo_tmp_name, $photo_folder)) {
            $photo_path = $photo_folder;  // Set photo path to the uploaded image
        } else {
            echo "Error uploading the photo.";
            exit();
        }
    }

    // Insert data into the database, including the photo path
    $sql = "INSERT INTO memberslist (Firstname, Lastname, Age, Address, Facebook, Email, Gender, Birthday, Image) 
            VALUES ('$firstname', '$lastname', '$age', '$address', '$facebook', '$email', '$gender', '$birthday', '$photo_path')";
    $con->query($sql) or die($con->error);

    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Add Font Awesome CDN -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .sidebar {
            background-color: #343a40;
            height: 100vh;
            color: white;
            display: flex;
            flex-direction: column;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 15px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .sidebar .logout {
            margin-top: auto; /* Push the sign out link to the bottom */
        }

        .main-content {
            min-height: 100vh;
            padding: 20px;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Sidebar -->
    <div class="d-flex">
        <div class="sidebar p-3">
            <h4 class="text-white">Family Dashboard</h4>
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <a href="add.php"><i class="fas fa-user-plus"></i> Add Member</a>
            <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
            <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
            <!-- Sign Out button placed at the bottom -->
            <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
        </div>

        <!-- Main Content -->
        <div class="main-content container-fluid p-4">
            <div class="form-container">
                <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%;"> 
                    <h1 class="text-center mb-4">Add New Member</h1>

                    <form action="" method="post" enctype="multipart/form-data" class="bg-white shadow-sm rounded p-4">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">First Name:</label>
                            <input type="text" name="firstname" id="firstname" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last Name:</label>
                            <input type="text" name="lastname" id="lastname" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age:</label>
                            <input type="number" name="age" id="age" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address:</label>
                            <input type="text" name="address" id="address" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="facebook" class="form-label">Facebook Profile URL:</label>
                            <input type="url" name="facebook" id="facebook" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender:</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="birthday" class="form-label">Birthday:</label>
                            <input type="date" name="birthday" id="birthday" class="form-control">
                        </div>

                        <!-- Photo upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Photo:</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <button type="submit" name="submit" class="btn btn-success w-100">Add Member</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="index.php" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
