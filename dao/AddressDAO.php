<?php

/**
 * DAO class for Address
 *
 * @author Cristina
 */

include_once("DAO.php");

class AddressDAO extends DAO {

	function  __construct() {
		parent::__construct("Address", "Addresses");
	}
}
?>
