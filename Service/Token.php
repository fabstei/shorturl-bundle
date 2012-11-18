<?php

namespace Fabstei\ShorturlBundle\Service;

/**
 * Token Generation
 *
 * This class performs a base-conversion to calculate a token from a given number.
 * (c) Jonathan Snook (http://snook.ca/archives/php/url-shortener)
 *
 * ISSUES: Prefix a (0) returns incorrect conversion! a = 0, b = 1, ab = 1, aab = 1, aaaaab = 1, ...
 */

use Fabstei\ShorturlBundle\Service\TokenizerInterface;

class Token implements TokenizerInterface
{

    private $codeset;

    public function __construct($codeset)
    {
        $this->codeset = $codeset;
    }

    /**
    * {@inheritdoc}
    */
    public function getCodeset()
    {
        return $this->codeset;
    }

    /**
    * {@inheritdoc}
    */
    public function encode($n)
    {
        /* Vars passed from the url are never INT; fix?
        if (!is_int($n)) {
            throw new \Exception('Only integers can be encoded.');
        } */

        //Hack to return the correct Value also for input 0
        if ($n == 0) {
            return $converted = substr($this->codeset, 0, 1);
        }

        $base = strlen($this->codeset);
        $converted = '';

        while ($n > 0) {
            $converted = substr($this->codeset, bcmod($n,$base), 1) . $converted;
            $n = self::bcFloor(bcdiv($n, $base));
        }

        return $converted ;
    }

    /**
    * {@inheritdoc}
    */
    public function decode($code)
    {
        $base = strlen($this->codeset);
        $c = '0';
        for ($i = strlen($code); $i; $i--) {
            $c = bcadd($c,bcmul(strpos($this->codeset, substr($code, (-1 * ( $i - strlen($code) )),1))
                    ,bcpow($base,$i-1)));
        }

        return bcmul($c, 1, 0);
    }

    /**
     * Implementing floor
     * @param $x   Integer
     * See http://snook.ca/archives/php/url-shortener#c63597 for Travell Perkins fix
     */
    private function bcFloor($x)
    {
        return bcmul($x, '1', 0);
    }

    /**
     * Implementing Ceil
     * @param $x   Integer
     * See http://snook.ca/archives/php/url-shortener#c63597 for Travell Perkins fix
     */
    private function bcCeil($x)
    {
        $floor = bcFloor($x);

        return bcadd($floor, ceil(bcsub($x, $floor)));
    }

    /**
     * Implementing Round
     * @param $x   Integer
     * See http://snook.ca/archives/php/url-shortener#c63597 for Travell Perkins fix
     */
    private function bcRound($x)
    {
        $floor = bcFloor($x);

        return bcadd($floor, round(bcsub($x, $floor)));
    }
}
