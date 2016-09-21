<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Service;

use Agit\LocaleDataBundle\Adapter\CountryAdapter;
use Agit\LocaleDataBundle\Adapter\CountryCurrencyAdapter;
use Agit\LocaleDataBundle\Adapter\CurrencyAdapter;
use Agit\LocaleDataBundle\Adapter\LanguageAdapter;
use Agit\LocaleDataBundle\Adapter\TimeAdapter;
use Agit\LocaleDataBundle\Adapter\TimezoneAdapter;

/**
 * Facade service to all the intl adapters.
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

    public function getLanguages()
    {
        return $this->languageAdapter->getLanguages();
    }

    public function getLanguage($code)
    {
        return $this->languageAdapter->getLanguage($code);
    }

    public function getCurrencies()
    {
        return $this->currencyAdapter->getCurrencies();
    }

    public function getCurrency($code)
    {
        return $this->currencyAdapter->getCurrency($code);
    }

    public function getTimezones()
    {
        return $this->timezoneAdapter->getTimezones();
    }

    public function getTimezone($code)
    {
        return $this->timezoneAdapter->getTimezone($code);
    }

    public function getCountryCurrencyMap()
    {
        return $this->countryCurrencyAdapter->getCountryCurrencyMap();
    }

    public function getCountries()
    {
        return $this->countryAdapter->getCountries();
    }

    public function getCountry($code)
    {
        return $this->countryAdapter->getCountry($code);
    }

    public function getMonths()
    {
        return $this->timeAdapter->getMonths();
    }

    public function getMonth($code)
    {
        return $this->timeAdapter->getMonth($code);
    }

    public function getWeekdays()
    {
        return $this->timeAdapter->getWeekdays();
    }

    public function getWeekday($code)
    {
        return $this->timeAdapter->getWeekday($code);
    }
}