<?php
function connect()
{
	//get config
	$config = json_decode(file_get_contents('./config.json'), true);
	//get sql info
	$DATABASE_HOST = $config['sqlInfo']['DATABASE_HOST'];
	$DATABASE_USER = $config['sqlInfo']['DATABASE_USER'];
	$DATABASE_PASS = $config['sqlInfo']['DATABASE_PASS'];
	$DATABASE_NAME = $config['sqlInfo']['DATABASE_NAME'];
	//connect to database
	$con = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	//check if connection is successful
	if ($con->connect_error) {
		die('Connection failed: ' . $con->connect_error);
	}
	return $con;
}
function lisää($con, $lisättävä)
{
	if (empty($lisättävä)) {
		exit("ei lisättävää");
	}
	$lisättävä = $con->real_escape_string($lisättävä);
	$sql = "INSERT INTO test (test) VALUES ('$lisättävä')";
	if (
		$con->
			query($sql) === TRUE
	) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $con->error;
	}
}

function hae($con)
{
	$sql = "SELECT * FROM test";
	if ($result = $con->query($sql)) {
		while ($row = $result->fetch_assoc()) {
			echo $row['test'] . "<br>";
		}
		$result->free();
	}
}

?>