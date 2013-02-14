<?php
// @todo use ORM prefix for all ORM annotations
//use Doctrine\Mapping\Annotation as ORM;

/**
 * @Entity
 * @Table(
 *  name="janus__entity",
 *  uniqueConstraints={
 *      @UniqueConstraint(
 *          name="janus__entity__eid_revisionid",
 *          columns={
 *              "eid",
 *              "revisionid"
 *          }
 *      )
 *  }
 * )
 */
class sspmod_janus_Model_Entity {
    /**
     * @Id
     * @Column(name="eid", type="integer", nullable=false)
     */
    protected  $eid;

    /**
     * @Column(name="entityid", type="text", nullable=false)
     */
    protected  $entityId;

    /**
     * @Id
     * @Column(name="revisionid", type="integer", nullable=false)
     */
    protected  $revisionId;

    /**
     * @Column(name="state", type="text")
     */
    protected $state;

    /**
     * @Column(name="type", type="text")
     */
    protected $type;

    /**
     * @Column(name="expiration", length=25, nullable=true)
     */
    protected $expiration;

    /**
     * @Column(name="metadataurl", type="text")
     */
    protected $metadataUrl;

    /**
     * @Column(name="metadata_valid_until", type="datetime", nullable=true)
     * @var DateTime
     */
    protected $metadataValidUntil;

    /**
     * @Column(name="metadata_cache_until", type="datetime", nullable=true)
     * @var DateTime
     */
    protected $metadataCacheUntil;

    /**
     * @Column(name="allowedall", length=3, nullable=false)
     */
    protected $allowedAll = 'yes';

    /**
     * @Column(name="arp", type="integer", nullable=true)
     */
    protected $arp;

    /**
     * @Column(name="manipulation", type="text")
     */
    protected $manipulation;

    /**
     * @Column(name="user", type="integer", nullable=true)
     */
    protected $user;

    /**
     * @Column(name="created", length=25, nullable=true)
     */
    protected $created;
    
    /**
     * @Column(name="ip", length=15, nullable=true)
     */
    protected $ip;
    
    /**
     * @Column(name="parent", type="integer", nullable=true)
     */
    protected $parent;
    
    /**
     * @Column(name="revisionnote", type="text")
     */
    protected $revisionnote;

    /**
     * enum('yes','no')
     *
     * @Column(name="active", nullable=false)
     */
    protected $active = 'yes';

}