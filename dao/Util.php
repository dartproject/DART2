<?php

include_once("DB.php");
class Util {
	
	function connectMySqlDB() {
		$user="dart_user";
		$password="dart_psw";
		$database="dartdb_dartdb";
		mysql_connect('localhost',$user,$password);
		@mysql_select_db($database) or die( "Unable to select database");
	}

	function closeMySqlDB() {
		mysql_close();
	}

	function printArray($x) {
		echo "<pre>";
		print_r($x);
		echo "</pre>";
	}

	function populateMongoDB() {
		Util::connectMySqlDB();
		$query="SELECT studentID, fname, lname, gender, bday, ethnicity, addr, village, zip FROM student WHERE status = 'active' LIMIT 100;";
		$result = mysql_query($query);

		$db = DB::connectDB();

		// select a collection (analogous to a relational database's table)
		$collection = $db->students;

		$ethnicity = array("1" =>  "White (Caucasian)",
				"2" => "Black, Not Hispanic",
				"3" => "Hispanic",
				"4" => "Asian Pacific Islander",
				"5" => "American Indian",
				"6" => "Alaska Native",
				"7" => "Multi-Ethnic",
				"8" => "Native Hawaiian or Pacific Islander");

		// add a records
		while ($row = mysql_fetch_assoc($result)) {
			$obj = array(
				'studentID' => $row['studentID'],
				'fname' => $row['fname'],
				'lname' => $row['lname'],
				'gender' => $row['gender'],
				'birthDate' => new MongoDate(strtotime(str_replace("/","-",$row['bday']))),
				'ethnicity' => $ethnicity[$row['ethnicity']],
				'address' => $row['addr'],
				'city' => $row['village'],
				'postalCode' => $row['zip']);
			$collection->insert($obj);
		}
		Util::closeMySqlDB();
		DB::closeDB();
		Util::printArray($collection->count()." elements");
	}
}

?>
