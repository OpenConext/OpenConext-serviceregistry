<?php

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *  name="metadata",
 *  uniqueConstraints={
 *      @ORM\UniqueConstraint(
 *          name="janus__metadata__eid_revisionid_key",
 *          columns={
 *              "eid",
 *              "revisionId",
 *              "key"
 *          }
 *      )
 *  }
 * )
 */
class sspmod_janus_Model_Entity_Metadata
{
    /**
     * @ORM\Id
     * @ORM\Column(name="eid", type="integer", nullable=false)
     * @var int
     */
    protected  $eid;
    
    /**
     * @ORM\Id
     * @ORM\Column(name="revisionid", type="integer", nullable=false)
     * @var int
     */
    protected  $revisionId;


    /**
     * @ORM\Id
     * @ORM\Column(name="key", type="text", nullable=false)
     * @var string
     */
    protected $key;

    /**
     * @ORM\Column(name="value", type="text", nullable=false)
     * @var string
     */
    protected $value;

    /**
     * @ORM\Column(name="created", type="datetime", nullable=false)
     * @var DateTime
     */
    protected $created;

    /**
     * @ORM\Column(name="ip", length=15, nullable=false)
     * @var string
     */
    protected $ip;

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param int $eid
     */
    public function setEid($eid)
    {
        $this->eid = $eid;
        return $this;
    }

    /**
     * @return int
     */
    public function getEid()
    {
        return $this->eid;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param int $revisionId
     */
    public function setRevisionId($revisionId)
    {
        $this->revisionId = $revisionId;
        return $this;
    }

    /**
     * @return int
     */
    public function getRevisionId()
    {
        return $this->revisionId;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
