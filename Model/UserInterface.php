<?php

namespace Fabstei\ShorturlBundle\Model;

interface UserInterface
{
    /**
     * Reference to the Url entity
     *
     * @return integer
     */
    protected $urls;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Add urls
     *
     * @param  Fabstei\ShorturlBundle\Entity\Url $urls
     * @return User
     */
    public function addUrl(\Fabstei\ShorturlBundle\Entity\Url $urls);

    /**
     * Get urls
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getUrls();

}
