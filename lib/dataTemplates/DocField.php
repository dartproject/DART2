<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DocElement
 *
 * @author Bolek
 */
abstract class DocField {
    protected $key;
    protected $options;

    
    protected $value;
    /***************************************************************************
     * Getters
     **************************************************************************/
    function getKey(){
        return $this->key;
    }

    function getOptions(){
        return $this->options;
    }

    /***************************************************************************
     * Setters
     **************************************************************************/
    function setID($id){
        $this->id = $id;
    }

    function setRequired($required){
        $this->required = $required;
    }

    function setUnique($unique){
        $this->unique = $unique;
    }

    function setValue($value){
        $this->value = $value;
    }

    /***************************************************************************
     * Functions
     **************************************************************************/
    
    abstract function validate();

    function struct2JSON(){
        $arr = array(   'id'        =>  $this->id,
                        'required'  =>  $this->required,
                        'unique'    =>  $this->unique,
                        'dataType'  =>  get_class()
                    );
        return json_encode($arr);
    }
}
?>
