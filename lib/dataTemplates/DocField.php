<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DocField
 *
 * @author Bolek
 */
class DocField {
    private $id;
    private $dataType;
    private $required;
    private $unique;

    function  __construct($id, $dataType, $required, $unique) {
        $this->id       = $id;
        $this->dataType = $dataType;
        $this->required = $required;
        $this->unique   = $unique;
    }

    function setID($id){
        $this->id = $id;
    }

    function getID(){
        return $this->id;
    }

    function setDataType($datatype){
        $this->dataType=$datatype;
    }

    function getDataType(){
        return $this->dataType;
    }

    function setRequired($required){
        $this->required = $required;
    }

    function getRequired(){
        return $this->required;
    }

    function setUnique($unique){
        $this->unique = $unique;
    }

    function getUnique(){
        return $this->unique;
    }

    function toJSON(){
        $arr = array(   'id'        =>  $this->id,
                        'dataType'  =>  $this->dataType,
                        'required'  =>  $this->required,
                        'unique'    =>  $this->unique
                    );

        return json_encode($arr);
    }

    function fromJSON($json){
        $object = json_decode($json,true);

        $this->id       = $object["id"];
        $this->dataType = $object["dataType"];
        $this->required = $object["required"];
        $this->unique   = $object["unique"];

        return true;
    }

    function  __toString() {
        return   "id: "         . $this->id
               . ", dataType: " . $this->dataType
               . ", required: " . $this->required
               . ", unique: "   . $this->unique;
    }
}
?>
