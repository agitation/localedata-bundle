<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

/**
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 *
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter\Object;

class Language extends AbstractObject
{
    private $countries = [];

    private $localName;

    public function __construct($code, $localName)
    {
        $this->code = (string) $code;
        $this->localName = (string) $localName;
    }

    public function addCountry(Country $country)
    {
        $this->countries[] = $country;
    }

    public function getLocalName()
    {
        return $this->localName;
    }

    public function getCountries()
    {
        return $this->countries;
    }
}
