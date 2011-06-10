<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TemplateNotFoundException
 *
 * @author Bolek
 */
class TemplateNotFoundException extends Exception {
    function  __construct($message) {
        parent::__construct($message);
    }
}
?>
