<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter\Object;

use Agit\BaseBundle\Exception\InternalErrorException;

abstract class AbstractObject
{
    protected static $hasAbbr = false;

    protected $code;

    protected $names = [];

    protected $abbrs = [];

    public function __construct($code)
    {
        $this->code = (string) $code;
    }

    public function addName($locale, $name, $abbr = null)
    {
        if (static::$hasAbbr && ! is_string($abbr)) {
            throw new InternalErrorException(sprintf("Object type %s needs an abbreviation.", get_class()));
        }

        $this->names[$locale] = (string) $name;
        $this->abbrs[$locale] = (string) $abbr;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getNames()
    {
        return $this->names;
    }

    public function getName($locale)
    {
        if (! isset($this->names[$locale])) {
            throw new InternalErrorException("No name was found for locale '$locale'.");
        }

        return $this->names[$locale];
    }

    public function getAbbr($locale)
    {
        if (! static::$hasAbbr) {
            throw new InternalErrorException(sprintf("Object type %s doesn't support abbreviations.", get_class()));
        }

        if (! isset($this->abbrs[$locale])) {
            throw new InternalErrorException("No abbreviation was found for locale '$locale'.");
        }

        return $this->abbrs[$locale];
    }
}
