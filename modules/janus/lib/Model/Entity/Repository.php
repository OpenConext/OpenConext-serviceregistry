<?php
use Doctrine\ORM\EntityRepository;

use DoctrineExtensions\Query\Mysql\IfNull;


class sspmod_janus_Model_Entity_Repository extends EntityRepository
{
    /**
     * @param int $eid
     * @param null|string $state
     * @return null|int
     */
    public function getNewestRevision($eid, $state = null)
    {
        $builder = $this->_em->createQueryBuilder();

        $builder->select($builder->expr()->max('Entity.revisionId'));
        $builder->from('sspmod_janus_Model_Entity', 'Entity');

        // Filter by eid
        $builder->andWhere('Entity.eid = :eid');
        $builder->setParameter('eid', $eid);

        // Optionally filter by state
        if (!is_null($state)) {
            $builder->andWhere('Entity.state = :state');
            $builder->setParameter('state', $state);
        }

        $newestRevision = $builder->getQuery()->getSingleScalarResult();
        if (is_null($newestRevision)) {
            return;
        }

        return (int) $newestRevision;
    }

    /**
     * @return int
     */
    public function getNewestEid()
    {
        $builder = $this->_em->createQueryBuilder();

        $builder->select($builder->expr()->max('Entity.eid'));
        $builder->from('sspmod_janus_Model_Entity', 'Entity');

        // @todo check if null should be returned
        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param $entityId
     * @return int
     */
    public function getEid($entityId)
    {
        $builder = $this->_em->createQueryBuilder();

        $builder->select('DISTINCT Entity.eid');
        $builder->from('sspmod_janus_Model_Entity', 'Entity');

        // Filter by entity id
        $builder->andWhere('Entity.entityId = :entityId');
        $builder->setParameter('entityId', $entityId);

        return $builder->getQuery()->getScalarResult();
    }

    /**
     * Get nr of revisions for a given entity by eid
     *
     * @param $eid
     * @return int
     */
    public function getHistorySize($eid)
    {
        $builder = $this->_em->createQueryBuilder();

        $builder->select($builder->expr()->count('Entity'));
        $builder->from('sspmod_janus_Model_Entity', 'Entity');

        // Filter by eid
        $builder->andWhere('Entity.eid = :eid');
        $builder->setParameter('eid', $eid);

        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    public function getCollectionByStateAndType($active, array $state, array $type, $eid, $config)
    {
        $builder = $this->_em->createQueryBuilder();
        $builder
            ->select(
                array(
                    'DISTINCT Entity.eid',
                    'Entity.revisionId',
                    'Entity.created',
                    'Entity.state',
                    'Entity.type',
                    'IFNULL(Metadata.value, Entity.entityId) AS `orderfield`'
                )
            )
            ->from('sspmod_janus_Model_Entity', 'Entity')
            ->where('active', ':active')
            ->setParameter('active', $active)
            // Select entity (only last revision)
            ->andWhere(
                'Entity.revisionId',
                $builder
                    ->select($builder->expr()->max('EntityRevision.revisionId'))
                    ->from('entity', 'EntityRevision')
                    ->andWhere('EntityRevision.eid = Entity.eid')
                    ->groupBy('EntityRevision.eid')
            )
            ->orderBy('created', 'ASC');

        if (!empty($state)) {
            $builder->andWhere($builder->expr()->in('state', $state));
        }

        if (!empty($type)) {
            $builder->andWhere($builder->expr()->in('type', $type));
        }

        // Find default value for sort field so it can be excluded
        /** @var $sortFieldName string */
        $sortFieldName = $this->_config->getString('entity.prettyname', NULL);
        // Try to sort results by pretty name from metadata
        if ($sortFieldName) {
            $fieldDefaultValue = $this->getDefaultOrderFieldFromConfig($config, $sortFieldName);
            // @todo check this if
            if (!empty($fieldDefaultValue)) {
                $builder->leftJoin(
                    'metadata',
                    'Metadata',
                    'ON',
                    'Metadata.key = :fieldDefaultValue
                        AND Metadata.eid = Entity.eid
                        AND Metadata.revisionId = Entity.revisionId
                        AND Metadata.value != :sortFieldName'
                )
                ->setParameter(':fieldDefaultValue', $fieldDefaultValue)
                ->setParameter(':sortFieldName', $sortFieldName)
                // Override order
                ->orderBy('orderField', 'ASC');
            }
        }
//
//        if ($st === false) {
//            SimpleSAML_Logger::error('JANUS: Error fetching all entities');
//            return false;
//        }
//
//        $rs = $st->fetchAll(PDO::FETCH_ASSOC);

    }

    private function getDefaultOrderFieldFromConfig(Zend_Config $config, $sortFieldName)
    {
        if ($sortFieldDefaultValue = $config->getArray('metadatafields.saml20-idp', FALSE)) {
            if (isset($sortFieldDefaultValue[$sortFieldName])) {
                return $sortFieldDefaultValue[$sortFieldName]['default'];
            }
        } else if ($sortFieldDefaultValue = $config->getArray('metadatafields.saml20-sp', FALSE)) {
            if (isset($sortFieldDefaultValue[$sortFieldName])) {
                return $sortFieldDefaultValue[$sortFieldName]['default'];
            }
        }
    }
}
