<?php


function __autoload($classname) {
   include_once("/" . $classname . ".php");
} 
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$PATH =  $_SERVER['DOCUMENT_ROOT'];


$filePath = $PATH . "/DARTLib/conf/dataTemplates/Student.json";

$content;

if(file_exists($filePath)){
    $content = file_get_contents($filePath);
}

$document = new Document();
$document->fromJSON($content);

echo $document;

?>
