File Path Utility
=================

[![Build Status](https://travis-ci.org/webmozart/path-util.png?branch=master)](https://travis-ci.org/webmozart/path-util)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/webmozart/path-util/badges/quality-score.png?s=f1fbf1884aed7f896c18fc237d3eed5823ac85eb)](https://scrutinizer-ci.com/g/webmozart/path-util/)
[![Code Coverage](https://scrutinizer-ci.com/g/webmozart/path-util/badges/coverage.png?s=5d83649f6fc3a9754297da9dc0d997be212c9145)](https://scrutinizer-ci.com/g/webmozart/path-util/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/728198dc-dc0f-4bab-b5c0-c0b4e2a55bce/mini.png)](https://insight.sensiolabs.com/projects/728198dc-dc0f-4bab-b5c0-c0b4e2a55bce)
[![Latest Stable Version](https://poser.pugx.org/webmozart/path-util/v/stable.png)](https://packagist.org/packages/webmozart/path-util)
[![Total Downloads](https://poser.pugx.org/webmozart/path-util/downloads.png)](https://packagist.org/packages/webmozart/path-util)
[![Dependency Status](https://www.versioneye.com/php/webmozart:path-util/1.0.0/badge.png)](https://www.versioneye.com/php/webmozart:path-util/1.0.0)

Latest release: none

PHP >= 5.3.3

This package provides robust, cross-platform utility functions for normalizing,
comparing and modifying file paths:

```php
use Webmozart\\PathUtil\\Path;

echo Path::canonicalize('/var/www/vhost/webmozart/../config.ini');
// => /var/www/vhost/config.ini

echo Path::canonicalize('C:\\Programs\\Webmozart\\..\\config.ini');
// => C:/Programs/config.ini

$paths = array(
    '/var/www/vhosts/project/httpdocs/config/config.yml',
    '/var/www/vhosts/project/httpdocs/images/banana.gif',
    '/var/www/vhosts/project/httpdocs/uploads/../images/nicer-banana.gif',
);

Path::getLongestCommonBasePath($paths);
// => /var/www/vhosts/project/httpdocs
```

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

Puli and its documentation are licensed under the [MIT license].

[Bernhard Schussek]: http://webmozarts.com
[The Community Contributors]: https://github.com/webmozart/path-util/graphs/contributors
[Composer]: https://getcomposer.org
[Documentation]: docs/usage.md
[issue tracker]: https://github.com/webmozart/path-util/issues
[Git repository]: https://github.com/webmozart/path-util
[@webmozart]: https://twitter.com/webmozart
[MIT license]: LICENSE
