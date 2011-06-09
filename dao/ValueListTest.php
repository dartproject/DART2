<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    require_once "ValueListDAO.php";
    require_once "DB.php";




    $newList = new ValueListDAO("Countries");
    echo var_dump($newList);

    $newList->addValue("USA");
    echo "Added 1 value <br/>";

    $newList->addValue("Chile");
    echo "Added 2 value <br/>";
    
    $newList->addValue("Poland");
    echo "Added 3 value <br/>";

    $newList->addValue("Canada");
    echo "Added 4 value <br/>";

    $newList->save();
    echo "List saved <br/>";

    $newList=null;
    $newList = new ValueListDAO("Countries");

    echo "List object: <br/>";
    echo var_dump($newList);

    echo "<br/>List values <br/>";
    $list = $newList->getValues();
    if(isset($list))
    foreach($list as $value){
        echo $value . "<br/>";
    }

    echo var_dump($newList->getValues());

    $result = ValueListDAO::getAvailableLists();
    echo var_dump($result);
    echo $result[0]['_id'];
    
?>
