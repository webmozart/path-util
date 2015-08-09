<?php

/*
 * This file is part of the webmozart/path-util package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webmozart\PathUtil\Tests;

use Webmozart\PathUtil\Url;

/**
 * @since  2.2
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 * @author Claudio Zizza <claudio@budgegeria.de>
 */
class UrlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideMakeRelativeTests
     */
    public function testMakeRelative($absoluteUrl, $baseUrl, $relativePath)
    {
        $relative = Url::makeRelative($absoluteUrl, $baseUrl);
        $this->assertSame($relativePath, $relative);
    }

    /**
     * @dataProvider provideMakeRelativeTests
     */
    public function testMakeRelativeWithUrl($absoluteUrl, $baseUrl, $relativePath)
    {
        $relative = Url::makeRelative($this->createUrl($absoluteUrl), $this->createUrl($baseUrl));
        $this->assertSame($relativePath, $relative);
    }

    /**
     * @dataProvider provideMakeRelativeTests
     */
    public function testMakeRelativeWithFullUrl($absoluteUrl, $baseUrl, $relativePath)
    {
        $url = 'ftp://user:password@example.com:8080';

        $relative = Url::makeRelative($this->createUrl($absoluteUrl, $url), $this->createUrl($baseUrl, $url));
        $this->assertSame($relativePath, $relative);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The path must be a string. Got: array
     */
    public function testMakeRelativeFailsIfInvalidPath()
    {
        Url::makeRelative(array(), 'http://example.com/webmozart/puli');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The base path must be a string. Got: array
     */
    public function testMakeRelativeFailsIfInvalidBasePath()
    {
        Url::makeRelative('http://example.com/webmozart/puli/css/style.css', array());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The absolute path "/webmozart/puli/css/style.css" cannot be made relative to the relative path "webmozart/puli". You should provide an absolute base path instead.
     */
    public function testMakeRelativeFailsIfAbsolutePathAndBasePathNotAbsolute()
    {
        Url::makeRelative('http://example.com/webmozart/puli/css/style.css', 'webmozart/puli');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The absolute path "/webmozart/puli/css/style.css" cannot be made relative to the relative path "". You should provide an absolute base path instead.
     */
    public function testMakeRelativeFailsIfAbsolutePathAndBasePathEmpty()
    {
        Url::makeRelative('http://example.com/webmozart/puli/css/style.css', '');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The base path must be a string. Got: NULL
     */
    public function testMakeRelativeFailsIfBasePathNull()
    {
        Url::makeRelative('http://example.com/webmozart/puli/css/style.css', null);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Domain "http://example.com" doesn't equal to base "http://example2.com".
     */
    public function testMakeRelativeFailsIfDifferentDomains()
    {
        Url::makeRelative('http://example.com/webmozart/puli/css/style.css', 'http://example2.com/webmozart/puli');
    }

    public function provideMakeRelativeTests()
    {
        return array(

            array('/webmozart/puli/css/style.css', '/webmozart/puli', 'css/style.css'),
            array('/webmozart/css/style.css', '/webmozart/puli', '../css/style.css'),
            array('/css/style.css', '/webmozart/puli', '../../css/style.css'),

            // relative to root
            array('/css/style.css', '/', 'css/style.css'),

            // same sub directories in different base directories
            array('/puli/css/style.css', '/webmozart/css', '../../puli/css/style.css'),

            array('/webmozart/puli/./css/style.css', '/webmozart/puli', 'css/style.css'),
            array('/webmozart/puli/../css/style.css', '/webmozart/puli', '../css/style.css'),
            array('/webmozart/puli/.././css/style.css', '/webmozart/puli', '../css/style.css'),
            array('/webmozart/puli/./../css/style.css', '/webmozart/puli', '../css/style.css'),
            array('/webmozart/puli/../../css/style.css', '/webmozart/puli', '../../css/style.css'),
            array('/webmozart/puli/css/style.css', '/webmozart/./puli', 'css/style.css'),
            array('/webmozart/puli/css/style.css', '/webmozart/../puli', '../webmozart/puli/css/style.css'),
            array('/webmozart/puli/css/style.css', '/webmozart/./../puli', '../webmozart/puli/css/style.css'),
            array('/webmozart/puli/css/style.css', '/webmozart/.././puli', '../webmozart/puli/css/style.css'),
            array('/webmozart/puli/css/style.css', '/webmozart/../../puli', '../webmozart/puli/css/style.css'),

            // first argument shorter than second
            array('/css', '/webmozart/puli', '../../css'),

            // second argument shorter than first
            array('/webmozart/puli', '/css', '../webmozart/puli'),

            // already relative
            array('css/style.css', '/webmozart/puli', 'css/style.css'),

            // both relative
            array('css/style.css', 'webmozart/puli', '../../css/style.css'),

            // relative to empty
            array('css/style.css', '', 'css/style.css'),
        );
    }

    /**
     * Based of the given path this function creates a absolute or relative URL
     *
     * @param string $path
     *
     * @return string
     */
    private function createUrl($path, $domain = 'http://example.com')
    {
        if (0 < strlen($path) && '/' === $path[0]) {
            $path = $domain.$path;
        }

        return $path;
    }
}
