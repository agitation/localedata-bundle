<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter\Object;

class Country extends AbstractObject
{
    private $longCode;

    private $currency;

    private $phone;

    public function __construct($code, $longCode, Currency $currency, $phone)
    {
        $this->code = (string)$code;
        $this->longCode = (string)$longCode;
        $this->currency = $currency;
        $this->phone = $phone;
    }

    public function getLongCode()
    {
        return $this->longCode;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getPhone()
    {
        return $this->phone;
    }
}
