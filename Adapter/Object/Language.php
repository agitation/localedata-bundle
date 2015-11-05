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

class Language extends AbstractObject
{
    private $countryList = [];

    private $localName;

    public function __construct($code, $localName)
    {
        $this->code = (string)$code;
        $this->localName = (string)$localName;
    }

    public function addCountry(Country $country)
    {
        $this->countryList[] = $country;
    }

    public function getLocalName()
    {
        return $this->localName;
    }

    public function getCountryList()
    {
        return $this->countryList;
    }
}