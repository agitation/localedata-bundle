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
use Agit\LocaleDataBundle\Adapter\Object\Language;

class LanguageAdapter extends AbstractAdapter
{
    protected $countryAdapter;

    protected $languageList = null;

    protected $languageCountryMap = [];

    public function __construct(CountryAdapter $countryAdapter)
    {
        $this->countryAdapter = $countryAdapter;
    }

    public function getLanguageList()
    {
        return $this->getList('languageList');
    }

    public function hasLanguage($code)
    {
        return $this->hasListElement('languageList', $code);
    }

    public function getLanguage($code)
    {
        return $this->getListElement('languageList', $code);
    }

    protected function load()
    {
        if (is_null($this->languageList))
        {
            $this->languageList = [];

            $defaultLocale = $this->localeService->getDefaultLocale();
            $availableLocales = $this->localeService->getAvailableLocales();

            $territories = $this->getSupplementalData('territoryInfo.json');

            // collect main data ...
            foreach ($territories['supplemental']['territoryInfo'] as $countryCode => $data)
            {
                if (strlen($countryCode) !== 2 || is_numeric($countryCode) || $countryCode === 'ZZ' || !isset($data['languagePopulation']))
                    continue;

                foreach ($data['languagePopulation'] as $langCode => $langData)
                {
                    if (
                        strlen($langCode) !== 2 ||
                        !isset($langData['_officialStatus']) ||
                        !isset($langData['_populationPercent']) ||
                        $langData['_officialStatus'] !== 'official' ||
                        $langData['_populationPercent'] < 3 ||
                        !$this->countryAdapter->hasCountry($countryCode)
                    )
                        continue;

                    $localeDir = $this->findLocDirForLocale($langCode);
                    if (!$localeDir) $localeDir = $this->findLocDirForLocale($defaultLocale);

                    $languages = $this->getMainData($localeDir, 'languages.json');

                    if (!isset($languages['main'][$localeDir]['localeDisplayNames']['languages'][$langCode]))
                        continue;

                    $localName = $languages['main'][$localeDir]['localeDisplayNames']['languages'][$langCode];

                    $this->languageList[$langCode] = new Language($langCode, $localName);

                    if (!isset($this->languageCountryMap[$langCode]))
                        $this->languageCountryMap[$langCode] = [];

                    $this->languageCountryMap[$langCode][$countryCode] = $countryCode;
                }
            }

            // ... and fill up with translations
            foreach ($availableLocales as $locale)
            {
                $localeDir = $this->findLocDirForLocale($locale);
                if (!$localeDir) continue;

                $languages = $this->getMainData($localeDir, 'languages.json');

                foreach ($this->languageList as $langCode => &$language)
                {
                    $language->addName($locale, $languages['main'][$localeDir]['localeDisplayNames']['languages'][$langCode]);
                }
            }

            // add countries for languages
            foreach ($this->languageList as $langCode => &$language)
            {
                // dead language?
                if (!isset($this->languageCountryMap[$langCode]))
                {
                    unset($this->languageList[$langCode]);
                    continue;
                }

                foreach ($this->languageCountryMap[$langCode] as $countryCode)
                    $language->addCountry($this->countryAdapter->getCountry($countryCode));
            }
        }
    }
}
