<?php
use Doctrine\ORM\EntityRepository;

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

        return (int) $builder->getQuery()->getSingleScalarResult();
    }
}
