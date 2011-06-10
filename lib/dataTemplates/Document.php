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

require_once "TemplateNotFoundException.php";
require_once "TemplateWrongFormatException.php";
require_once "DocFieldFactory";

class Document {
    private $structName;
    private $structVersion;
    private $fields;

    CONST STRUCTURE_TEMPLATES_PATH = "/DARTLib/conf/dataTemplates/";


    function  __construct($object,$structName) {
        $template = $_SERVER['DOCUMENT_ROOT'] . self::STRUCTURE_TEMPLATES_PATH . 
            $structNameName . ".json";
        
        if(!file_exists($template))
            throw new TemplateNotFoundException("Template " . $structName .
                    " not found");
            
        $json = file_get_contents($template);

        $struct = json_decode($json,true);

        if(isset($struct["name"]))
            $this->structName = $struct["name"];
        else
            throw new TemplateWrongFormatException(
                    "Name of strcuture not found: 'name'");

        if(isset($struct["version"]))
            $this->structVersion = $struct["version"];
        else
            throw new TemplateWrongFormatException (
                    "Version of structure not found: 'version')");

        foreach($struct["fields"] as $fStruct){
            //if field exists in received object - create new field
            if(isset($object[$fStruct["key"]]))
                array_push ($this->fields, 
                        DocFieldFactory::createDocField ($fStruct,
                        $object[$fStruct["key"]]));
        }
    }
    
    function validate(){
        foreach($fields as $field){
            if(!$field->validate())
                    return false;
        }
        return true;
    }


    function getStructureName(){
        return $this->structName;
    }

    function setStructureName($structName){
        $this->id =(string) $structName;
    }

    function getStructureVersion(){
        return $this->version;
    }

    function setStructureVersion($version){
        $this->version = (string)$version;
    }

    function getFields(){
        return $this->fields;
    }

    function setFields($fields){
        $this->fields = $fields;
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

    function getValue(){
        $obj = array();
        foreach($fields as $field){
            $obj[$field->getKey()]=$field->getValue();
        }

        return $obj;
    }
}
?>
