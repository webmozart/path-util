File Path Utility
=================

[![Build Status](https://travis-ci.org/webmozart/path-util.svg?branch=master)](https://travis-ci.org/webmozart/path-util)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/webmozart/path-util/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/webmozart/path-util/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/b8c658df-0cce-4566-bf55-75da109aa6d7/mini.png)](https://insight.sensiolabs.com/projects/b8c658df-0cce-4566-bf55-75da109aa6d7)
[![Latest Stable Version](https://poser.pugx.org/webmozart/path-util/v/stable.svg)](https://packagist.org/packages/webmozart/path-util)
[![Total Downloads](https://poser.pugx.org/webmozart/path-util/downloads.svg)](https://packagist.org/packages/webmozart/path-util)
[![Dependency Status](https://www.versioneye.com/php/webmozart:path-util/1.0.2/badge.svg)](https://www.versioneye.com/php/webmozart:path-util/1.0.2)

Latest release: [1.0.2](https://packagist.org/packages/webmozart/path-util#1.0.2)

PHP >= 5.3.3

This package provides robust, cross-platform utility functions for normalizing,
comparing and modifying file paths:

```php
use Webmozart\PathUtil\Path;

echo Path::canonicalize('/var/www/vhost/webmozart/../config.ini');
// => /var/www/vhost/config.ini

echo Path::canonicalize('C:\Programs\Webmozart\..\config.ini');
// => C:/Programs/config.ini

echo Path::makeAbsolute('config/config.yml', '/var/www/project');
// => /var/www/project/config/config.yml

echo Path::makeRelative('/var/www/project/config/config.yml', '/var/www/project/uploads');
// => ../config/config.yml

$paths = array(
    '/var/www/vhosts/project/httpdocs/config/config.yml',
    '/var/www/vhosts/project/httpdocs/images/banana.gif',
    '/var/www/vhosts/project/httpdocs/uploads/../images/nicer-banana.gif',
);

Path::getLongestCommonBasePath($paths);
// => /var/www/vhosts/project/httpdocs
```

Learn more in the [Documentation].

Authors
-------

* [Bernhard Schussek] a.k.a. [@webmozart]
* [The Community Contributors]

Installation
------------

The utility can be installed with [Composer]:

```
$ composer require webmozart/path-util:~1.0
```

Documentation
-------------

Read the [Documentation] if you want to learn more about the contained functions.

Contribute
----------

Contributions are always welcome!

* Report any bugs or issues you find on the [issue tracker].
* You can grab the source code at the [Git repository].

Support
-------

If you are having problems, send a mail to bschussek@gmail.com or shout out to
[@webmozart] on Twitter.

License
-------

All contents of this package are licensed under the [MIT license].

[Bernhard Schussek]: http://webmozarts.com
[The Community Contributors]: https://github.com/webmozart/path-util/graphs/contributors
[Composer]: https://getcomposer.org
[Documentation]: docs/usage.md
[issue tracker]: https://github.com/webmozart/path-util/issues
[Git repository]: https://github.com/webmozart/path-util
[@webmozart]: https://twitter.com/webmozart
[MIT license]: LICENSE
