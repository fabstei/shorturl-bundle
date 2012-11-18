<?php

namespace Fabstei\ShorturlBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Fabstei\ShorturlBundle\DependencyInjection\FabsteiShorturlExtension;
use Symfony\Component\Yaml\Parser;

class FabsteiShorturlExtensionTest extends \PHPUnit_Framework_TestCase
{
    protected $configuration;

    public function testCreateConfiguration()
    {
        $this->configuration = new ContainerBuilder();
        $loader = new FabsteiShorturlExtension();
        $config = $this->getConfig();
        $loader->load(array($config), $this->configuration);
        $this->assertTrue($this->configuration instanceof ContainerBuilder);
    }

    /**
     * getConfig
     *
     * @return array
     */
    protected function getConfig()
    {
        $yaml = <<<EOF
url_class: Acme\TestBundle\Entity\User
EOF;
        $parser = new Parser();

        return $parser->parse($yaml);
    }

    protected function tearDown()
    {
        unset($this->configuration);
    }
}
