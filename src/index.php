<?php
/*
$servername = "db";
$username = "user";
$password = "password";
$dbname = "exampledb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";
*/
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>class</title>
    </head>
    <body>
        <h1>class</h1>
        <h2>授業の復習システム</h2>
        <h3>講義スライド</h3>
        <ul>
        <?php
            for($i=1;$i<=13;$i++)
            {
                echo "<li><a href='pdf/class.$i.pdf'>pdf$i</a></li>";
            }
        ?>
        </ul>
        
    <body>
</html>