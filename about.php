<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
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
        .content {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
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
        <a href="about.php" class="active"><i class="fas fa-info-circle"></i> About</a>
        <!-- Add Sign Out button -->
        <a href="logout.php" class="mt-auto"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
    </div>

    <!-- Main Content -->
    <div class="container-fluid p-4">
        <div class="content shadow-sm">
            <h1 class="text-primary mb-4">About the System</h1>
            <p>This <strong>Family Members Management System</strong> is designed to help you efficiently organize and maintain information about your family members. With a user-friendly interface and advanced features, this system ensures smooth management of records.</p>

            <h3 class="mt-4">Key Features:</h3>
            <ul>
                <li>View, add, update, and delete family member details.</li>
                <li>Search and filter members for quick access.</li>
                <li>Generate summaries, such as total members and demographic insights.</li>
                <li>Export data for backup or sharing purposes.</li>
            </ul>

            <h3 class="mt-4">Technologies Used:</h3>
            <ul>
                <li><strong>Frontend:</strong> HTML, CSS, Bootstrap 5</li>
                <li><strong>Backend:</strong> PHP</li>
                <li><strong>Database:</strong> MySQL</li>
            </ul>

            <h3 class="mt-4">About the Developer:</h3>
            <p>This system was developed by <strong>Carlo J. Baleje</strong>, a skilled front-end developer and graphic designer specializing in creative and efficient solutions for web applications. Carlo is passionate about crafting professional and functional designs that meet client needs.</p>

            <div class="mt-4">
                <a href="index.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
