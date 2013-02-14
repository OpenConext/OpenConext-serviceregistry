<?php
use Doctrine\ORM\EntityRepository;

class sspmod_janus_Model_Entity_Repository extends EntityRepository
{
    /**
     * @param int $eid
     * @param null|string $state
     * @return int
     */
    public function getNewestRevision($eid, $state = null)
    {
        $builder = $this->_em->createQueryBuilder();

        $builder->select($builder->expr()->max('Entity.revisionId'));
        $builder->from('sspmod_janus_Model_Entity', 'Entity');

        // Filter by entity id
        $builder->andWhere('Entity.eid = :eid');
        $builder->setParameter('eid', $eid);

        // Optionally filter by state
        if (!is_null($state)) {
            $builder->andWhere('Entity.state = :state');
            $builder->setParameter('state', $state);
        }

        return (int) $builder->getQuery()->getSingleScalarResult();
    }
}
