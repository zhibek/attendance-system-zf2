<?php

class CamelCaseTech_View_Cache implements ArrayAccess
{

    /**
     * @var Zend_Cache_Core
     */
    protected $_cache;

    protected $_namespace = 'mustache_';

    public function __construct($cache, $namespace = null)
    {
        $this->_cache = $cache;

        if (!is_null($namespace)) {
            $this->_namespace = $namespace . '_mustache_';
        }
    }

    protected function _getKey($offset)
    {
        return $this->_namespace . str_replace(array('/', '-', '.'), '_', $offset);
    }

    /* (non-PHPdoc)
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset)
    {
        return $this->_cache->test($this->_getKey($offset));
    }

    /* (non-PHPdoc)
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset)
    {
        return $this->_cache->load($this->_getKey($offset));
    }

    /* (non-PHPdoc)
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value)
    {
        $this->_cache->save($value, $this->_getKey($offset));
    }

    /* (non-PHPdoc)
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset)
    {
        $this->_cache->remove($this->_getKey($offset));
    }

}