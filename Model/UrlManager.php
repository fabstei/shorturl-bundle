<?php

namespace Fabstei\ShorturlBundle\Model;

abstract class UrlManager implements UrlManagerInterface
{

    /**
     * Returns an empty Url instance
     *
     * @return UrlInterface
     */
    public function createUrl($longurl = null)
    {
        $class = $this->getClass();
        $url = new $class;
        
        if(isset($longurl)) {
            $url->setUrl($longurl);
        }
        
        return $url;
    }
    
    /**
     * {@inheritDoc}
     */
    public function updateLongurl($token, $longurl, $andFlush = true)
    {
        $url = $this->findUrlByToken($token);
        
        if(isset($url)) {
            
            $url->setUrl($longurl);
            
            $this->updateUrl($url, $andFlush);
            
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function updateToken($token, $newToken, $andFlush = true)
    {
        $url = $this->findUrlByToken($token);
        
        if(isset($url)) {
            
            $url->setToken($newToken);
            
            $this->updateUrl($url, $andFlush);
            
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findUrlById($id)
    {
        return $this->findUrlBy(array('id' => $id));
    }

    /**
     * {@inheritDoc}
     */
    public function findUrlByToken($token)
    {
        return $this->findUrlBy(array('token' => $token));
    }

    /**
     * {@inheritDoc}
     */
    public function findUrlByLongurl($longurl)
    {
        return $this->findUrlBy(array('url' => $longurl));
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === $this->getClass();
    }
}
