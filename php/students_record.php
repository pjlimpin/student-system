<?php

include("../html/header.html");
include("connection.php");
$sql = "SELECT * FROM student_info";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body>
   <h1>Student Records</h1>
   <thead>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
    </tr>
   </thead>
   <br>
   <tbody>
    <?php do { ?>

    <tr>
        <td><?php echo htmlspecialchars($row['first_name']); ?></td>
        <td><?php echo htmlspecialchars($row['last_name']); ?></td><br>
    </tr>
    <?php } while ($row = $result->fetch_assoc()); ?>
       </tbody>
</body>
</html>


<?php


include("../html/footer.html");

?>