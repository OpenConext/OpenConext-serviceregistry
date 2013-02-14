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
     * @ORM\Column(name="created", length=25, nullable=true)
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
}