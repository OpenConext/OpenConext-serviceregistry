<?php
// Rename MDUI / UIInfo metadata fields (BACKLOG-974)

/**
 * DbPatch makes the following variables available to PHP patches:
 *
 * @var $this       DbPatch_Command_Patch_PHP
 * @var $writer     DbPatch_Core_Writer
 * @var $db         Zend_Db_Adapter_Abstract
 * @var $phpFile    string
 */

$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

$janusConfig = SimpleSAML_Configuration::getConfig('module_janus.php');

$userController = new sspmod_janus_UserController($janusConfig);
$userController->setUser('engine');
$entities = $userController->getEntities();
/** @var sspmod_janus_Entity $entity */
foreach ($entities as $entity) {
    $entity->setRevisionnote('patch-0017.php: update MDUI/UIInfo/ACS metadata fields (BACKLOG-974)');

    $entityController = new sspmod_janus_EntityController($janusConfig);
    $entityController->setEntity($entity);
    $entityController->loadEntity();

    $metadata = $entityController->getMetadata();

    foreach($metadata as $md) {
        if('displayName:en' === $md->getKey()) {
            $entityController->addMetadata('UIInfo:DisplayName:en', $md->getValue());
            $entityController->removeMetadata('displayName:en');
        }
        if('displayName:nl' === $md->getKey()) {
            $entityController->addMetadata('UIInfo:DisplayName:nl', $md->getValue());
            $entityController->removeMetadata('displayName:nl');
        }
        if('keywords:en' === $md->getKey()) {
            $entityController->addMetadata('UIInfo:Keywords:en', $md->getValue());
            $entityController->removeMetadata('keywords:en');
        }
        if('keywords:nl' === $md->getKey()) {
            $entityController->addMetadata('UIInfo:Keywords:nl', $md->getValue());
            $entityController->removeMetadata('keywords:nl');
        }
        if('logo:0:url' === $md->getKey()) {
            $entityController->addMetadata('UIInfo:Logo:0:url', $md->getValue());
            $entityController->removeMetadata('logo:0:url');
        }
        if('logo:0:width' === $md->getKey()) {
            $entityController->addMetadata('UIInfo:Logo:0:width', $md->getValue());
            $entityController->removeMetadata('logo:0:width');
        }
        if('logo:0:height' === $md->getKey()) {
            $entityController->addMetadata('UIInfo:Logo:0:height', $md->getValue());
            $entityController->removeMetadata('logo:0:height');
        }
        // remove all unsupported ACS Bindings from the metadata
        if(0 === strpos($md->getKey(), 'AssertionConsumerService:')) {
            $e = explode(":", $md->getKey());
            if (3 === count($e) && $e[2] === "Binding") {
                $index = $e[1];
                $supportedSamlBindings = $janusConfig->getArray("supported-saml-bindings");
                if (!in_array($md->getValue(), $supportedSamlBindings)) {
                    // need to remove this ACS completely
                    echo "[INFO] removing unsupported binding '" . $md->getValue() . "' from entity '" . $entity->getEntityid() . "'" . PHP_EOL;
                    $entityController->removeMetadata("AssertionConsumerService:$index:Binding");
                    $entityController->removeMetadata("AssertionConsumerService:$index:Location");
                    $entityController->removeMetadata("AssertionConsumerService:$index:index");
                }
            }
        }
    }
    $entityController->saveEntity();
}
