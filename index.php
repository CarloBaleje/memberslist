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

// Fetch total members count
$sql_total = "SELECT COUNT(*) as total FROM memberslist";
$result_total = $con->query($sql_total);
$total_members = $result_total->fetch_assoc()['total'];

// Fetch male and female counts
$sql_gender = "SELECT Gender, COUNT(*) as count FROM memberslist GROUP BY Gender";
$result_gender = $con->query($sql_gender);

$gender_data = [];
while ($row = $result_gender->fetch_assoc()) {
    $gender_data[$row['Gender']] = $row['count'];
}

$male_count = $gender_data['Male'] ?? 0;
$female_count = $gender_data['Female'] ?? 0;

// Fetch member data for the table
$sql_members = "SELECT * FROM memberslist ORDER BY Lastname ASC";
$result_members = $con->query($sql_members);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Members Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 15px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .summary-card {
            border-radius: 10px;
            padding: 20px;
            color: #fff;
        }
        .summary-card h3 {
            margin: 0;
            font-size: 2rem;
        }
        .table-responsive {
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
        }
        .btn-add {
            background-color: #007bff;
            color: #fff;
        }
        /* Ensure sign out is at the bottom */
        .sidebar .logout {
            margin-top: auto;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3">
        <h4 class="text-white">Family Dashboard</h4>
        <a href="index.php"><i class="fas fa-home"></i> Home</a>
        <a href="add.php"><i class="fas fa-user-plus"></i> Add Member</a>
        <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
        <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
        <!-- Sign Out button placed at the bottom of the sidebar -->
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
    </div>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row my-4">
            <div class="col-12">
                <h1 class="text-primary">Welcome to the Family Members Dashboard</h1>
                <p class="text-secondary">Manage your family members efficiently.</p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="summary-card bg-primary">
                    <h3><?php echo $total_members; ?></h3>
                    <p>Total Members</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card bg-success">
                    <h3><?php echo $male_count; ?></h3>
                    <p>Male Members</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="summary-card bg-danger">
                    <h3><?php echo $female_count; ?></h3>
                    <p>Female Members</p>
                </div>
            </div>
        </div>

        <!-- Members Table -->
        <div class="table-responsive">
            <div class="d-flex justify-content-between mb-3">
                <h2 class="text-dark">Family Members List</h2>
                <a href="add.php" class="btn btn-add"><i class="fas fa-plus"></i> Add New Member</a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_members->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['ID']; ?></td>
                            <td><?php echo htmlspecialchars($row['Firstname']); ?></td>
                            <td><?php echo htmlspecialchars($row['Lastname']); ?></td>
                            <td><?php echo htmlspecialchars($row['Gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['Age']); ?></td>
                            <td>
                                <a href="details.php?ID=<?php echo $row['ID']; ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i> View</a>
                                <a href="update.php?ID=<?php echo $row['ID']; ?>" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i> Edit</a>
                                <a href="delete.php?ID=<?php echo $row['ID']; ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
