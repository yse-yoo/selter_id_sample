<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'evacuation_system');
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evacuation Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Registered Evacuees</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><img src="../uploads/<?php echo $row['photo']; ?>" alt="Photo" width="100"></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
