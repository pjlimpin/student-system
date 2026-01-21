<?php
include("connection.php");

$sql = "SELECT * FROM student_info";
$result = $conn->query($sql);

if (!$result) {
    die("Database error: " . $conn->error);
}

// Safe HTML escape (handles NULL values in DB)
function esc($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
    <?php include("../html/header.html"); ?>

    <div style="margin: 20px auto; max-width: 900px; background: rgba(180, 152, 152, 0.8); padding: 30px; border-radius: 10px;">
        <h1 style="text-align: center;">Student Records</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Birthday</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo esc($row['first_name'] ?? null); ?></td>
                            <td><?php echo esc($row['last_name'] ?? null); ?></td>
                            <td><?php echo esc($row['birthday'] ?? null); ?></td>
                            <td><?php echo esc($row['contact_number'] ?? null); ?></td>
                            <td><?php echo esc($row['email'] ?? null); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center;">No student records found.</p>
        <?php endif; ?>

        <div style="text-align: center; margin-top: 20px;">
            <a href="../index.php" style="color: white; text-decoration: underline;">Go Back</a>
        </div>
    </div>

    <?php include("../html/footer.html"); ?>
    <?php $conn->close(); ?>
</body>
</html>