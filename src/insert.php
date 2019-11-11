<?php

	$user = "dev";
	$pass = "dev";
	$host = "db";
	$db   = "myapp";

	$conn = new mysqli($host, $user, $pass, $db);

	if ($conn->connect_error)
		die("Connection failed: " . $conn->connect_error);
	
	$temperature = $_GET["temperature"];
	$humidity = $_GET["humidity"];

	$sql = "INSERT INTO temperatures(temperature, humidity, date) VALUES(" . $temperature . "," . $humidity .", NOW())";
	
	if ($conn->query($sql))
		echo "Nuevo registro insertado";
	else
		echo "Error" . $sql . "<br />" . $conn->error;

	$conn->close();

?>