Changelog
=========

* 1.1.0 (2015-03-19)

 * added `Path::getFilename()`
 * added `Path::getFilenameWithoutExtension()`
 * added `Path::getExtension()`
 * added `Path::hasExtension()`
 * added `Path::changeExtension()`
 * `Path::makeRelative()` now works when the absolute path and the base path
   have equal directory names beneath different base directories
   (e.g. "/webmozart/css/style.css" relative to "/puli/css")
   
* 1.0.2 (2015-01-12)

 * `Path::makeAbsolute()` fails now if the base path is not absolute
 * `Path::makeRelative()` now works when a relative path is passed and the base
   path is empty

* 1.0.1 (2014-12-03)

 * Added PHP 5.6 to Travis.
 * Fixed bug in `Path::makeRelative()` when first argument is shorter than second
 * Made HHVM compatibility mandatory in .travis.yml
 * Added PHP 5.3.3 to travis.yml

* 1.0.0 (2014-11-26)

 * first release
