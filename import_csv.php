<?php
include("php/connection.php");

// File to import
$csvFile = "sample_students.csv";

// Check if file exists
if (!file_exists($csvFile)) {
    die("Error: CSV file '$csvFile' not found!");
}

// Open the CSV file
$file = fopen($csvFile, "r");

// Skip the header row
$header = fgetcsv($file);

// Counter for imported records
$imported = 0;
$errors = 0;

echo "<h2>Importing CSV Data...</h2>";
echo "<pre>";

// Read and import each row
while (($data = fgetcsv($file)) !== FALSE) {
    // Skip empty rows
    if (empty(array_filter($data))) {
        continue;
    }
    
    // Prepare data
    $first_name = $conn->real_escape_string($data[0]);
    $last_name = $conn->real_escape_string($data[1]);
    $birthday = $conn->real_escape_string($data[2]);
    $contact_number = $conn->real_escape_string($data[3]);
    $email = $conn->real_escape_string($data[4]);
    $username = $conn->real_escape_string($data[5]);
    $password = password_hash($data[6], PASSWORD_DEFAULT); // Hash the password
    
    // Insert query
    $sql = "INSERT INTO student_info (first_name, last_name, birthday, contact_number, email, username, password) 
            VALUES ('$first_name', '$last_name', '$birthday', '$contact_number', '$email', '$username', '$password')";
    
    if ($conn->query($sql)) {
        $imported++;
        echo "✓ Imported: $first_name $last_name\n";
    } else {
        $errors++;
        echo "✗ Error importing $first_name $last_name: " . $conn->error . "\n";
    }
}

fclose($file);

echo "\n";
echo "=================================\n";
echo "Import Complete!\n";
echo "Successfully imported: $imported records\n";
echo "Errors: $errors records\n";
echo "=================================\n";
echo "</pre>";

echo "<br><a href='students_record.php'><button>View Student Records</button></a>";
echo "<a href='index.php'><button>Back to Home</button></a>";

$conn->close();
?>
