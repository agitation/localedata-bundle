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
    protected $code;

    protected $nameList = [];

    public function __construct($code)
    {
        $this->code = (string)$code;
    }

    public function addName($locale, $name)
    {
        $this->nameList[$locale] = (string)$name;
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
}