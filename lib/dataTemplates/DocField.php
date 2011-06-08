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
    private $label;
    private $dataType;
    private $required;
    private $unique;
    private $inputType;
    private $length;

    function  __construct($id, $label, $dataType, $required, $unique) {
        $this->id       = $id;
        $this->label    = $label;
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

    function setLabel($label){
        $this->label = $label;
    }

    function getLabel(){
        return $this->label;
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

    function setInputType($inputType){
        $this->inputType = $inputType;
    }

    function getInputType(){
        return $this->inputType;
    }

    function setLength($length){
        $this->length = $length;
    }

    function getLength($length){

    }

    function toJSON(){
        $arr = array(   'id'        =>  $this->id,
                        'label'     =>  $this->label,
                        'datatype'  =>  $this->dataType,
                        'required'  =>  $this->required,
                        'unique'    =>  $this->unique
                    );

        return json_encode($arr);
    }

    function fromJSON($json){
        $object = json_decode($json,true);

        $this->id       = $object["id"];
        $this->label    = $object["label"];
        $this->dataType = $object["datatype"];
        $this->required = $object["required"];
        $this->unique   = $object["unique"];

        return true;
    }

    function  __toString() {
        return   "id: "         . $this->id
               . ", label: "    . $this->label
               . ", datatype: " . $this->dataType
               . ", required: " . $this->required
               . ", unique: "   . $this->unique;
    }
}
?>
