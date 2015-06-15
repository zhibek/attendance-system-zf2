<?php
/**
 * Description of Workfromhome
 *
 * @author ahmed
 */
class Requests_Models_Workfromhome 
{
     public function __construct($em, $request = null)
    {
        $this->_em = $em;
        $this->_request = $request;
    }
    
    public function newRequest(){
        
    }
}
