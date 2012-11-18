<?php

namespace Fabstei\ShorturlBundle\Tests\Service;

use Fabstei\ShorturlBundle\Service\Token;

class UrlControllerFunctionalTest extends \PHPUnit_Framework_TestCase

{
    private $codeset;
    private $tokenizer;

    public function setUp()
    {
        $this->codeset = 'abc';
        $this->tokenizer = new Token($this->codeset);
    }

    public function testCodesetAttribute()
    {
        $classname = get_class($this->tokenizer);
        $this->assertClassHasAttribute('codeset', $classname, 'There\'s no "codeset" attribute in "'.$classname.'".');
    }

    public function testGetCodeset()
    {
        $result = $this->tokenizer->getCodeset();

        $this->assertInternalType('string', $result);
        $this->assertEquals($this->codeset, $result);
    }

    public function testEncode()
    {
        $result = $this->tokenizer->encode(5);

        $this->assertInternalType('string', $result);
        $this->assertEquals('bc', $result);
    }

   public function testDecode()
    {
        $result = $this->tokenizer->decode('bc');

        $this->assertInternalType('string', $result); //should be integer, but at the moment decode returns strings
        $this->assertEquals('5', $result);
    }
}
