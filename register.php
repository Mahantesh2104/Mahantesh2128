<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    
    $sql = "INSERT INTO register1 (Username, Password, Email, Phone_Number) 
            VALUES ('$username', '$password', '$email', '$phone_number')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!<br><br>";
    } else {
        echo "Error: " . $conn->error;
    }

    
    $result = $conn->query("SELECT Username, Email, Phone_Number FROM register1");

    echo "<table border='1'>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
            </tr>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['Username'] . "</td>
                    <td>" . $row['Email'] . "</td>
                    <td>" . $row['Phone_Number'] . "</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No records found</td></tr>";
    }
    echo "</table>";
}

$conn->close();
?>
