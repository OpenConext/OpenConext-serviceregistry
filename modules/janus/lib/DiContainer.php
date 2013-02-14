<?php
define("JANUS_ROOT_FOLDER", dirname(dirname(__FILE__)));
define("JANUS_VENDOR_FOLDER", JANUS_ROOT_FOLDER . '/vendor');

require_once JANUS_VENDOR_FOLDER . "/autoload.php";

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

class sspmod_janus_DiContainer extends Pimple
{
    const CONFIG = 'config';
    const ENTITY_MANAGER = 'entityManager';
    const ANNOTATION_DRIVER = 'annotationDriver';

    /** @var sspmod_janus_DiContainer */
    private static $instance;

    public function __construct()
    {
        $this->registerConfig();
        $this->registerEntityManager();
        $this->registerAnnotationReader();
    }

    /**
     * @return sspmod_janus_DiContainer
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof sspmod_janus_DiContainer) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return SimpleSAML_Configuration
     */
    public function getConfig()
    {
        return $this[self::CONFIG];
    }

    protected function registerConfig()
    {
        $this[self::CONFIG] = $this->share(function (sspmod_janus_DiContainer $container)
        {
            $config = SimpleSAML_Configuration::getConfig('module_janus.php');
            return $config;
        });
    }

    /** @return EntityManager */
    public function getEntityManager()
    {
        return $this[self::ENTITY_MANAGER];
    }

    protected function registerEntityManager()
    {
        $this[self::ENTITY_MANAGER] = $this->share(function (sspmod_janus_DiContainer $container)
        {
            $config = $container->getConfig();
            $dbConfig = $config->getArray('store');

            // @todo make this variable
            $isDevMode = false;

            // Configure connection
            $dbParams = array(
                'driver'   => 'pdo_mysql',
                'user'     => $dbConfig['username'],
                'password' => $dbConfig['password'],
                'dbname'   => $dbConfig['dsn'],
            );

            $config = new \Doctrine\ORM\Configuration();

            // @todo implement cache
            // Configure caching
//            $config->setMetadataCacheImpl($cacheDriver);
//            $config->setQueryCacheImpl($cacheDriver);
//            $config->setResultCacheImpl($cacheDriver);

            // Configure Proxy class generation
            $config->setAutoGenerateProxyClasses((bool) !$isDevMode);
            // @todo set correct dir
            $config->setProxyDir('tmp');
            $config->setProxyNamespace('Proxies');

            // Configure annotation reader
            $annotationReader = $container->getAnnotationReader();
            $paths = array(JANUS_ROOT_FOLDER  . "/lib/model");
            $driverImpl =  new AnnotationDriver($annotationReader, $paths);
            $config->setMetadataDriverImpl($driverImpl);

            // Configure table name refix
            $tablePrefix = new sspmod_janus_DoctrineExtensions_TablePrefixListener($dbConfig['prefix']);
            $eventManager = new \Doctrine\Common\EventManager;
            $eventManager->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);

            $em = EntityManager::create($dbParams, $config, $eventManager);

            return $em;
        });
    }

    /** @return \Doctrine\Common\Annotations\Reader */
    public function getAnnotationReader()
    {
        return $this[self::ANNOTATION_DRIVER];
    }

    /**
     * Creates annotation reader
     *
     * @return Doctrine\Common\Annotations\CachedReader
     */
    protected function registerAnnotationReader()
    {
        $this[self::ANNOTATION_DRIVER] = $this->share(
            function (sspmod_janus_DiContainer $container)
            {
                $annotationReader = new AnnotationReader();

                AnnotationRegistry::registerFile(JANUS_VENDOR_FOLDER . '/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

    // @todo enable caching
    //            $cacheDriver = $this->getCacheDriver();
    //            $cacheDriver->setNamespace('doctrine-annotation-cache');
    //
    //            $annotationReader = new \Doctrine\Common\Annotations\CachedReader(
    //                $annotationReader,
    //                $cacheDriver,
    //                false
    //            );

                return $annotationReader;
            }
        );
    }
}