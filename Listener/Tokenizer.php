<?php

namespace Fabstei\ShorturlBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Fabstei\ShorturlBundle\Entity\Url;
use Fabstei\ShorturlBundle\Service\Token;

class Tokenizer
{
    /**
     * @var Router $tokenizer
     */
    private $tokenizer;

    /**
     * Constructs a new instance of Tokenizer.
     *
     * @param Tokenizer $tokenizer The tokenizer
     */
    public function __construct(Token $token)
    {
        $this->tokenizer = $token;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        self::addToken($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        self::addToken($args);
    }

    public function addToken(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        if ($entity instanceof Url) {

            if (!$entity->getToken()) {
                 $entity->setToken($this->tokenizer->encode($entity->getId()));
            }

            $em->persist($entity);
            $em->flush();
        }
    }
}
