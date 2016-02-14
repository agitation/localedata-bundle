<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter;

use Agit\CommonBundle\Exception\InternalErrorException;
use Agit\LocaleDataBundle\Adapter\Object\Country;

class CountryAdapter extends AbstractAdapter
{
    protected $currencyAdapter;

    protected $countryCurrencyAdapter;

    protected $countryList = null;

    public function __construct(CurrencyAdapter $currencyAdapter, CountryCurrencyAdapter $countryCurrencyAdapter)
    {
        $this->currencyAdapter = $currencyAdapter;
        $this->countryCurrencyAdapter = $countryCurrencyAdapter;
    }

    public function getCountryList()
    {
        return $this->getList('countryList');
    }

    public function hasCountry($code)
    {
        return $this->hasListElement('countryList', $code);
    }

    public function getCountry($code)
    {
        return $this->getListElement('countryList', $code);
    }

    protected function load()
    {
        if (is_null($this->countryList))
        {
            $this->countryList = [];

            $defaultLocale = $this->localeService->getDefaultLocale();
            $availableLocales = $this->localeService->getAvailableLocales();

            $countries = $this->getMainData($this->baseLocDir, 'territories.json');
            $codeMappings = $this->getSupplementalData('codeMappings.json');
            $phoneCodes = $this->getSupplementalData('telephoneCodeData.json');
            $currencyList = $this->currencyAdapter->getCurrencyList();
            $currencyMappings = $this->countryCurrencyAdapter->getCountryCurrencyMap();

            // collect main data ...
            foreach ($countries['main'][$this->baseLocDir]['localeDisplayNames']['territories'] as $code => $name)
            {
                if (
                    strlen($code) === 2 &&
                    !is_numeric($code) &&
                    $code !== 'ZZ' &&
                    isset($currencyMappings[$code]) &&
                    isset($currencyList[$currencyMappings[$code]]) &&

                    isset($codeMappings['supplemental']['codeMappings'][$code]) &&
                    isset($codeMappings['supplemental']['codeMappings'][$code]["_alpha3"]) &&

                    isset($phoneCodes['supplemental']['telephoneCodeData'][$code]) &&
                    isset($phoneCodes['supplemental']['telephoneCodeData'][$code][0]) &&
                    isset($phoneCodes['supplemental']['telephoneCodeData'][$code][0]['telephoneCountryCode'])
                ) {
                    $this->countryList[$code] = new Country(
                        $code,
                        $codeMappings['supplemental']['codeMappings'][$code]["_alpha3"],
                        $currencyList[$currencyMappings[$code]],
                        $phoneCodes['supplemental']['telephoneCodeData'][$code][0]['telephoneCountryCode']);

                    $this->countryList[$code]->addName($defaultLocale, $name);
                }
            }

            // ... and fill up with translations
            foreach ($availableLocales as $loc)
            {
                if ($loc === $defaultLocale) continue;

                $locDir = $this->findLocDirForLocale($loc);
                if (!$locDir) continue;

                $locCountries = $this->getMainData($locDir, 'territories.json');

                foreach ($locCountries['main'][$locDir]['localeDisplayNames']['territories'] as $locCode => $locName)
                    if (isset($this->countryList[$locCode]))
                        $this->countryList[$locCode]->addName($loc, $locName);
            }
        }
    }
}
