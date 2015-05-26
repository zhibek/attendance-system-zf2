<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\DialogHelper;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;

class CamelCaseTech_Resource_Entitymanager extends Zend_Application_Resource_ResourceAbstract
{

    /**
     * @var Doctrine\Orm\EntityManager
     */
    protected $_entityManager;

    public function loadEntityManager($connection)
    {
        $options = $this->getOptions();

        // required for annotation classes paths to be found
        AnnotationRegistry::registerFile(APPLICATION_PATH . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

        $configuration = new Configuration();
        $annotationReader = new AnnotationReader();
        $driver = new AnnotationDriver($annotationReader, array($options['schemaDir']));
        $configuration->setProxyDir($options['proxyDir']);
        $configuration->setProxyNamespace($options['proxyNamespace']);
        $configuration->setAutoGenerateProxyClasses($options['autoGenerateProxyClasses']);
        $configuration->setMetadataDriverImpl($driver);

        $cache = new \Doctrine\Common\Cache\ArrayCache();

        $configuration->setMetadataCacheImpl($cache);
        $configuration->setQueryCacheImpl($cache);

        return EntityManager::create($connection, $configuration);
    }

    /**
     * Retrieve initialized DB connection
     *
     * @return null|Zend_Db_Adapter_Interface
     */
    public function getEntityManager()
    {
        $options = $this->getOptions();

        if ((null === $this->_entityManager)) {
            if (!isset($options['connection'])) {
                $connection = $this->getBootstrap()
                    ->bootstrap('dbal')
                    ->getResource('dbal')
                    ->getConnection();
            } else if (is_string($options['connection'])) {
                $connection = $this->getBootstrap()
                    ->bootstrap('dbal')
                    ->getResource('dbal')
                    ->getConnection($options['connection']);
            } else {
                $connection = $options['connection'];
            }
            $this->_entityManager = $this->loadEntityManager($connection);
        }
        return $this->_entityManager;
    }

    /**
     * Defined by Zend_Application_Resource_Resource
     *
     * @return Zend_Db_Adapter_Abstract|null
     */
    public function init()
    {
        if (null !== ($em = $this->getEntityManager())) {
            return $em;
        }
    }

    public function getHelperSet($helperSet)
    {
        $entityManager = $this->getEntityManager();
        $helperSet->set(new EntityManagerHelper($entityManager), 'em');
        $helperSet->set(new DialogHelper(), 'dialog');
    }

}