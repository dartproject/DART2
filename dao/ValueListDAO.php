<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of ValueList
 *
 * @author Bolek
 */

require_once 'DB.php';

class ValueListDAO {
    private $name;
    private $values;

    function  __construct($name) {
        $this->name = $name;

        //connect to ValueLists collection
        $collection = DB::con2col("ValueLists");
        echo var_dump($collection);

        //find given DataList
        $list = $collection->findOne(array("name"=>$name));

        if(isset($list))
            $this->values = $list["values"];
    }

    //Get list of available ValueLists
    static function getAvailableLists(){
        $collection = DB::con2col("ValueLists");

        $lists = $collection->find();

        $result;
        $i=0;
        while($lists->hasNext()){
            $result[$i++] = $lists->getNext();
        }
        asort($result);
        return $result;
    }

    function getName(){
        return $this->name;
    }
    
    function setName($name){
        $this->name = $name;
    }

    function getValues(){
        return $this->values;
    }

    function addValue($value){
        if($this->values == 0)
                $this->values= array($value);
        elseif(!in_array($value, $this->values))
                array_push($this->values, $value);
    }

    function save(){
       
        $collection = DB::con2col("ValueLists");

        $doc = array("name"=>$this->getName(), "values"=>$this->getValues());

        $collection->update(array("name"=>$this->name),$doc,array("upsert"=>true));
    }

}
?>
