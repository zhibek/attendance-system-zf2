<?php
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\DBAL\DriverManager;

class CamelCaseTech_Resource_Dbal extends Zend_Application_Resource_ResourceAbstract
{
    /**
     * Database connections
     * 
     * @var Doctrine\DBAL\Connection[]
     */
    protected $_connections = array();

    /**
     * The default database connection
     * 
     * @var Doctrine\DBAL\Connection
     */
    protected $_default;

    public function init()
    {
        $options = $this->getOptions();
        $config = new \Doctrine\DBAL\Configuration();

        foreach ($options as $id => $params) {
            $default = isset($params['default']) ? $params['default'] : false;
            unset($params['default']);

            $connection = DriverManager::getConnection($params, $config);
            $this->_connections[$id] = $connection;

            if ($default) {
                $this->_setDefault($connection);
            }
        }

        return $this;
    }

    /**
     * Get the default db connection
     *
     * @param  boolean $justPickOne If true, a random (the first one in the stack)
     *                           connection is returned if no default was set.
     *                           If false, null is returned if no default was set.
     * @return null|Doctrine\DBAL\Connection
     */
    public function getDefault($justPickOne = true)
    {
        if ($this->_default !== null) {
            return $this->_default;
        }

        if ($justPickOne) {
            return reset($this->_connections); // Return first db in db pool
        }

        return null;
    }

    public function hasConnection($name)
    {
        return isset($this->_connections[$name]);
    }

    public function getConnection($name = null)
    {
        if ($name === null) {
            return $this->getDefault();
        }

        if ($this->hasConnection($name)) {
            return $this->_connections[$name];
        }

        throw new Zend_Application_Resource_Exception(
            'A DB adapter was tried to retrieve, but was not configured'
        );
    }

    protected function _setDefault($connection)
    {
        $this->_default = $connection;
    }

    public function getHelperSet($helperSet)
    {
        $helperSet->set(new ConnectionHelper($this->getConnection()), 'db');
    }
}
