<?php

namespace Fabstei\ShorturlBundle\Model;

interface UrlInterface
{
    /**
     * To string
     *
     * @return string
     */
    public function __tostring();

    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set token
     *
     * @param  string $token
     * @return this
     */
    public function setToken($token);

    /**
     * Get token
     *
     * @return string
     */
    public function getToken();

    /**
     * Set url
     *
     * @param  string $url
     * @return this
     */
    public function setUrl($url);

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl();
}
