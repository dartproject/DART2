<?php

/**
 * Abstract class with CRUD operations using MongoDB
 *
 * @author Cristina
 */

include_once("../lib/dataTemplates/Document.php");
include_once("Util.php");

abstract class DAO {
	protected $collection;
	private $fields;

	protected function  __construct($file, $collection) {
		$filePath = "../conf/dataTemplates/".$file.".json.mine";
		if(!file_exists($filePath)) {
			die('Configuration file not found');
		}
		$content = file_get_contents($filePath);
		$document = new Document();
		$document->fromJSON($content);
		$this->fields = $document->getFields();
		$db = DB::connectDB(); 
		$this->collection = $db->$collection;
	}

	/**
	 * Receives an array of MongoDB ids and return an array of documents from the DB
	 *
 	*/
	public function read($ids) {
		$docs = array();
		for($i = 0; $i < count($ids); $i++) {
			$curDoc = $this->collection->findOne(array('_id' => new MongoId($ids[$i])));
			if($curDoc == null) return null; /* Document not found in the DB */
			$docs[$i] = array();
			foreach($this->fields as $field) {
				$name = $field->getID();
				if(!array_key_exists($name, $curDoc)) continue;
				$value = $curDoc[$name];
				if($field->getDataType() == "date") {
					$value = getDate($value->sec); 
				}
				$docs[$i][$name] = $value;
			}
		}
		return $docs;
	}

	/**
	 * Receives an array of documents, saves them in the DB and returns an array of MongoDB ids
	 *
 	*/
	public function create($docs) {
		$error = 0;
		$erroField = "";
		$newDocs = array();
		for($i = 0; $i < count($docs); $i++) {
			Util::printArray($docs[$i]);
			$newDocs[$i] = array();
			foreach($this->fields as $field) {
				$name = $field->getID();
				$value = null;
				if((array_key_exists($name, $docs[$i])) && $docs[$i][$name] != "") {
						$value = $docs[$i][$name];
				}
				if($field->getRequired() && $value == null) { /* Missing required value */ 
					$error = 1;
					$errorField = $field;
					break;
				}
				if($value == null) continue; /* Missing non-required value */ 
				if($field->getUnique()) { 
					$same = $this->collection->findOne(array($name => $value));
					if($same != null) { /* Documents in the DB with the same value */
						$error = 2;
						$errorField = $field;
						break;
					}
					for($j = $i + 1; $j < count($docs); $j++) {
							/* todo: Need to use a more general comparator: '1' == 1 */
						if((array_key_exists($name, $docs[$j])) && $docs[$j][$name] == $docs[$i][$name]) {
							/* Documents in $docs with the same value */
							$error = 3;
							$errorField = $field;
							break;
						}
					}
					if ($error) break;
				}
				$dataType = $field->getDataType();
				if($dataType == "integer") {
					if(!is_numeric($value)) {
						$error = 4;
						$errorField = $field;
						break;
					}
					$new_val = intval($value);
					if($value != $new_val) { /* Non-integer number */
						$error = 4;
						$errorField = $field;
						break;
					}
					if(is_string($value)) {
						$value = $new_val;
					}
				} else if ($dataType == "string") {
					if(!is_string($value)) {
						$error = 5;
						$errorField = $field;
						break;
					}
				} else if ($dataType == "date") {
					if(!is_array($value) || !array_key_exists(0, $value) || !is_int($value[0])) {
						$error = 6;
						$errorField = $field;
						break;
					} else {
						$value = new MongoDate($value[0]);
					}
				}

				$newDocs[$i][$name] = $value;
			}
			if($error) {
				echo "ERROR $i $error $errorField";
				return null;
			}
		}
		$ids = array();
		for($i = 0; $i < count($newDocs); $i++) {
			$result = $this->collection->insert($newDocs[$i]);
			if(!$result) die ("Error inserting in DB");
			$ids[$i] = "".$newDocs[$i]["_id"];
		}
		return $ids;
	}
}
?>
