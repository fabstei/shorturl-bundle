<?php

namespace Fabstei\ShorturlBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

use Doctrine\ORM\EntityManager;

use Fabstei\ShorturlBundle\Model\UrlInterface;
use Fabstei\ShorturlBundle\Model\UrlManagerInterface;

class RedirectController
{
    protected $request;
    protected $router;
    protected $em;
    protected $translator;
    protected $manager;

    public function __construct(Request             $request,
                                RouterInterface     $router,
                                EntityManager       $entityManager,
                                TranslatorInterface $translator,
                                UrlManagerInterface $urlManager
                                )
    {
        $this->request     = $request;
        $this->router      = $router;
        $this->em          = $entityManager;
        $this->translator  = $translator;
        $this->manager     = $urlManager;
    }

    public function redirectAction($token)
    {
        $entity = $this->manager->findUrlByToken($token);

        if ($entity) {
           if (!$entity->getUrl()) {
                throw new NotFoundHttpException($this->translator->trans('fabstei_shorturl.redirect.404-url_token_id', array('%token%' => $token)));
           } else {

                $url = $entity->getUrl();

                if (strstr($url, '_locale')) {
                    $url = str_replace('_locale', $this->request->getLocale(), $url);
                }

                return new RedirectResponse($url, 301);
            }
        } else {
            throw new NotFoundHttpException($this->translator->trans('fabstei_shorturl.redirect.404-url_token_id', array('%token%' => $token)));
        }
    }
}
