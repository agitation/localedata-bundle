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
    private $Currency;

    public function __construct($code, Currency $Currency)
    {
        $this->code = (string)$code;
        $this->Currency = $Currency;
    }

    public function getCurrency()
    {
        return $this->Currency;
    }
}