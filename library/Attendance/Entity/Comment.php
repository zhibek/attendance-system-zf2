<?php

namespace Attendance\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comment
 * @ORM\Entity
 * @ORM\Table(name="comment")
 * @package Attendance\Entity
 */

class Comment
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    public $id;

    /**
     *
     * @ORM\Column(type="string")
     * @var string
     */
    public $body;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Attendance\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var Attendance\Entity\User
     */
    public $user;
    
    /**
     * @ORM\Column(type="integer");
     * @var integer
     */
    public $request_id;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Attendance\Entity\RequestType")
     * @ORM\JoinColumn(name="request_type_id", referencedColumnName="id")
     * @var Attendance\Entity\RequestType
     */
    public $request_type;
    
    /**
     *
     * @ORM\Column(type="datetime")
     * @var datetime
     */
    public $created;
    
}   