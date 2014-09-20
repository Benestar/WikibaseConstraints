# Wikibase Constraints

[![Build Status](https://secure.travis-ci.org/Benestar/WikibaseConstraints.png?branch=master)](http://travis-ci.org/Benestar/WikibaseConstraints)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/benestar/WikibaseConstraints/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/benestar/WikibaseConstraints/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/benestar/WikibaseConstraints/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/benestar/WikibaseConstraints/?branch=master)

**Wikibase Constraints** is a library which provides several constraints to
validate statements saved within the [Wikibase software](http://wikiba.se/).

Recent changes can be found in the [release notes](RELEASE-NOTES.md).

## Installation

You can use [Composer](http://getcomposer.org/) to download and install
this package as well as its dependencies. Alternatively you can simply clone
the git repository and take care of loading yourself.

### Composer

To add this package as a local, per-project dependency to your project, simply add a
dependency on `wikibase/constraints` to your project's `composer.json` file.
Here is a minimal example of a `composer.json` file that just defines a dependency on
Wikibase Constraints 0.1:

```js
{
    "require": {
        "wikibase/constraints": "~0.1"
    }
}
```

### Manual

Get the Wikibase DataModel code, either via git, or some other means. Also get all dependencies.
You can find a list of the dependencies in the "require" section of the composer.json file.
The "autoload" section of this file specifies how to load the resources provide by this library.

## Library contents

This library contains a constraints system to validate data saved in Wikibase. Currently this
happens through [templates](https://www.wikidata.org/wiki/Template:Constraint) on properties'
talk pages and a bot which regularly updates [maintenance pages]
(https://www.wikidata.org/wiki/Wikidata:Database_reports/Constraint_violations/All_properties).

## Tests

This library comes with a set up PHPUnit tests that cover all non-trivial code. You can run these
tests using the PHPUnit configuration file found in the root directory. The tests can also be run
via TravisCI, as a TravisCI configuration file is also provided in the root directory.

## Credits

### Development

Wikibase Constraints has been written by [Bene*](https://www.wikidata.org/wiki/User:Bene*) as volunteer.


