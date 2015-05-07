<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter\Object;

class Timezone extends AbstractObject
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
}