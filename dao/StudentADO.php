<?php

/**
 * Description of Student
 *
 * @author Cristina
 */

include_once("../lib/dataTemplates/Document.php");
include_once("Util.php");

class StudentADO {
	private $collection;
	private $fields;

	function  __construct() {
		$filePath = "../conf/dataTemplates/Student.json";
		if(!file_exists($filePath)) {
			die('Configuration file not found');
		}

		$content = file_get_contents($filePath);
		$document = new Document();
		$document->fromJSON($content);
		$this->fields = $document->getFields();
		$db = DB::connectDB(); 
		$this->collection = $db->students;
	}

	/**
	 * Receives an array of MongoDB ids and return an array of Students
	 *
 	*/
	function read($ids) {
		$students = array();
		//Util::printArray($this->fields);
		for($i = 0; $i < count($ids); $i++) {
			$curStudent = $this->collection->findOne(array('_id' => new MongoId($ids[$i])));
			if($curStudent == null) return null; /* Student not found in the DB */
			$students[$i] = array();
			foreach($this->fields as $field) {
				$name = $field->getID();
				if(!array_key_exists($name, $curStudent)) continue;
				$value = $curStudent[$name];
				if($field->getDataType() == "date") {
					$value = getDate($value->sec); 
				}
				$students[$i][$name] = $value;
			}
		}
		return $students;
	}

	/**
	 * Receives an array of students, saves them in the DB and return an array of MongoDB ids
	 *
 	*/
	function create($students) {
		$error = 0;
		$newStudents = array();
		for($i = 0; $i < count($students); $i++) {
			Util::printArray($students[$i]);
			$newStudents[$i] = array();
			foreach($this->fields as $field) {
				$name = $field->getID();
				$value = null;
				if((array_key_exists($name, $students[$i])) && $students[$i][$name] != "") {
						$value = $students[$i][$name];
				}
				if($field->getRequired() && $value == null) { /* Missing required value */ 
					$error = 1;
					break;
				}
				if($value == null) continue; /* Missing non-required value */ 
				if($field->getUnique()) { 
					$same = $this->collection->findOne(array($name => $value));
					if($same != null) { /* Records in the DB with the same value */
						$error = 2;
						break;
					}
					for($j = $i + 1; $j < count($students); $j++) {
							/* todo: Need to use a more general comparator: '1' == 1 */
						if((array_key_exists($name, $students[$j])) && $students[$j][$name] == $students[$i][$name]) {
							/* Records in $students with the same value */
							$error = 3;
							break;
						}
					}
					if ($error) break;
				}
				$dataType = $field->getDataType();
				if($dataType == "integer") {
					if(!is_numeric($value)) {
						$error = 4;
						break;
					}
					$new_val = intval($value);
					if($value != $new_val) { /* Non-integer number */
						$error = 4;
						break;
					}
					if(is_string($value)) {
						$value = $new_val;
					}
				} else if ($dataType == "string") {
					if(!is_string($value)) {
						$error = 5;
						break;
					}
				} else if ($dataType == "date") {
					if(!is_array($value) || !array_key_exists(0, $value) || !is_int($value[0])) {
						$error = 6;
						break;
					} else {
						$value = new MongoDate($value[0]);
					}
				}

				$newStudents[$i][$name] = $value;
			}
			if($error) {
				echo "ERROR $i $error";
				return null;
			}
		}
		$ids = array();
		for($i = 0; $i < count($newStudents); $i++) {
			$result = $this->collection->insert($newStudents[$i]);
			if(!$result) die ("Error inserting in DB");
			$ids[$i] = "".$newStudents[$i]["_id"];
		}
		return $ids;
	}


}
?>
