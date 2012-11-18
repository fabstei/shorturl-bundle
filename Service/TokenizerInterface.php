<?php

namespace Fabstei\ShorturlBundle\Service;

/**
 * Token Generation
 *
 * This class performs a base-conversion to calculate a token from a given number.
 * See http://snook.ca/archives/php/url-shortener
 *
 * ISSUES: Prefix a (0) returns incorrect conversion! a = 0, b = 1, ab = 1, aab = 1, aaaaab = 1, ...
 */

interface TokenizerInterface
{
    /**
     * Return the used codeset.
     * @return string
     */
    public function getCodeset();

    /**
     * Convert an int to a token.
     * @param $n integer to be encoded
     * @return string
     */
    public function encode($n);

    /**
     * Convert a token back to an id.
     * @param $code   token to be decoded
     * @return integer
     */
    public function decode($code);
}
