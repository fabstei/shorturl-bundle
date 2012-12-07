<?php

namespace Fabstei\ShorturlBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Fabstei\ShorturlBundle\Model\UrlInterface;
use Fabstei\ShorturlBundle\Model\UrlManager as BaseUrlManager;

class UrlManager extends BaseUrlManager
{
    protected $objectManager;
    protected $class;
    protected $repository;

    /**
     * Constructor.
     *
     * @param ObjectManager           $om
     * @param string                  $class
     */
    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);

        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }
    
    /**
     * Returns the shorturl as string
     *
     * @return string
     */
    public function addUrl($longurl = null, $andFlush = true)
    {
        $url = $this->createUrl($longurl);
        
        $this->objectManager->persist($url);
        
        if ($andFlush) {
            $this->objectManager->flush();
        }
        
        return $url->getToken();
    }
    
    /**
     * Removes a stored redirection
     * 
     * @return true on success or false if the Url could not be found
     */
    public function removeUrl($token)
    {
        $url = $this->findUrlByToken($token);
        
        if(isset($url)) {
            $this->deleteUrl($url);
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function deleteUrl(UrlInterface $url)
    {
        $this->objectManager->remove($url);
        $this->objectManager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function findUrlBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function findUrls()
    {
        return $this->repository->findAll();
    }

    
    /**
     * Updates an Url entity.
     *
     * @param UrlInterface  $url
     * @param Boolean       $andFlush Whether to flush the changes (default true)
     */
    public function updateUrl(UrlInterface $url, $andFlush = true)
    {
        $this->objectManager->persist($url);
        
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }
    
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }    
}
