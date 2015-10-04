<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter\Object;

use Agit\CoreBundle\Exception\InternalErrorException;

abstract class AbstractObject
{
    protected static $hasAbbr = false;

    protected $code;

    protected $nameList = [];

    protected $abbrList = [];

    public function __construct($code)
    {
        $this->code = (string)$code;
    }

    public function addName($locale, $name, $abbr = null)
    {
        if (static::$hasAbbr && !is_string($abbr))
            throw new InternalErrorException(sprintf("Object type %s needs an abbreviation.", get_class()));

        $this->nameList[$locale] = (string)$name;
        $this->abbrList[$locale] = (string)$abbr;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getNameList()
    {
        return $this->nameList;
    }

    public function getName($locale)
    {
        if (!isset($this->nameList[$locale]))
            throw new InternalErrorException("No name was found for locale '$locale'.");

        return $this->nameList[$locale];
    }

    public function getAbbr($locale)
    {
        if (!static::$hasAbbr)
            throw new InternalErrorException(sprintf("Object type %s doesn't support abbreviations.", get_class()));

        if (!isset($this->abbrList[$locale]))
            throw new InternalErrorException("No abbreviation was found for locale '$locale'.");

        return $this->abbrList[$locale];
    }
}
