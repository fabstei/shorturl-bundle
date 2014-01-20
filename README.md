# Provides short urls for your Symfony2 Project.

*By Fabian Steiner*

> Note: This bundle is under development. Things will change and might break. [Feedback](https://github.com/fabstei/shorturl-bundle/issues) is very welcome!

## About
This Bundle allows you to

- Generate short urls
- Manage redirections from short to long urls

The bundle is based on the shorturl class by [Jonathan Snook](http://snook.ca/archives/php/url-shortener).


## Installation

Using Composer, add to ``composer.json``:

    {
        "require": {
            "fabstei/shorturl-bundle": "0.1.0"
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

Update your doctrine database schema (`doctrine:schema:update --force`)

Import the routes from your routing.yml:

    # Redirection from short to long urls
    redirect:
        resource: "@FabsteiShorturlBundle/Resources/config/routing/redirect.yml"
        #hostname_pattern: example.com

    # Shorturl management
    shorturl:
        resource: "@FabsteiShorturlBundle/Resources/config/routing/url.yml"

The optional [hostname pattern](http://symfony.com/doc/master/components/routing/hostname_pattern.html) (new in Symfony 2.2) allows you to use a seperate domain for your short urls.


## Configuration

The bundle provides sensible default values but one might want to customize the codeset used to generate unique tokens (used as short urls).

    fabstei_shorturl:
        codeset: abcABC123-_! # Default: abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789

## Usage

The bundle comes with two services:
* [fabstei_shorturl.tokenizer](https://github.com/fabstei/shorturl-bundle/blob/master/Service/TokenizerInterface.php) to generate tokens to use as short urls (such as example.com/a3x)
* [fabstei_shorturl.manager](https://github.com/fabstei/shorturl-bundle/blob/master/Model/UrlManagerInterface.php)   to manage redirections (store long urls and their associated token)

It also provides a controller to handle redirections as well as a controller, views and forms to manage the redirections (by default accessible from /url-manager).
Custom shorturls can be used to replace the default tokens (calculated from the redirection id).
Furthermore, you may use `_locale` anywhere in the long urls you store, which is replaced by the current requests locale on redirection.

Both services are also accessible via cli commands:

    php app/console fabstei:shorturl:add    # Add a long url, returns the short token
    php app/console fabstei:shorturl:get    # Retrieve a long url associated with a token
    php app/console fabstei:shorturl:update # Update the long url associated with a token
    php app/console fabstei:shorturl:remove # Remove a redirection
    php app/console fabstei:shorturl:list   # Get a list of all stored redirections

    php app/console fabstei:token:codeset   # Get the codeset used to generate tokens
    php app/console fabstei:token:encode    # Calculate a token from an integer
    php app/console fabstei:token:decode    # Calculate the integer from a given token

## Tests

The bundles ships with few unit tests and a ``phpunit.xml.dist`` file.

[![Build Status](https://secure.travis-ci.org/fabstei/shorturl-bundle.png)](http://travis-ci.org/fabstei/shorturl-bundle)

## TODO

- Add proper tests
- Refactor to gain more flexibility (Decouple dependencies, f.e. the User class)
- Improve general code quality

## Dependencies
- [doctrine/orm](https://packagist.org/packages/doctrine/orm)
- [symfony/framework-bundle](https://packagist.org/packages/symfony/framework-bundle)

## Credits
- [Jonathan Snook](http://snook.ca/archives/php/url-shortener) for the base class.
- [Tim Nagel](https://github.com/merk) for help on IRC and code samples.
- [FriendsOfSymfony](https://github.com/FriendsOfSymfony/) for the best code to learn from; [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle) for the object manager.

