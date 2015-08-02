<?php

/*
 * This file is part of the webmozart/path-util package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webmozart\PathUtil;

use InvalidArgumentException;
use RuntimeException;
use Webmozart\Assert\Assert;

/**
 * Contains utility methods for handling URL strings.
 *
 * The methods in this class are able to deal with URLs.
 *
 * @since  1.0
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 * @author Claudio Zizza <claudio@budgegeria.de>
 */
final class Url
{
    public static function makeRelative($path, $basePath)
    {
        return Path::makeRelative($path, $basePath);
    }
}
