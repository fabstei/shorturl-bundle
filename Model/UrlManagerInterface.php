<?php

namespace Fabstei\ShorturlBundle\Model;

interface UrlManagerInterface
{
    /**
     * Creates an empty Url.
     *
     * @return UrlInterface
     */
    public function createUrl();
    
    /**
     * Updates an Url entity.
     *
     * @param string        $token
     * @param string        $longurl
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     *
     * @return true on success or false if the Url could not be found
     */
    public function updateLongUrl($token, $longurl, $andFlush = true);

    /**
     * Updates the token of an Url entity.
     *
     * @param string        $token
     * @param string        $newToken
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     * 
     * @return true on success or false if the Url could not be found or the token exists already
     */
    public function updateToken($token, $newToken, $andFlush = true);

    /**
     * Saves changes made to an Url.
     *
     * @param UrlInterface $url
     *
     * @return void
     */
    public function updateUrl(UrlInterface $url);

    /**
     * Deletes an Url.
     *
     * @param UrlInterface $url
     *
     * @return void
     */
    public function deleteUrl(UrlInterface $url);

    /**
     * Finds one Url by the given criteria.
     *
     * @param array $criteria
     *
     * @return UrlInterface
     */
    public function findUrlBy(array $criteria);

    /**
     * Find an Url by its id.
     *
     * @param string $id
     *
     * @return UrlInterface or null if Url does not exist
     */
    public function findUrlById($id);

    /**
     * Find an Url by its token.
     *
     * @param string $token
     *
     * @return UrlInterface or null if Url does not exist
     */
    public function findUrlByToken($token);


    /**
     * Find an Url by its stored long Url.
     *
     * @param string $longurl
     *
     * @return UrlInterface or null if Url does not exist
     */
    public function findUrlByLongurl($longurl);


    /**
     * Returns a collection with all Url instances.
     *
     * @return \Traversable
     */
    public function findUrls();

    /**
     * Returns the Url's fully qualified class name.
     *
     * @return string
     */
    public function getClass();
}
