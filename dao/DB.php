<?php

/**
 * Database connection
 *
 * @author Cristina
 */

class DB {

	//Mongo Connection
	private static $m;
	
	CONST DB_NAME = "dart";
	CONST DB_ADDRESS = "localhost:27017";

	static function connectDB() {
		$conString = self::DB_ADDRESS;
                try{

                    self::$m = new Mongo("mongodb://" . self::DB_ADDRESS, array("persist"=>"x"));
                    $db=self::$m->selectDB(self::DB_NAME);
                    
                }catch(MongoConnectionException $e){
                    die('Error connecting to MongoDB Server');
                }catch(MongoException $e){
                    die('Error: ' .$e->getMessage());
                }
		
		return $db;
	}


        //connect to collection
	static function con2col($collection){
		$db = self::connectDB();
                $collection = $db->selectCollection($collection);
                return $collection;
	}


        //close connection
	static function closeDB() {
		self::$m->close();
	}
}

?>
