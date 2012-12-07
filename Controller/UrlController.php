<?php

namespace Fabstei\ShorturlBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\FormFactoryInterface;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Acl\Model\AclProviderInterface;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

use Doctrine\ORM\EntityManager;

use Fabstei\ShorturlBundle\Model\UrlInterface;
use Fabstei\ShorturlBundle\Model\UrlManagerInterface;
use Fabstei\ShorturlBundle\Form\UrlType;

/**
 * Url controller.
 *
 */
class UrlController
{
    protected $request;
    protected $session;
    protected $router;
    protected $em;
    protected $manager;
    protected $template;
    protected $form;
    protected $translator;
    protected $security;
    protected $aclprovider;
    protected $adminRole;

    public function __construct(Request                   $request,
                                SessionInterface          $session,
                                RouterInterface           $router,
                                EntityManager             $entityManager,
                                UrlManagerInterface       $urlManager,
                                EngineInterface           $templateEngine,
                                FormFactoryInterface      $formFactory,
                                TranslatorInterface       $translator,
                                SecurityContextInterface  $securityContext,
                                AclProviderInterface      $aclprovider,
                                                          $adminRole
                                )
    {
        $this->request     = $request;
        $this->session     = $session;
        $this->router      = $router;
        $this->manager     = $urlManager;
        $this->em          = $entityManager;
        $this->template    = $templateEngine;
        $this->form        = $formFactory;
        $this->translator  = $translator;
        $this->security    = $securityContext;
        $this->aclprovider = $aclprovider;
        $this->adminRole   = $adminRole;
    }

    /**
     * Displays a form to create a new Url entity.
     *
     */
    public function newAction()
    {
        $entity = $this->manager->createUrl();
        $form   = $this->form->create(new UrlType(), $entity);

        return $this->template->renderResponse('FabsteiShorturlBundle:Url:new.html.twig',
                    array(
                        'entity' => $entity,
                        'form'   => $form->createView()
                    )
               );
    }

    /**
     * Finds and displays an Url entity.
     *
     */
    public function showAction($id)
    {
        $entity = $this->manager->findUrlById($id);

        if (!$entity) {
            throw new NotFoundHttpException($this->translator->trans('fabstei_shorturl.entity_404'));
        }

        if (!$this->security->isGranted('EDIT', $entity)) {
            $this->session->getFlashBag()->add('error', $this->translator->trans('fabstei_shorturl.display.permission'));

            return new RedirectResponse($this->router->generate('fabstei_shorturl_url'));
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->template->renderResponse('FabsteiShorturlBundle:Url:show.html.twig',
                    array(
                        'entity'      => $entity,
                        'delete_form' => $deleteForm->createView()
                    )
               );
    }

    /**
     * Creates a new Url entity.
     *
     */
    public function createAction()
    {
        $entity  = $this->manager->createUrl();
        $form    = $this->form->create(new UrlType(), $entity);
        $form->bindRequest($this->request);

        if ($form->isValid()) {

            $user = $this->security->getToken()->getUser();

            $entity->setUser($user);

            $this->manager->updateUrl($entity);

            // creating the ACL
            $aclProvider = $this->aclprovider;
            $objectIdentity = ObjectIdentity::fromDomainObject($entity);
            $acl = $aclProvider->createAcl($objectIdentity);

            // retrieving the security identity of the currently logged-in user
            $userSecurityIdentity = UserSecurityIdentity::fromAccount($user);
            $adminSecurityIdentity = new RoleSecurityIdentity($this->adminRole);

            // grant owner access
            $acl->insertObjectAce($userSecurityIdentity, MaskBuilder::MASK_EDIT);
            $acl->insertObjectAce($adminSecurityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            $this->session->getFlashBag()->add('success', $this->translator->trans('fabstei_shorturl.redirection.added'));

            return new RedirectResponse($this->router->generate('fabstei_shorturl_url_show', array('id' => $entity->getId())));
        }

            return $this->template->renderResponse('FabsteiShorturlBundle:Url:new.html.twig',
                    array(
                        'entity' => $entity,
                        'form'   => $form->createView()
                    )
               );
    }

    /**
     * Displays a form to edit an existing Url entity.
     *
     */
    public function editAction($id)
    {
        $entity = $this->manager->findUrlById($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find Url entity.');
        }

        if (!$this->security->isGranted('EDIT', $entity)) {
            $this->session->getFlashBag()->add('error', $this->translator->trans('fabstei_shorturl.edit.permission'));

            return new RedirectResponse($this->router->generate('fabstei_shorturl_url'));
        }

        $editForm = $this->form->create(new UrlType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->template->renderResponse('FabsteiShorturlBundle:Url:edit.html.twig',
                    array(
                        'entity'      => $entity,
                        'edit_form'   => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
                    )
               );
    }

    /**
     * Edits an existing Url entity.
     *
     */
    public function updateAction($id)
    {
        $entity = $this->manager->findUrlById($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find Url entity.');
        }

        if (!$this->security->isGranted('EDIT', $entity)) {
            $this->session->getFlashBag()->add('error', $this->translator->trans('fabstei_shorturl.edit.permission'));

            return new RedirectResponse($this->router->generate('fabstei_shorturl_url'));
        }

        $editForm   = $this->form->create(new UrlType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $editForm->bindRequest($this->request);

        if ($editForm->isValid()) {
            $this->manager->updateUrl($entity);

            $this->session->getFlashBag()->add('success', $this->translator->trans('fabstei_shorturl.redirection.updated'));

            return new RedirectResponse($this->router->generate('fabstei_shorturl_url_edit', array('id' => $id)));
        }

        return $this->template->renderResponse('FabsteiShorturlBundle:Url:edit.html.twig',
                    array(
                        'entity'      => $entity,
                        'edit_form'   => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
                    )
               );
    }

    /**
     * Deletes a Url entity.
     *
     */
    public function deleteAction($id)
    {
        $entity = $this->manager->findUrlById($id);

        if (!$entity) {
            throw new NotFoundHttpException($this->translator->trans('fabstei_shorturl.entity_404'));
        }

        if (!$this->security->isGranted('DELETE', $entity)) {
            $this->session->getFlashBag()->add('error', $this->translator->trans('fabstei_shorturl.delete.permission'));

            return new RedirectResponse($this->router->generate('fabstei_shorturl_url'));
        }

        $this->manager->deleteUrl($entity);

        $this->session->getFlashBag()->add('success', $this->translator->trans('fabstei_shorturl.redirection.deleted', array('%id%' => $id)));

        return new RedirectResponse($this->router->generate('fabstei_shorturl_url'));
    }

    private function createDeleteForm($id)
    {
        return $this->form->createBuilder('form', array('id' => $id))
                ->add('id', 'hidden')
                ->getForm();
    }

    /**
     * Lists all Url entities.
     *
     */
    public function indexAction()
    {
        $entities = $this->manager->findUrls();
        $view = array('entities' => $entities);

        return $this->template->renderResponse('FabsteiShorturlBundle:Url:index.html.twig',
                    $view
               );
    }

}
