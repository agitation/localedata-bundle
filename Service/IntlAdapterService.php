<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Service;

use Agit\CoreBundle\Exception\InternalErrorException;
use Agit\LocaleDataBundle\Adapter\CountryAdapter;
use Agit\LocaleDataBundle\Adapter\CountryCurrencyAdapter;
use Agit\LocaleDataBundle\Adapter\CurrencyAdapter;
use Agit\LocaleDataBundle\Adapter\LocaleAdapter;
use Agit\LocaleDataBundle\Adapter\TimeAdapter;
use Agit\LocaleDataBundle\Adapter\TimezoneAdapter;

/**
 * Facade service to all the intl adapters
 */
class IntlAdapterService
{
    public function __construct(CountryCurrencyAdapter $CountryCurrencyAdapter, CurrencyAdapter $CurrencyAdapter,
        CountryAdapter $CountryAdapter, LocaleAdapter $LocaleAdapter, TimeAdapter $TimeAdapter,
        TimezoneAdapter $TimezoneAdapter)
    {
        $this->CountryCurrencyAdapter = $CountryCurrencyAdapter;
        $this->CurrencyAdapter = $CurrencyAdapter;
        $this->CountryAdapter = $CountryAdapter;
        $this->LocaleAdapter = $LocaleAdapter;
        $this->TimeAdapter = $TimeAdapter;
        $this->TimezoneAdapter = $TimezoneAdapter;
    }

    public function getLocaleList()
    {
        return $this->LocaleAdapter->getLocaleList();
    }

    public function getLocale($code)
    {
        return $this->LocaleAdapter->getLocale($code);
    }

    public function getCurrencyList()
    {
        return $this->CurrencyAdapter->getCurrencyList();
    }

    public function getCurrency($code)
    {
        return $this->CurrencyAdapter->getCurrency($code);
    }

    public function getTimezoneList()
    {
        return $this->TimezoneAdapter->getTimezoneList();
    }

    public function getTimezone($code)
    {
        return $this->TimezoneAdapter->getTimezone($code);
    }

    public function getCountryCurrencyMap()
    {
        return $this->CountryCurrencyAdapter->getCountryCurrencyMap();
    }

    public function getCountryList()
    {
        return $this->CountryAdapter->getCountryList();
    }

    public function getCountry($code)
    {
        return $this->CountryAdapter->getCountry($code);
    }

    public function getMonthList()
    {
        return $this->TimeAdapter->getMonthList();
    }

    public function getMonth($code)
    {
        return $this->TimeAdapter->getMonth($code);
    }

    public function getWeekdayList()
    {
        return $this->TimeAdapter->getWeekdayList();
    }

    public function getWeekday($code)
    {
        return $this->TimeAdapter->getWeekday($code);
    }
}
