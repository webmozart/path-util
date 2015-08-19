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
 * @since  2.3
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 * @author Claudio Zizza <claudio@budgegeria.de>
 */
class UrlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provideMakeRelativeTests
     * @covers Webmozart\PathUtil\Url
     */
    public function testMakeRelative($absolutePath, $basePath, $relativePath)
    {
        $relative = Url::makeRelative($absolutePath, $basePath);
        $this->assertSame($relativePath, $relative);
    }

    /**
     * @dataProvider provideMakeRelativeTests
     * @covers Webmozart\PathUtil\Url
     */
    public function testMakeRelativeWithUrl($absolutePath, $basePath, $relativePath)
    {
        $relative = Url::makeRelative($this->createUrl($absolutePath), $this->createUrl($basePath));
        $this->assertSame($relativePath, $relative);
    }

    /**
     * @dataProvider provideMakeRelativeTests
     * @covers Webmozart\PathUtil\Url
     */
    public function testMakeRelativeWithFullUrl($absolutePath, $basePath, $relativePath)
    {
        $url = 'ftp://user:password@example.com:8080';

        $relative = Url::makeRelative($this->createUrl($absolutePath, $url), $this->createUrl($basePath, $url));
        $this->assertSame($relativePath, $relative);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The path must be a string. Got: array
     * @covers Webmozart\PathUtil\Url
     */
    public function testMakeRelativeFailsIfInvalidUrl()
    {
        Url::makeRelative(array(), 'http://example.com/webmozart/puli');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The base path must be a string. Got: array
     * @covers Webmozart\PathUtil\Url
     */
    public function testMakeRelativeFailsIfInvalidBaseUrl()
    {
        Url::makeRelative('http://example.com/webmozart/puli/css/style.css', array());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The absolute path "/webmozart/puli/css/style.css" cannot be made relative to the relative path "webmozart/puli". You should provide an absolute base path instead.
     * @covers Webmozart\PathUtil\Url
     */
    public function testMakeRelativeFailsIfBaseUrlNoUrl()
    {
        Url::makeRelative('http://example.com/webmozart/puli/css/style.css', 'webmozart/puli');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The absolute path "/webmozart/puli/css/style.css" cannot be made relative to the relative path "". You should provide an absolute base path instead.
     * @covers Webmozart\PathUtil\Url
     */
    public function testMakeRelativeFailsIfBaseUrlEmpty()
    {
        Url::makeRelative('http://example.com/webmozart/puli/css/style.css', '');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The base path must be a string. Got: NULL
     * @covers Webmozart\PathUtil\Url
     */
    public function testMakeRelativeFailsIfBaseUrlNull()
    {
        Url::makeRelative('http://example.com/webmozart/puli/css/style.css', null);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Domain "http://example.com" doesn't equal to base "http://example2.com".
     * @covers Webmozart\PathUtil\Url
     */
    public function testMakeRelativeFailsIfDifferentDomains()
    {
        Url::makeRelative('http://example.com/webmozart/puli/css/style.css', 'http://example2.com/webmozart/puli');
    }

    public function provideMakeRelativeTests()
    {
        return array(

            array('/webmozart/puli/css/style.css', '/webmozart/puli', 'css/style.css'),
            array('/webmozart/puli/css/style.css?key=value&key2=value', '/webmozart/puli', 'css/style.css?key=value&key2=value'),
            array('/webmozart/puli/css/style.css?key[]=value&key[]=value', '/webmozart/puli', 'css/style.css?key[]=value&key[]=value'),
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
     * Based of the given path this function creates a absolute or relative URL.
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
