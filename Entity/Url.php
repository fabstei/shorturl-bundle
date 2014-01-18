<?php

namespace Fabstei\ShorturlBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Fabstei\ShorturlBundle\Model\UrlInterface;

/**
 * Fabstei\ShorturlBundle\Entity\Url
 *
 * @ORM\Table(name="fabstei_shorturl")
 * @ORM\Entity(repositoryClass="Fabstei\ShorturlBundle\Entity\UrlRepository")
 * @UniqueEntity("token")
 */
class Url implements UrlInterface
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $token
     *
     * @ORM\Column(name="token", type="string", length=50, unique=true, nullable=true)
     */
    private $token;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private $url;

    /**
     * @var datetime $datetime
     *
     * @ORM\Column(name="datetime", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $datetime;

    /**
     * @ORM\ManyToOne(targetEntity="Fabstei\ShorturlBundle\Model\UserInterface", inversedBy="urls")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    public function __tostring()
    {
        return 'Fabstei\ShorturlBundle\Entity\Url';
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set token
     *
     * @param  string $token
     * @return this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set url
     *
     * @param  string $url
     * @return this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set datetime
     *
     * @param  datetime $datetime
     * @return this
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return datetime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set user
     *
     * @param  Fabstei\ShorturlBundle\Model\UserInterface $user
     * @return this
     */
    public function setUser($user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Fabstei\ShorturlBundle\Model\UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}
