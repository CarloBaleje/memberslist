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

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "<script>alert('Member not found!'); window.location.href='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Adjusted styling for consistency with homepage */
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
            margin-top: auto;
        }

        .main-content {
            min-height: 100vh;
            padding: 20px;
        }

        .member-photo {
            max-width: 100%;
            height: auto;
            border-radius: 50%;
            border: 5px solid #f8f9fa;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            background-color: #ffffff;
        }

        .breadcrumb {
            background-color: #f8f9fa;
            padding: 10px;
        }

        .btn-outline-secondary {
            border-color: #495057;
            color: #495057;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .card {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
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
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
    </div>

    <!-- Main Content -->
    <div class="main-content container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Member Details</li>
            </ol>
        </nav>

        <!-- Member Details Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow-lg">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h2 class="card-title text-center mb-4"><?php echo htmlspecialchars($row['Firstname']) . ' ' . htmlspecialchars($row['Lastname']); ?></h2>

                                <div class="mb-3">
                                    <strong>First Name:</strong> <?php echo htmlspecialchars($row['Firstname']); ?>
                                </div>
                                <div class="mb-3">
                                    <strong>Last Name:</strong> <?php echo htmlspecialchars($row['Lastname']); ?>
                                </div>
                                <div class="mb-3">
                                    <strong>Age:</strong> <?php echo htmlspecialchars($row['Age']); ?>
                                </div>
                                <div class="mb-3">
                                    <strong>Gender:</strong> <?php echo htmlspecialchars($row['Gender']); ?>
                                </div>
                                <div class="mb-3">
                                    <strong>Birthday:</strong> <?php echo htmlspecialchars($row['Birthday']); ?>
                                </div>
                                <div class="mb-3">
                                    <strong>Email:</strong> <?php echo htmlspecialchars($row['Email']); ?>
                                </div>
                                <div class="mb-3">
                                    <strong>Address:</strong> <?php echo htmlspecialchars($row['Address']); ?>
                                </div>
                                <div class="mb-3">
                                    <strong>Facebook:</strong> 
                                    <?php if (!empty($row['Facebook'])): ?>
                                        <a href="<?php echo htmlspecialchars($row['Facebook']); ?>" target="_blank" class="text-primary">
                                            <i class="fab fa-facebook"></i> Visit Profile
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Not provided</span>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a href="index.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Back to Members List</a>
                                    <a href="update.php?ID=<?php echo $row['ID']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- Styled Member Photo -->
                            <img src="<?php echo !empty($row['Image']) ? $row['Image'] : 'https://via.placeholder.com/150'; ?>" class="img-fluid rounded member-photo" alt="Member Photo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
