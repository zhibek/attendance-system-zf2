<?php

/**
 * Description of CustomTimeValidator
 *
 * @author ahmed
 */
require_once 'Zend/Validate/Abstract.php';

class Zend_Validate_Time extends Zend_Validate_Abstract
{

    const NOT_GREATER = 'notGreater';
//    const MISSING_TOKEN = 'missingToken';

    /**
     * Error messages
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_GREATER => "End time should be greater than start time",
//        self::MISSING_TOKEN => 'No token was provided to match against',
    );

    /**
     * @var array
     */
    protected $_messageVariables = array(
        'token' => '_tokenString'
    );

    /**
     * Original token against which to validate
     * @var string
     */
    protected $_tokenString;
    protected $_token;
    protected $_strict = true;

    /**
     * Sets validator options
     *
     * @param mixed $token
     */
    public function __construct($token = null)
    {
        if ($token instanceof Zend_Config) {
            $token = $token->toArray();
        }

        if (is_array($token) && array_key_exists('token', $token)) {
            if (array_key_exists('strict', $token)) {
                $this->setStrict($token['strict']);
            }

            $this->setToken($token['token']);
        } else if (null !== $token) {
            $this->setToken($token);
        }
    }

    /**
     * Retrieve token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }
    

    /**
     * Set token against which to compare
     *
     * @param  mixed $token
     * @return Zend_Validate_Time
     */
    public function setToken($token)
    {
        $this->_tokenString = $token;
        $this->_token = $token;
        return $this;
    }
    
    protected function explodeToken($token){
		$startTime = explode(":", $token);
        $token = $startTime;
        return $token;
        
	}


    /**
     * Returns the strict parameter
     *
     * @return boolean
     */
    public function getStrict()
    {
        return $this->_strict;
    }

    /**
     * Sets the strict parameter
     *
     * @param Zend_Validate_Time
     * @return $this
     */
    public function setStrict($strict)
    {
        $this->_strict = (boolean) $strict;
        return $this;
    }

    protected function explodeValue($value){
		$endTime = explode(":", $value);
        $value = $endTime;
        return $value;
	}
	
    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if a token has been set and the provided value
     * matches that token.
     *
     * @param  mixed $value
     * @param  array $context
     * @return boolean
     */
    public function isValid($value, $context = null)
    {  

	#$endTime=  explode(":", $value);
        #$value=$endTime[0];
        $this->_setValue($value);

        if (($context !== null) && isset($context) && array_key_exists($this->getToken(), $context)) {
            $token = $context[$this->getToken()];
        } else {
            $token = $this->getToken();
        }
        
         
        $strict = $this->getStrict();
        $token=$this->explodeToken($token);
        $value=$this->explodeValue($value);

            
        //compare hours
         if (($strict && ($value[0] < $token[0]))) {
            $this->_error(self::NOT_GREATER);
            return false;
         //compare minutes
        } else if ($strict && ($value[0] == $token[0]) && ( ($value[1] == $token[1]) || ($value[1] <$token[1]))) {
            $this->_error(self::NOT_GREATER);
            return false;
        } else {
            return true;
        }

    }


}
