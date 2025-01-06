<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $inputUsername = trim($_POST['username']);
    $inputPassword = trim($_POST['password']);

    if (!empty($inputUsername) && !empty($inputPassword)) {
        
        $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);

        
        $stmt = $conn->prepare("INSERT INTO login1 (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $inputUsername, $hashedPassword);

        if ($stmt->execute()) {
            echo "Login successful!<br><br>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Please fill out all fields.";
    }
}


$result = $conn->query("SELECT username, password FROM login1");

echo "<table border='1' style='border-collapse: collapse; width: 50%; text-align: left;'>
        <tr>
            <th>Username</th>
            <th>Password (Hashed)</th>
        </tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" .$row['username'] . "</td>
                <td>" .$row['password'] . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='2'>No records found</td></tr>";
}

echo "</table>";

$conn->close();
?>
