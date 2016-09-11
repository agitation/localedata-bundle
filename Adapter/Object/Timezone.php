<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter\Object;

class Timezone extends AbstractObject
{
    private $country;

    public function __construct($code, Country $country)
    {
        $this->code = (string) $code;
        $this->country = $country;
    }

    public function getCountry()
    {
        return $this->country;
    }
}
