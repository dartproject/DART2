<?php

/*
function __autoload($classname) {
   include_once($classname . ".php");
} 
 */

include_once("StudentADO.php");

$studentADO = new StudentADO();
$s = $studentADO->read(array("4defec248f2d965f16660000","4defec248f2d965f166e0000","4defec248f2d965f16760000"));
//Util::printArray($s);

$s = array();
$date = getDate(strtotime("1983-09-10"));
$s[] = array('studentID' => '1',
		'fname' => 'Cristina',
		'lname' => 'Melo',
		'gender' => 'Female',
		'birthDate' => $date,
		'ethnicity' => "Hispanic",
		'address' => '5855 Darlington Rd Apt C3',
		'city' => 'Pittsburgh',
		'postalCode' => '15217',
		'californiaID' => 3452
		);
$s[] = array('studentID' => '2',
		'fname' => 'Sonia',
		'lname' => 'Lagos',
		'gender' => 'Female',
		'birthDate' => $date,
		'ethnicity' => "Multi-Ethnic",
		'address' => '6525 Monitor St Apt 2',
		'city' => 'Pittsburgh',
		'postalCode' => '15217',
		'californiaID' => 675475
		);
$ids = $studentADO->create($s);
Util::printArray($ids);

?>
