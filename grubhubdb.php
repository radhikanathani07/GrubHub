<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "grubhub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql1 = "CREATE TABLE `grubhub`.`ingredients` 
( `ing_name` VARCHAR(20) NOT NULL ,   
 PRIMARY KEY (`ing_name`)) ENGINE = MyISAM";

$sql = "INSERT INTO ingredients (ing_name) 
           VALUES ('Potato'),('oil'),('brinjal'),('broccoli')";

if ($conn->query($sql) === TRUE) {
  echo "Tables created successfully and data entered";
} else {
  echo "Error creating tables or entering data: " . $conn->error;
}

$conn->close();
?>