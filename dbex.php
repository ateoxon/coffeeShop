<!doctype html>
<html>
<head>
    <title>php db ex</title>

    <meta charset="utf-8" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

</head>
<body>
<h1> php example </h1>


<?php //create/check connection
$servername = "localhost";
$username = "root";
$password = "123angelo1";
$dbname = "sbuxdto";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

////////////////////////////////////////////////

//$sql = "SELECT id, firstname, lastname FROM MyGuests";
$sql = "SELECT drinkName, tallCost, hotCold FROM drinklist";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Drink: " . $row["drinkName"]. " - Cost of Tall Size: $" . $row["tallCost"]. " " . $row["hotCold"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>






</body>
</html  >
