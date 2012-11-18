Provides a complete Shorturl Service for your Symfony2 Project.

.. image:: https://api.travis-ci.org/fabstei/shorturl-bundle.png

Currently, this bundle allows you to:

- Generate short urls
- Manage redirections from short to long urls

Installation
-------------

Install using composer

        "fabstei/shorturl-bundle": "dev-master"

Add in your AppKernel.php:

            new Fabstei\ShorturlBundle\FabsteiShorturlBundle(),

Create a User class implementing the Userinterface and configure it in your config.yml:

doctrine:
    orm:
        resolve_target_entities:
            Fabstei\ShorturlBundle\Model\UserInterface: Acme\Bundle\TestBundle\Entity\User #Your custom class




TODO
----

- Add proper documentation
- Add additional Tests and improve existing
- Refactor to gain more flexibility (Decouple dependencies, f.e. the User class)
- Improve general code quality


Dependencies
-------------
- `doctrine/orm <https://packagist.org/packages/doctrine/orm>`_
- `symfony/framework-bundle <https://packagist.org/packages/symfony/framework-bundle>`_
- `gedmo/doctrine-extensions <https://packagist.org/packages/gedmo/doctrine-extensions>`_


