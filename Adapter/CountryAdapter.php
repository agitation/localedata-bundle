<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter;

use Agit\CoreBundle\Exception\InternalErrorException;
use Agit\LocaleDataBundle\Adapter\Object\Country;

class CountryAdapter extends AbstractAdapter
{
    protected $CurrencyAdapter;

    protected $CountryCurrencyAdapter;

    protected $CountryList = null;

    public function __construct(CurrencyAdapter $CurrencyAdapter, CountryCurrencyAdapter $CountryCurrencyAdapter)
    {
        $this->CurrencyAdapter = $CurrencyAdapter;
        $this->CountryCurrencyAdapter = $CountryCurrencyAdapter;
    }

    public function getCountryList()
    {
        return $this->getList('CountryList');
    }

    public function hasCountry($code)
    {
        return $this->hasListElement('CountryList', $code);
    }

    public function getCountry($code)
    {
        return $this->getListElement('CountryList', $code);
    }

    protected function load()
    {
        if (is_null($this->CountryList))
        {
            $this->CountryList = [];

            $defaultLocale = $this->LocaleService->getDefaultLocale();
            $availableLocales = $this->LocaleService->getAvailableLocales();

            $countries = $this->getMainData($this->baseLocDir, 'territories.json');
            $phoneCodes = $this->getSupplementalData('telephoneCodeData.json');
            $CurrencyList = $this->CurrencyAdapter->getCurrencyList();
            $currencyMappings = $this->CountryCurrencyAdapter->getCountryCurrencyMap();

            // collect main data ...
            foreach ($countries['main'][$this->baseLocDir]['localeDisplayNames']['territories'] as $code => $name)
            {
                if (
                    strlen($code) === 2 &&
                    !is_numeric($code) &&
                    $code !== 'ZZ' &&
                    isset($currencyMappings[$code]) &&
                    isset($CurrencyList[$currencyMappings[$code]]) &&
                    isset($phoneCodes['supplemental']['telephoneCodeData'][$code]) &&
                    isset($phoneCodes['supplemental']['telephoneCodeData'][$code][0]) &&
                    isset($phoneCodes['supplemental']['telephoneCodeData'][$code][0]['telephoneCountryCode'])
                ) {
                    $this->CountryList[$code] = new Country(
                        $code,
                        $CurrencyList[$currencyMappings[$code]],
                        $phoneCodes['supplemental']['telephoneCodeData'][$code][0]['telephoneCountryCode']);

                    $this->CountryList[$code]->addName($defaultLocale, $name);
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
                    if (isset($this->CountryList[$locCode]))
                        $this->CountryList[$locCode]->addName($loc, $locName);
            }
        }
    }
}
