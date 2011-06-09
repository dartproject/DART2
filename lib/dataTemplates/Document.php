<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Document
 *
 * @author Bolek
 */


class Document {
    private $id;
    private $version;
    private $fields;

    function  __construct() {
        
    }


    function getID(){
        return $this->id;
    }

    function setID($id){
        $this->id =(string) $id;
    }

    function getVersion(){
        return $this->version;
    }

    function setVersion($version){
        $this->version = (string)$version;
    }

    function getFields(){
        return $this->fields;
    }

    function setFields($fields){
        $this->fields = $fields;
    }


    //Read from JSON
    function fromJSON($json){
        $object = json_decode($json,true);
        
        $this->id = $object["id"];
        $this->version = $object["version"];

        $fields = $object["fields"];

        for($i=0;$i<count($fields);$i++){
            $this->fields[$i]=new DocField($fields[$i]["id"],
                                    $fields[$i]["dataType"],
                                    $fields[$i]["required"],
                                    $fields[$i]["unique"]);
        }
    }

    function  __toString() {
        $result="Document Properties <BR/>";
        $result .= "id: " . $this->id . ", version: " . $this->version ."<br/><br/>";
        $result .= "Document fields: <br/>";
        for($i=0;$i<count($this->fields);$i++){
            $result .= $this->fields[$i] . "<BR/>";
        }

        return $result;
    }
}
?>
