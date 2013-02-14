<?php

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="sspmod_janus_Model_Entity_Repository")
 * @ORM\Table(
 *  name="entity",
 *  uniqueConstraints={
 *      @ORM\UniqueConstraint(
 *          name="janus__entity__eid_revisionid",
 *          columns={
 *              "eid",
 *              "revisionid"
 *          }
 *      )
 *  }
 * )
 *
 * @todo find out how to get rid of unique constraint which includes 'janus__' prefix. Furthermore there seem to
 * 2 unique constraints for the same column which in case are the same as the primary key columns...
 */
class sspmod_janus_Model_Entity {
    /**
     * @ORM\Id
     * @ORM\Column(name="eid", type="integer", nullable=false)
     */
    protected  $eid;

    /**
     * @ORM\Column(name="entityid", type="text", nullable=false)
     */
    protected  $entityId;

    /**
     * @ORM\Id
     * @ORM\Column(name="revisionid", type="integer", nullable=false)
     */
    protected  $revisionId;

    /**
     * @ORM\Column(name="state", type="text")
     */
    protected $state;

    /**
     * @ORM\Column(name="type", type="text")
     */
    protected $type;

    /**
     * @ORM\Column(name="expiration", length=25, nullable=true)
     */
    protected $expiration;

    /**
     * @ORM\Column(name="metadataurl", type="text")
     */
    protected $metadataUrl;

    /**
     * @ORM\Column(name="metadata_valid_until", type="datetime", nullable=true)
     * @var DateTime
     */
    protected $metadataValidUntil;

    /**
     * @ORM\Column(name="metadata_cache_until", type="datetime", nullable=true)
     * @var DateTime
     */
    protected $metadataCacheUntil;

    /**
     * @ORM\Column(name="allowedall", length=3, nullable=false)
     */
    protected $allowedAll = 'yes';

    /**
     * @ORM\Column(name="arp", type="integer", nullable=true)
     */
    protected $arp;

    /**
     * @ORM\Column(name="manipulation", type="text")
     */
    protected $manipulation;

    /**
     * @ORM\Column(name="user", type="integer", nullable=true)
     */
    protected $user;

    /**
     * @ORM\Column(name="created", type="datetime", nullable=true)
     * @var Datetime
     */
    protected $created;

    /**
     * @ORM\Column(name="ip", length=15, nullable=true)
     */
    protected $ip;

    /**
     * @ORM\Column(name="parent", type="integer", nullable=true)
     */
    protected $parent;

    /**
     * @ORM\Column(name="revisionNote", type="text")
     */
    protected $revisionNote;

    /**
     * enum('yes','no')
     *
     * @ORM\Column(name="active", nullable=false)
     */
    protected $active = 'yes';

    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setAllowedAll($allowedAll)
    {
        $this->allowedAll = $allowedAll;
        return $this;
    }

    public function getAllowedAll()
    {
        return $this->allowedAll;
    }

    public function setArp($arp)
    {
        $this->arp = $arp;
        return $this;
    }

    public function getArp()
    {
        return $this->arp;
    }

    public function setCreated(DateTime $created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return Datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    public function setEid($eid)
    {
        $this->eid = $eid;
        return $this;
    }

    public function getEid()
    {
        return $this->eid;
    }

    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;
        return $this;
    }

    public function getEntityId()
    {
        return $this->entityId;
    }

    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;
        return $this;
    }

    public function getExpiration()
    {
        return $this->expiration;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function setManipulation($manipulation)
    {
        $this->manipulation = $manipulation;
        return $this;
    }

    public function getManipulation()
    {
        return $this->manipulation;
    }

    /**
     * @param \DateTime $metadataCacheUntil
     */
    public function setMetadataCacheUntil(\DateTime $metadataCacheUntil)
    {
        $this->metadataCacheUntil = $metadataCacheUntil;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getMetadataCacheUntil()
    {
        return $this->metadataCacheUntil;
    }

    public function setMetadataUrl($metadataUrl)
    {
        $this->metadataUrl = $metadataUrl;
        return $this;
    }

    public function getMetadataUrl()
    {
        return $this->metadataUrl;
    }

    /**
     * @param \DateTime $metadataValidUntil
     */
    public function setMetadataValidUntil(\DateTime $metadataValidUntil)
    {
        $this->metadataValidUntil = $metadataValidUntil;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getMetadataValidUntil()
    {
        return $this->metadataValidUntil;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setRevisionId($revisionId)
    {
        $this->revisionId = $revisionId;
        return $this;
    }

    public function getRevisionId()
    {
        return $this->revisionId;
    }

    public function setrevisionNote($revisionNote)
    {
        $this->revisionNote = $revisionNote;
        return $this;
    }

    public function getrevisionNote()
    {
        return $this->revisionNote;
    }

    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }
}