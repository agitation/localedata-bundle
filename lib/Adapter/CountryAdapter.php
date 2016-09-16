<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter;

use Agit\LocaleDataBundle\Adapter\Object\Country;

class CountryAdapter extends AbstractAdapter
{
    protected $currencyAdapter;

    protected $countryCurrencyAdapter;

    protected $countries = null;

    public function __construct(CurrencyAdapter $currencyAdapter, CountryCurrencyAdapter $countryCurrencyAdapter)
    {
        $this->currencyAdapter = $currencyAdapter;
        $this->countryCurrencyAdapter = $countryCurrencyAdapter;
    }

    public function getCountries()
    {
        return $this->getList('countries');
    }

    public function hasCountry($code)
    {
        return $this->hasListElement('countries', $code);
    }

    public function getCountry($code)
    {
        return $this->getListElement('countries', $code);
    }

    protected function load()
    {
        if (is_null($this->countries)) {
            $this->countries = [];

            $defaultLocale = $this->localeService->getDefaultLocale();
            $availableLocales = $this->localeService->getAvailableLocales();

            $countries = $this->getMainData($this->baseLocDir, 'territories.json');
            $codeMappings = $this->getSupplementalData('codeMappings.json');
            $phoneCodes = $this->getSupplementalData('telephoneCodeData.json');
            $currencies = $this->currencyAdapter->getCurrencies();
            $currencyMappings = $this->countryCurrencyAdapter->getCountryCurrencyMap();

            // collect main data ...
            foreach ($countries['main'][$this->baseLocDir]['localeDisplayNames']['territories'] as $code => $name) {
                if (
                    strlen($code) === 2 &&
                    ! is_numeric($code) &&
                    $code !== 'ZZ' &&
                    isset($currencyMappings[$code]) &&
                    isset($currencies[$currencyMappings[$code]]) &&

                    isset($codeMappings['supplemental']['codeMappings'][$code]) &&
                    isset($codeMappings['supplemental']['codeMappings'][$code]["_alpha3"]) &&

                    isset($phoneCodes['supplemental']['telephoneCodeData'][$code]) &&
                    isset($phoneCodes['supplemental']['telephoneCodeData'][$code][0]) &&
                    isset($phoneCodes['supplemental']['telephoneCodeData'][$code][0]['telephoneCountryCode'])
                ) {
                    $this->countries[$code] = new Country(
                        $code,
                        $codeMappings['supplemental']['codeMappings'][$code]["_alpha3"],
                        $currencies[$currencyMappings[$code]],
                        $phoneCodes['supplemental']['telephoneCodeData'][$code][0]['telephoneCountryCode']);

                    $this->countries[$code]->addName($defaultLocale, $name);
                }
            }

            // ... and fill up with translations
            foreach ($availableLocales as $loc) {
                if ($loc === $defaultLocale) {
                    continue;
                }

                $locDir = $this->findLocDirForLocale($loc);
                if (! $locDir) {
                    continue;
                }

                $locCountries = $this->getMainData($locDir, 'territories.json');

                foreach ($locCountries['main'][$locDir]['localeDisplayNames']['territories'] as $locCode => $locName) {
                    if (isset($this->countries[$locCode])) {
                        $this->countries[$locCode]->addName($loc, $locName);
                    }
                }
            }
        }
    }
}
