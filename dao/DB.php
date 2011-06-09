<?php

/**
 * Database connection
 *
 * @author Cristina
 */

class DB {

	private static $m;

	function connectDB() {
		self::$m = new Mongo();
		return self::$m->dart;
	}

	function closeDB() {
		self::$m->close();
	}
}

?>
