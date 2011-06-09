<?php

/**
 * DAO class for Student
 *
 * @author Cristina
 */

include_once("DAO.php");

class StudentDAO extends DAO {

	function  __construct() {
		parent::__construct("Student", "students");
	}
}
?>
