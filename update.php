<?php
include_once("connections/connection.php");

$con = connection();

$member_id = $_GET['ID']; // Get member ID from URL

// Fetch member details from the database
$sql = "SELECT * FROM memberslist WHERE ID = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the member exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<script>alert('Member not found!'); window.location.href='index.php';</script>";
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated details from the form
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = !empty($_POST['age']) ? intval($_POST['age']) : null;
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $email = $_POST['email'];  // New field for email
    $facebook = $_POST['facebook']; // Add this to capture the Facebook URL

    // Handle photo upload or external file path
    $photo_path = $row['Image']; // Keep existing image if not uploading new

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
            $photo_path = $photo_folder;  // Update photo path with the new image
        } else {
            echo "Error uploading the photo.";
            exit();
        }
    } elseif (!empty($_POST['image_url'])) {
        // If user provides an external URL for the image, use that URL
        $photo_path = $_POST['image_url'];  // Use the URL provided by the user
    }

    // Update the database with the new details including the Facebook URL
    $update_sql = "UPDATE memberslist SET Firstname = ?, Lastname = ?, Age = ?, Gender = ?, Birthday = ?, Address = ?, Email = ?, Image = ?, Facebook = ? WHERE ID = ?";
    $update_stmt = $con->prepare($update_sql);
    $update_stmt->bind_param("ssissssssi", $firstname, $lastname, $age, $gender, $birthday, $address, $email, $photo_path, $facebook, $member_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Member details updated successfully!'); window.location.href = 'details.php?ID=" . $member_id . "';</script>";
        exit();
    } else {
        echo "Error updating record: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- For Icons -->
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #ced4da;
        }

        .btn-primary, .btn-secondary {
            border-radius: 20px;
            padding: 10px 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .img-thumbnail {
            max-width: 150px;
            margin-top: 15px;
        }

        .file-input-wrapper {
            margin-top: 10px;
        }

        .card-body {
            padding: 40px;
        }

        .breadcrumb-item a {
            color: #007bff;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Members System</a>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="details.php?ID=<?php echo $member_id; ?>">Member Details</a></li>
            <li class="breadcrumb-item active" aria-current="page">Update Member</li>
        </ol>
    </nav>

    <!-- Centered Container for the form -->
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-sm" style="max-width: 600px; width: 100%;"> 

            <div class="card-body">
                <h1 class="text-center mb-4">Update Member Details</h1>

                <!-- Update form -->
                <form action="update.php?ID=<?php echo $member_id; ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name:</label>
                        <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($row['Firstname']); ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($row['Lastname']); ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="age" class="form-label">Age:</label>
                        <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($row['Age']); ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <textarea id="address" name="address" class="form-control" rows="3"><?php echo htmlspecialchars($row['Address']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="facebook" class="form-label">Facebook Profile URL:</label>
                        <input type="url" id="facebook" name="facebook" value="<?php echo htmlspecialchars($row['Facebook'] ?? ''); ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender:</label>
                        <select id="gender" name="gender" class="form-select">
                            <option value="Male" <?php echo ($row['Gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($row['Gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="birthday" class="form-label">Birthday:</label>
                        <input type="date" id="birthday" name="birthday" value="<?php echo htmlspecialchars($row['Birthday']); ?>" class="form-control">
                    </div>

                    <!-- Email field -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['Email']); ?>" class="form-control">
                    </div>

                    <!-- Image upload or URL -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Photo:</label>
                        <input type="file" id="image" name="image" class="form-control">
                        <?php if (!empty($row['Image'])): ?>
                            <img src="<?php echo $row['Image']; ?>" alt="Member Photo" class="img-thumbnail mt-2">
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <input type="submit" value="Update Member" class="btn btn-primary">
                        <a href="details.php?ID=<?php echo $row['ID']; ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Member Details</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
