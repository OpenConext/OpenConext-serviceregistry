<?php
define("JANUS_ROOT_FOLDER", dirname(dirname(__FILE__)));
define("JANUS_VENDOR_FOLDER", JANUS_ROOT_FOLDER . '/vendor');

require_once JANUS_VENDOR_FOLDER . "/autoload.php";

use Doctrine\Common\Annotations\SimpleAnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

class sspmod_janus_DiContainer extends Pimple
{
    const ENTITY_MANAGER = 'entityManager';
    const ANNOTATION_DRIVER = 'annotationDriver';

    /** @var sspmod_janus_DiContainer */
    private static $instance;

    public function __construct()
    {
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

    /** @return EntityManager */
    public function getEntityManager()
    {
        return $this[self::ENTITY_MANAGER];
    }

    protected function registerEntityManager()
    {
        $this[self::ENTITY_MANAGER] = $this->share(function (sspmod_janus_DiContainer $container)
        {
            $isDevMode = false;

            // @todo make this variable
            // the connection configuration
            $dbParams = array(
                'driver'   => 'pdo_mysql',
                'user'     => 'root',
                'password' => 'c0n3xt',
                'dbname'   => 'serviceregistry',
            );

            $config = new \Doctrine\ORM\Configuration();
            // @todo implement cache
//            $config->setMetadataCacheImpl($cacheDriver);
//            $config->setQueryCacheImpl($cacheDriver);
//            $config->setResultCacheImpl($cacheDriver);
            $config->setAutoGenerateProxyClasses((bool) !$isDevMode);
            // @todo set correct dir
            $config->setProxyDir('tmp');
            $config->setProxyNamespace('Proxies');

            $annotationReader = $container->getAnnotationReader();
            $paths = array(JANUS_ROOT_FOLDER  . "/lib/model");
            $driverImpl =  new AnnotationDriver($annotationReader, $paths);
            $config->setMetadataDriverImpl($driverImpl);

            $em = EntityManager::create($dbParams, $config);

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
                $annotationReader = new SimpleAnnotationReader();

                AnnotationRegistry::registerFile(JANUS_VENDOR_FOLDER . '/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

                $annotationReader->addNamespace('Doctrine\ORM\Mapping');

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