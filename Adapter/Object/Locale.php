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

// NOTE: We will use the 'name' property for the *language* name. Country name can be derived from the Country property.

class Locale extends AbstractObject
{
    private $Country;

    public function __construct($code, Country $Country)
    {
        $this->code = (string)$code;
        $this->Country = $Country;
    }

    public function getCountry()
    {
        return $this->Country;
    }

    public function getLocalName()
    {
        if (!isset($this->nameList[$this->code]))
            throw new InternalErrorException("The local name of the '{$this->code}' locale is not set.");

        return $this->nameList[$this->code];
    }
}
