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
?>

<!-- Your HTML code follows here -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
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
        .form-section {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
        }
        .form-section h3 {
            margin-bottom: 20px;
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
        <a href="settings.php" class="active"><i class="fas fa-cog"></i> Settings</a>
        <a href="about.php"><i class="fas fa-info-circle"></i> About</a>
    </div>

    <!-- Main Content -->
    <div class="container-fluid p-4">
        <h1 class="mb-4 text-primary">Settings</h1>

        <div class="row">
            <!-- Theme Settings -->
            <div class="col-md-6 mb-4">
                <div class="form-section shadow-sm">
                    <h3>Theme Settings</h3>
                    <form>
                        <div class="mb-3">
                            <label for="theme" class="form-label">Select Theme</label>
                            <select id="theme" class="form-select">
                                <option value="default">Default</option>
                                <option value="dark">Dark</option>
                                <option value="light">Light</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Notification Settings -->
            <div class="col-md-6 mb-4">
                <div class="form-section shadow-sm">
                    <h3>Notification Settings</h3>
                    <form>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                            <label class="form-check-label" for="emailNotifications">
                                Enable Email Notifications
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="smsNotifications">
                            <label class="form-check-label" for="smsNotifications">
                                Enable SMS Notifications
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Account Settings -->
            <div class="col-md-6 mb-4">
                <div class="form-section shadow-sm">
                    <h3>Account Settings</h3>
                    <form>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" class="form-control" value="admin">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" placeholder="Enter new password">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Data Settings -->
            <div class="col-md-6 mb-4">
                <div class="form-section shadow-sm">
                    <h3>Data Settings</h3>
                    <form>
                        <button type="button" class="btn btn-danger mb-3" onclick="confirmReset()">Reset All Data</button>
                        <button type="button" class="btn btn-warning" onclick="confirmBackup()">Backup Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmReset() {
        if (confirm("Are you sure you want to reset all data? This action cannot be undone.")) {
            // Add reset logic here
            alert("Data reset initiated.");
        }
    }
    function confirmBackup() {
        alert("Data backup in progress...");
        // Add backup logic here
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
