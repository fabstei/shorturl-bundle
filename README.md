# Provides short urls for your Symfony2 Project.

*By Fabian Steiner*

> Note: This bundle is under development. Things will change and might break.

## About
This Bundle allows you to

- Generate short urls
- Manage redirections from short to long urls

The bundle is based on the shorturl class by [Jonathan Snook](http://snook.ca/archives/php/url-shortener).


## Installation

Using Composer, add to ``composer.json``:

    {
        "require": {
            "fabstei/shorturl-bundle": "dev-master"
        }
    }

Then install/update your vendors:

    php composer.phar update

Add the bundle to your AppKernel.php:

    new Fabstei\ShorturlBundle\FabsteiShorturlBundle(),


Create a User class implementing the Userinterface and configure it in your config.yml:

    doctrine:
        orm:
            resolve_target_entities:
                Fabstei\ShorturlBundle\Model\UserInterface: Acme\Bundle\TestBundle\Entity\User #Your custom class

## Tests

The bundles ships with few unit tests and a ``phpunit.xml.dist`` file.

[![Build Status](https://secure.travis-ci.org/fabstei/shorturl-bundle.png)](http://travis-ci.org/fabstei/shorturl-bundle)

## TODO

- Add proper tests
- Add usage documentation
- Refactor to gain more flexibility (Decouple dependencies, f.e. the User class)
- Improve general code quality

## Dependencies
- [doctrine/orm](https://packagist.org/packages/doctrine/orm)
- [symfony/framework-bundle](https://packagist.org/packages/symfony/framework-bundle)
- [gedmo/doctrine-extensions](https://packagist.org/packages/gedmo/doctrine-extensions)

## Credits
- [Jonathan Snook](http://snook.ca/archives/php/url-shortener) for the base class.
- [Tim Nagel](https://github.com/merk) for help on IRC and code samples.
- [FriendsOfSymfony](https://github.com/FriendsOfSymfony/) for the best code to learn from; [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle) for the object manager.

