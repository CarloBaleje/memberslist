<?php
include_once("connections/connection.php");

$con = connection();
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM memberslist";
if (!empty($search_query)) {
    if (is_numeric($search_query)) {
        $sql = "SELECT * FROM memberslist WHERE Age = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $search_query);
    } else {
        $sql = "SELECT * FROM memberslist WHERE Firstname LIKE ? OR Lastname LIKE ? OR Gender LIKE ? OR Birthday LIKE ?";
        $stmt = $con->prepare($sql);
        $like_query = "%$search_query%";
        $stmt->bind_param("ssss", $like_query, $like_query, $like_query, $like_query);
    }
    $stmt->execute();
    $members = $stmt->get_result();
} else {
    $members = $con->query($sql) or die($con->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h1 class="text-center mb-4">Search Results</h1>
        <a href="index.php" class="btn btn-secondary mb-3">Back to Family Members List</a>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Birthday</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($members->num_rows > 0) {
                    while ($row = $members->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Firstname']); ?></td>
                            <td><?php echo htmlspecialchars($row['Lastname']); ?></td>
                            <td><?php echo htmlspecialchars($row['Age']); ?></td>
                            <td><?php echo htmlspecialchars($row['Gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['Birthday']); ?></td>
                            <td>
                                <a href="details.php?ID=<?php echo htmlspecialchars($row['ID']); ?>" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No results found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
