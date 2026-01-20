<?php

include("html/header.html");
include("php/connection.php");

$sql = "SELECT * FROM student_info";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records - Student System</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
   <h1>Student Records</h1>
   
   <?php if ($result && $result->num_rows > 0): ?>
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
               <td><?php echo htmlspecialchars($row['first_name'] ?? ''); ?></td>
               <td><?php echo htmlspecialchars($row['last_name'] ?? ''); ?></td>
               <td><?php echo htmlspecialchars($row['birthday'] ?? ''); ?></td>
               <td><?php echo htmlspecialchars($row['contact_number'] ?? ''); ?></td>
               <td><?php echo htmlspecialchars($row['email'] ?? ''); ?></td>
           </tr>
           <?php endwhile; ?>
       </tbody>
   </table>
   <?php else: ?>
       <p>No student records found.</p>
   <?php endif; ?>
   
   <br>
   <a href="index.php"><button>Back to Home</button></a>
</body>
</html>

<?php

include("html/footer.html");

?>
