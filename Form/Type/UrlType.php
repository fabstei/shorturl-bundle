<?php

namespace Fabstei\ShorturlBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UrlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('token')
            ->add('url')
        ;
    }

    public function getName()
    {
        return 'fabstei_bundle_shorturlbundle_urltype';
    }
}
