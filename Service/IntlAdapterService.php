<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Service;

use Agit\CommonBundle\Exception\InternalErrorException;
use Agit\LocaleDataBundle\Adapter\CountryAdapter;
use Agit\LocaleDataBundle\Adapter\CountryCurrencyAdapter;
use Agit\LocaleDataBundle\Adapter\CurrencyAdapter;
use Agit\LocaleDataBundle\Adapter\LanguageAdapter;
use Agit\LocaleDataBundle\Adapter\TimeAdapter;
use Agit\LocaleDataBundle\Adapter\TimezoneAdapter;

/**
 * Facade service to all the intl adapters
 */
class IntlAdapterService
{
    public function __construct(CountryCurrencyAdapter $countryCurrencyAdapter, CurrencyAdapter $currencyAdapter,
        CountryAdapter $countryAdapter, LanguageAdapter $languageAdapter, TimeAdapter $timeAdapter,
        TimezoneAdapter $timezoneAdapter)
    {
        $this->countryCurrencyAdapter = $countryCurrencyAdapter;
        $this->currencyAdapter = $currencyAdapter;
        $this->countryAdapter = $countryAdapter;
        $this->languageAdapter = $languageAdapter;
        $this->timeAdapter = $timeAdapter;
        $this->timezoneAdapter = $timezoneAdapter;
    }

    public function getLanguageList()
    {
        return $this->languageAdapter->getLanguageList();
    }

    public function getLanguage($code)
    {
        return $this->languageAdapter->getLanguage($code);
    }

    public function getCurrencyList()
    {
        return $this->currencyAdapter->getCurrencyList();
    }

    public function getCurrency($code)
    {
        return $this->currencyAdapter->getCurrency($code);
    }

    public function getTimezoneList()
    {
        return $this->timezoneAdapter->getTimezoneList();
    }

    public function getTimezone($code)
    {
        return $this->timezoneAdapter->getTimezone($code);
    }

    public function getCountryCurrencyMap()
    {
        return $this->countryCurrencyAdapter->getCountryCurrencyMap();
    }

    public function getCountryList()
    {
        return $this->countryAdapter->getCountryList();
    }

    public function getCountry($code)
    {
        return $this->countryAdapter->getCountry($code);
    }

    public function getMonthList()
    {
        return $this->timeAdapter->getMonthList();
    }

    public function getMonth($code)
    {
        return $this->timeAdapter->getMonth($code);
    }

    public function getWeekdayList()
    {
        return $this->timeAdapter->getWeekdayList();
    }

    public function getWeekday($code)
    {
        return $this->timeAdapter->getWeekday($code);
    }
}
