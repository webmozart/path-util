<?php

/*
 * This file is part of the Puli package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webmozart\PathUtil\Tests;

use Webmozart\PathUtil\Path;

/**
 * @since  1.0
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class PathTest extends \PHPUnit_Framework_TestCase
{
    public function provideCanonicalizationTests()
    {
        return array(
            // relative paths (forward slash)
            array('css/./style.css', 'css/style.css'),
            array('css/../style.css', 'style.css'),
            array('css/./../style.css', 'style.css'),
            array('css/.././style.css', 'style.css'),
            array('css/../../style.css', '../style.css'),
            array('./css/style.css', 'css/style.css'),
            array('../css/style.css', '../css/style.css'),
            array('./../css/style.css', '../css/style.css'),
            array('.././css/style.css', '../css/style.css'),
            array('../../css/style.css', '../../css/style.css'),
            array('', ''),
            array(null, ''),
            array('.', ''),
            array('..', '..'),
            array('./..', '..'),
            array('../.', '..'),
            array('../..', '../..'),

            // relative paths (backslash)
            array('css\\.\\style.css', 'css/style.css'),
            array('css\\..\\style.css', 'style.css'),
            array('css\\.\\..\\style.css', 'style.css'),
            array('css\\..\\.\\style.css', 'style.css'),
            array('css\\..\\..\\style.css', '../style.css'),
            array('.\\css\\style.css', 'css/style.css'),
            array('..\\css\\style.css', '../css/style.css'),
            array('.\\..\\css\\style.css', '../css/style.css'),
            array('..\\.\\css\\style.css', '../css/style.css'),
            array('..\\..\\css\\style.css', '../../css/style.css'),

            // absolute paths (forward slash, UNIX)
            array('/css/style.css', '/css/style.css'),
            array('/css/./style.css', '/css/style.css'),
            array('/css/../style.css', '/style.css'),
            array('/css/./../style.css', '/style.css'),
            array('/css/.././style.css', '/style.css'),
            array('/./css/style.css', '/css/style.css'),
            array('/../css/style.css', '/css/style.css'),
            array('/./../css/style.css', '/css/style.css'),
            array('/.././css/style.css', '/css/style.css'),
            array('/../../css/style.css', '/css/style.css'),

            // absolute paths (backslash, UNIX)
            array('\\css\\style.css', '/css/style.css'),
            array('\\css\\.\\style.css', '/css/style.css'),
            array('\\css\\..\\style.css', '/style.css'),
            array('\\css\\.\\..\\style.css', '/style.css'),
            array('\\css\\..\\.\\style.css', '/style.css'),
            array('\\.\\css\\style.css', '/css/style.css'),
            array('\\..\\css\\style.css', '/css/style.css'),
            array('\\.\\..\\css\\style.css', '/css/style.css'),
            array('\\..\\.\\css\\style.css', '/css/style.css'),
            array('\\..\\..\\css\\style.css', '/css/style.css'),

            // absolute paths (forward slash, Windows)
            array('C:/css/style.css', 'C:/css/style.css'),
            array('C:/css/./style.css', 'C:/css/style.css'),
            array('C:/css/../style.css', 'C:/style.css'),
            array('C:/css/./../style.css', 'C:/style.css'),
            array('C:/css/.././style.css', 'C:/style.css'),
            array('C:/./css/style.css', 'C:/css/style.css'),
            array('C:/../css/style.css', 'C:/css/style.css'),
            array('C:/./../css/style.css', 'C:/css/style.css'),
            array('C:/.././css/style.css', 'C:/css/style.css'),
            array('C:/../../css/style.css', 'C:/css/style.css'),

            // absolute paths (backslash, Windows)
            array('C:\\css\\style.css', 'C:/css/style.css'),
            array('C:\\css\\.\\style.css', 'C:/css/style.css'),
            array('C:\\css\\..\\style.css', 'C:/style.css'),
            array('C:\\css\\.\\..\\style.css', 'C:/style.css'),
            array('C:\\css\\..\\.\\style.css', 'C:/style.css'),
            array('C:\\.\\css\\style.css', 'C:/css/style.css'),
            array('C:\\..\\css\\style.css', 'C:/css/style.css'),
            array('C:\\.\\..\\css\\style.css', 'C:/css/style.css'),
            array('C:\\..\\.\\css\\style.css', 'C:/css/style.css'),
            array('C:\\..\\..\\css\\style.css', 'C:/css/style.css'),

            // Windows special case
            array('C:', 'C:/'),

            // Don't change malformed path
            array('C:css/style.css', 'C:css/style.css'),
        );
    }

    /**
     * @dataProvider provideCanonicalizationTests
     */
    public function testCanonicalize($path, $canonicalized)
    {
        $this->assertSame($canonicalized, Path::canonicalize($path));
    }

    public function provideGetDirectoryTests()
    {
        return array(
            array('/webmozart/puli/style.css', '/webmozart/puli'),
            array('/webmozart/puli', '/webmozart'),
            array('/webmozart', '/'),
            array('/', '/'),
            array('', ''),
            array(null, ''),

            array('\\webmozart\\puli\\style.css', '/webmozart/puli'),
            array('\\webmozart\\puli', '/webmozart'),
            array('\\webmozart', '/'),
            array('\\', '/'),

            array('C:/webmozart/puli/style.css', 'C:/webmozart/puli'),
            array('C:/webmozart/puli', 'C:/webmozart'),
            array('C:/webmozart', 'C:/'),
            array('C:/', 'C:/'),
            array('C:', 'C:/'),

            array('C:\\webmozart\\puli\\style.css', 'C:/webmozart/puli'),
            array('C:\\webmozart\\puli', 'C:/webmozart'),
            array('C:\\webmozart', 'C:/'),
            array('C:\\', 'C:/'),

            array('webmozart/puli/style.css', 'webmozart/puli'),
            array('webmozart/puli', 'webmozart'),
            array('webmozart', ''),

            array('webmozart\\puli\\style.css', 'webmozart/puli'),
            array('webmozart\\puli', 'webmozart'),
            array('webmozart', ''),

            array('/webmozart/./puli/style.css', '/webmozart/puli'),
            array('/webmozart/../puli/style.css', '/puli'),
            array('/webmozart/./../puli/style.css', '/puli'),
            array('/webmozart/.././puli/style.css', '/puli'),
            array('/webmozart/../../puli/style.css', '/puli'),
            array('/.', '/'),
            array('/..', '/'),

            array('C:webmozart', ''),
        );
    }

    /**
     * @dataProvider provideGetDirectoryTests
     */
    public function testGetDirectory($path, $directory)
    {
        $this->assertSame($directory, Path::getDirectory($path));
    }

    public function provideIsAbsolutePathTests()
    {
        return array(
            array('/css/style.css', true),
            array('/', true),
            array('css/style.css', false),
            array('', false),
            array(null, false),

            array('\\css\\style.css', true),
            array('\\', true),
            array('css\\style.css', false),

            array('C:/css/style.css', true),
            array('D:/', true),

            array('E:\\css\\style.css', true),
            array('F:\\', true),

            // Windows special case
            array('C:', true),

            // Not considered absolute
            array('C:css/style.css', false),
        );
    }

    /**
     * @dataProvider provideIsAbsolutePathTests
     */
    public function testIsAbsolute($path, $isAbsolute)
    {
        $this->assertSame($isAbsolute, Path::isAbsolute($path));
    }

    /**
     * @dataProvider provideIsAbsolutePathTests
     */
    public function testIsRelative($path, $isAbsolute)
    {
        $this->assertSame(!$isAbsolute, Path::isRelative($path));
    }

    public function provideGetRootTests()
    {
        return array(
            array('/css/style.css', '/'),
            array('/', '/'),
            array('css/style.css', ''),
            array('', ''),
            array(null, ''),

            array('\\css\\style.css', '/'),
            array('\\', '/'),
            array('css\\style.css', ''),

            array('C:/css/style.css', 'C:/'),
            array('C:/', 'C:/'),
            array('C:', 'C:/'),

            array('D:\\css\\style.css', 'D:/'),
            array('D:\\', 'D:/'),
        );
    }

    /**
     * @dataProvider provideGetRootTests
     */
    public function testGetRoot($path, $root)
    {
        $this->assertSame($root, Path::getRoot($path));
    }

    public function providePathTests()
    {
        return array(
            // relative to path
            array('/webmozart/puli', 'css/style.css', '/webmozart/puli/css/style.css'),
            array('/webmozart/puli', '../css/style.css', '/webmozart/css/style.css'),
            array('/webmozart/puli', '../../css/style.css', '/css/style.css'),

            // relative to root
            array('/', 'css/style.css', '/css/style.css'),
            array('C:', 'css/style.css', 'C:/css/style.css'),
            array('C:/', 'css/style.css', 'C:/css/style.css'),
        );
    }

    public function provideMakeAbsoluteTests()
    {
        return array_merge($this->providePathTests(), array(
            // relative to empty
            array('', 'css/style.css', '/css/style.css'),
            array(null, 'css/style.css', '/css/style.css'),

            array('', 'css\\style.css', '/css/style.css'),
            array(null, 'css\\style.css', '/css/style.css'),

            // collapse dots
            array('/webmozart/puli', 'css/./style.css', '/webmozart/puli/css/style.css'),
            array('/webmozart/puli', 'css/../style.css', '/webmozart/puli/style.css'),
            array('/webmozart/puli', 'css/./../style.css', '/webmozart/puli/style.css'),
            array('/webmozart/puli', 'css/.././style.css', '/webmozart/puli/style.css'),
            array('/webmozart/puli', './css/style.css', '/webmozart/puli/css/style.css'),

            array('\\webmozart\\puli', 'css\\.\\style.css', '/webmozart/puli/css/style.css'),
            array('\\webmozart\\puli', 'css\\..\\style.css', '/webmozart/puli/style.css'),
            array('\\webmozart\\puli', 'css\\.\\..\\style.css', '/webmozart/puli/style.css'),
            array('\\webmozart\\puli', 'css\\..\\.\\style.css', '/webmozart/puli/style.css'),
            array('\\webmozart\\puli', '.\\css\\style.css', '/webmozart/puli/css/style.css'),

            // collapse dots on root
            array('/', './css/style.css', '/css/style.css'),
            array('/', '../css/style.css', '/css/style.css'),
            array('/', '../css/./style.css', '/css/style.css'),
            array('/', '../css/../style.css', '/style.css'),
            array('/', '../css/./../style.css', '/style.css'),
            array('/', '../css/.././style.css', '/style.css'),

            array('\\', '.\\css\\style.css', '/css/style.css'),
            array('\\', '..\\css\\style.css', '/css/style.css'),
            array('\\', '..\\css\\.\\style.css', '/css/style.css'),
            array('\\', '..\\css\\..\\style.css', '/style.css'),
            array('\\', '..\\css\\.\\..\\style.css', '/style.css'),
            array('\\', '..\\css\\..\\.\\style.css', '/style.css'),

            array('C:/', './css/style.css', 'C:/css/style.css'),
            array('C:/', '../css/style.css', 'C:/css/style.css'),
            array('C:/', '../css/./style.css', 'C:/css/style.css'),
            array('C:/', '../css/../style.css', 'C:/style.css'),
            array('C:/', '../css/./../style.css', 'C:/style.css'),
            array('C:/', '../css/.././style.css', 'C:/style.css'),

            array('C:\\', '.\\css\\style.css', 'C:/css/style.css'),
            array('C:\\', '..\\css\\style.css', 'C:/css/style.css'),
            array('C:\\', '..\\css\\.\\style.css', 'C:/css/style.css'),
            array('C:\\', '..\\css\\..\\style.css', 'C:/style.css'),
            array('C:\\', '..\\css\\.\\..\\style.css', 'C:/style.css'),
            array('C:\\', '..\\css\\..\\.\\style.css', 'C:/style.css'),

            // collapse dots on empty
            array('', './css/style.css', '/css/style.css'),
            array('', '../css/style.css', '/css/style.css'),
            array('', '../css/./style.css', '/css/style.css'),
            array('', '../css/../style.css', '/style.css'),
            array('', '../css/./../style.css', '/style.css'),
            array('', '../css/.././style.css', '/style.css'),

            array('', '.\\css\\style.css', '/css/style.css'),
            array('', '..\\css\\style.css', '/css/style.css'),
            array('', '..\\css\\.\\style.css', '/css/style.css'),
            array('', '..\\css\\..\\style.css', '/style.css'),
            array('', '..\\css\\.\\..\\style.css', '/style.css'),
            array('', '..\\css\\..\\.\\style.css', '/style.css'),

            // absolute paths
            array('/webmozart/puli', '/css/style.css', '/css/style.css'),
            array('/webmozart/puli', '\\css\\style.css', '/css/style.css'),
            array('C:/webmozart/puli', 'C:/css/style.css', 'C:/css/style.css'),
            array('D:/webmozart/puli', 'D:\\css\\style.css', 'D:/css/style.css'),
        ));
    }

    /**
     * @dataProvider provideMakeAbsoluteTests
     */
    public function testMakeAbsolute($basePath, $relativePath, $absolutePath)
    {
        $this->assertSame($absolutePath, Path::makeAbsolute($relativePath, $basePath));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMakeAbsoluteFailsIfBasePathNotAbsolute()
    {
        Path::makeAbsolute('css/style.css', 'webmozart/puli');
    }

    public function provideAbsolutePathsWithDifferentRoots()
    {
        return array(
            array('C:/css/style.css', '/webmozart/puli'),
            array('C:/css/style.css', '\\webmozart\\puli'),
            array('C:\\css\\style.css', '/webmozart/puli'),
            array('C:\\css\\style.css', '\\webmozart\\puli'),

            array('/css/style.css', 'C:/webmozart/puli'),
            array('/css/style.css', 'C:\\webmozart\\puli'),
            array('\\css\\style.css', 'C:/webmozart/puli'),
            array('\\css\\style.css', 'C:\\webmozart\\puli'),

            array('D:/css/style.css', 'C:/webmozart/puli'),
            array('D:/css/style.css', 'C:\\webmozart\\puli'),
            array('D:\\css\\style.css', 'C:/webmozart/puli'),
            array('D:\\css\\style.css', 'C:\\webmozart\\puli'),
        );
    }

    /**
     * @dataProvider provideAbsolutePathsWithDifferentRoots
     * @expectedException \InvalidArgumentException
     */
    public function testMakeAbsoluteFailsIfDifferentRoot($basePath, $relativePath)
    {
        Path::makeAbsolute($relativePath, $basePath);
    }

    public function provideMakeRelativeTests()
    {
        $paths = array_map(function (array $arguments) {
            return array($arguments[2], $arguments[0], $arguments[1]);
        }, $this->providePathTests());

        return array_merge($paths, array(
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

            array('\\webmozart\\puli\\css\\style.css', '\\webmozart\\puli', 'css/style.css'),
            array('\\webmozart\\css\\style.css', '\\webmozart\\puli', '../css/style.css'),
            array('\\css\\style.css', '\\webmozart\\puli', '../../css/style.css'),

            array('C:/webmozart/puli/css/style.css', 'C:/webmozart/puli', 'css/style.css', ),
            array('C:/webmozart/css/style.css', 'C:/webmozart/puli', '../css/style.css'),
            array('C:/css/style.css', 'C:/webmozart/puli', '../../css/style.css'),

            array('C:\\webmozart\\puli\\css\\style.css', 'C:\\webmozart\\puli', 'css/style.css', ),
            array('C:\\webmozart\\css\\style.css', 'C:\\webmozart\\puli', '../css/style.css'),
            array('C:\\css\\style.css', 'C:\\webmozart\\puli', '../../css/style.css'),

            // already relative
            array('css/style.css', '/webmozart/puli', 'css/style.css'),
            array('css\\style.css', '\\webmozart\\puli', 'css/style.css'),

            // both relative
            array('css/style.css', 'webmozart/puli', '../../css/style.css'),
            array('css\\style.css', 'webmozart\\puli', '../../css/style.css'),

            // different slashes in path and base path
            array('/webmozart/puli/css/style.css', '\\webmozart\\puli', 'css/style.css'),
            array('\\webmozart\\puli\\css\\style.css', '/webmozart/puli', 'css/style.css'),
        ));
    }

    /**
     * @dataProvider provideMakeRelativeTests
     */
    public function testMakeRelative($absolutePath, $basePath, $relativePath)
    {
        $this->assertSame($relativePath, Path::makeRelative($absolutePath, $basePath));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMakeRelativeFailsIfBasePathNotAbsolute()
    {
        Path::makeRelative('/webmozart/puli/css/style.css', 'webmozart/puli');
    }

    /**
     * @dataProvider provideAbsolutePathsWithDifferentRoots
     * @expectedException \InvalidArgumentException
     */
    public function testMakeRelativeFailsIfDifferentRoot($absolutePath, $basePath)
    {
        Path::makeRelative($absolutePath, $basePath);
    }

    public function provideIsLocalTests()
    {
        return array(
            array('/bg.png', true),
            array('bg.png', true),
            array('http://example.com/bg.png', false),
            array('http://example.com', false),
            array(null, false),
            array('', false),
        );
    }

    /**
     * @dataProvider provideIsLocalTests
     */
    public function testIsLocal($path, $isLocal)
    {
        $this->assertSame($isLocal, Path::isLocal($path));
    }

    public function provideGetLongestCommonBasePathTests()
    {
        return array(
            // same paths
            array(array('/base/path', '/base/path'), '/base/path'),
            array(array('C:/base/path', 'C:/base/path'), 'C:/base/path'),
            array(array('C:\\base\\path', 'C:\\base\\path'), 'C:/base/path'),
            array(array('C:/base/path', 'C:\\base\\path'), 'C:/base/path'),

            // trailing slash
            array(array('/base/path/', '/base/path'), '/base/path'),
            array(array('C:/base/path/', 'C:/base/path'), 'C:/base/path'),
            array(array('C:\\base\\path\\', 'C:\\base\\path'), 'C:/base/path'),
            array(array('C:/base/path/', 'C:\\base\\path'), 'C:/base/path'),

            array(array('/base/path', '/base/path/'), '/base/path'),
            array(array('C:/base/path', 'C:/base/path/'), 'C:/base/path'),
            array(array('C:\\base\\path', 'C:\\base\\path\\'), 'C:/base/path'),
            array(array('C:/base/path', 'C:\\base\\path\\'), 'C:/base/path'),

            // first in second
            array(array('/base/path/sub', '/base/path'), '/base/path'),
            array(array('C:/base/path/sub', 'C:/base/path'), 'C:/base/path'),
            array(array('C:\\base\\path\\sub', 'C:\\base\\path'), 'C:/base/path'),
            array(array('C:/base/path/sub', 'C:\\base\\path'), 'C:/base/path'),

            // second in first
            array(array('/base/path', '/base/path/sub'), '/base/path'),
            array(array('C:/base/path', 'C:/base/path/sub'), 'C:/base/path'),
            array(array('C:\\base\\path', 'C:\\base\\path\\sub'), 'C:/base/path'),
            array(array('C:/base/path', 'C:\\base\\path\\sub'), 'C:/base/path'),

            // first is prefix
            array(array('/base/path/di', '/base/path/dir'), '/base/path'),
            array(array('C:/base/path/di', 'C:/base/path/dir'), 'C:/base/path'),
            array(array('C:\\base\\path\\di', 'C:\\base\\path\\dir'), 'C:/base/path'),
            array(array('C:/base/path/di', 'C:\\base\\path\\dir'), 'C:/base/path'),

            // second is prefix
            array(array('/base/path/dir', '/base/path/di'), '/base/path'),
            array(array('C:/base/path/dir', 'C:/base/path/di'), 'C:/base/path'),
            array(array('C:\\base\\path\\dir', 'C:\\base\\path\\di'), 'C:/base/path'),
            array(array('C:/base/path/dir', 'C:\\base\\path\\di'), 'C:/base/path'),

            // root is common base path
            array(array('/first', '/second'), '/'),
            array(array('C:/first', 'C:/second'), 'C:/'),
            array(array('C:\\first', 'C:\\second'), 'C:/'),
            array(array('C:/first', 'C:\\second'), 'C:/'),

            // windows vs unix
            array(array('/base/path', 'C:/base/path'), null),
            array(array('C:/base/path', '/base/path'), null),
            array(array('/base/path', 'C:\\base\\path'), null),

            // different partitions
            array(array('C:/base/path', 'D:/base/path'), null),
            array(array('C:/base/path', 'D:\\base\\path'), null),
            array(array('C:\\base\\path', 'D:\\base\\path'), null),

            // three paths
            array(array('/base/path/foo', '/base/path', '/base/path/bar'), '/base/path'),
            array(array('C:/base/path/foo', 'C:/base/path', 'C:/base/path/bar'), 'C:/base/path'),
            array(array('C:\\base\\path\\foo', 'C:\\base\\path', 'C:\\base\\path\\bar'), 'C:/base/path'),
            array(array('C:/base/path//foo', 'C:/base/path', 'C:\\base\\path\\bar'), 'C:/base/path'),

            // three paths with root
            array(array('/base/path/foo', '/', '/base/path/bar'), '/'),
            array(array('C:/base/path/foo', 'C:/', 'C:/base/path/bar'), 'C:/'),
            array(array('C:\\base\\path\\foo', 'C:\\', 'C:\\base\\path\\bar'), 'C:/'),
            array(array('C:/base/path//foo', 'C:/', 'C:\\base\\path\\bar'), 'C:/'),

            // three paths, different roots
            array(array('/base/path/foo', 'C:/base/path', '/base/path/bar'), null),
            array(array('/base/path/foo', 'C:\\base\\path', '/base/path/bar'), null),
            array(array('C:/base/path/foo', 'D:/base/path', 'C:/base/path/bar'), null),
            array(array('C:\\base\\path\\foo', 'D:\\base\\path', 'C:\\base\\path\\bar'), null),
            array(array('C:/base/path//foo', 'D:/base/path', 'C:\\base\\path\\bar'), null),

            // only one path
            array(array('/base/path'), '/base/path'),
            array(array('C:/base/path'), 'C:/base/path'),
            array(array('C:\\base\\path'), 'C:/base/path'),
        );
    }

    /**
     * @dataProvider provideGetLongestCommonBasePathTests
     */
    public function testGetLongestCommonBasePath(array $paths, $basePath)
    {
        $this->assertSame($basePath, Path::getLongestCommonBasePath($paths));
    }

    public function provideIsBasePathTests()
    {
        return array(
            // same paths
            array('/base/path', '/base/path', true),
            array('C:/base/path', 'C:/base/path', true),
            array('C:\\base\\path', 'C:\\base\\path', true),
            array('C:/base/path', 'C:\\base\\path', true),

            // trailing slash
            array('/base/path/', '/base/path', true),
            array('C:/base/path/', 'C:/base/path', true),
            array('C:\\base\\path\\', 'C:\\base\\path', true),
            array('C:/base/path/', 'C:\\base\\path', true),

            array('/base/path', '/base/path/', true),
            array('C:/base/path', 'C:/base/path/', true),
            array('C:\\base\\path', 'C:\\base\\path\\', true),
            array('C:/base/path', 'C:\\base\\path\\', true),

            // first in second
            array('/base/path/sub', '/base/path', false),
            array('C:/base/path/sub', 'C:/base/path', false),
            array('C:\\base\\path\\sub', 'C:\\base\\path', false),
            array('C:/base/path/sub', 'C:\\base\\path', false),

            // second in first
            array('/base/path', '/base/path/sub', true),
            array('C:/base/path', 'C:/base/path/sub', true),
            array('C:\\base\\path', 'C:\\base\\path\\sub', true),
            array('C:/base/path', 'C:\\base\\path\\sub', true),

            // first is prefix
            array('/base/path/di', '/base/path/dir', false),
            array('C:/base/path/di', 'C:/base/path/dir', false),
            array('C:\\base\\path\\di', 'C:\\base\\path\\dir', false),
            array('C:/base/path/di', 'C:\\base\\path\\dir', false),

            // second is prefix
            array('/base/path/dir', '/base/path/di', false),
            array('C:/base/path/dir', 'C:/base/path/di', false),
            array('C:\\base\\path\\dir', 'C:\\base\\path\\di', false),
            array('C:/base/path/dir', 'C:\\base\\path\\di', false),

            // root
            array('/', '/second', true),
            array('C:/', 'C:/second', true),
            array('C:', 'C:/second', true),
            array('C:\\', 'C:\\second', true),
            array('C:/', 'C:\\second', true),

            // windows vs unix
            array('/base/path', 'C:/base/path', false),
            array('C:/base/path', '/base/path', false),
            array('/base/path', 'C:\\base\\path', false),

            // different partitions
            array('C:/base/path', 'D:/base/path', false),
            array('C:/base/path', 'D:\\base\\path', false),
            array('C:\\base\\path', 'D:\\base\\path', false),
        );
    }

    /**
     * @dataProvider provideIsBasePathTests
     */
    public function testIsBasePath($path, $ofPath, $result)
    {
        $this->assertSame($result, Path::isBasePath($path, $ofPath));
    }
}
