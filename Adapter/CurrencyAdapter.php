<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

/**
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 *
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter;

use Agit\LocaleDataBundle\Adapter\Object\Currency;

class CurrencyAdapter extends AbstractAdapter
{
    protected $currencies = null;

    protected $countryCurrencyAdapter;

    public function __construct(CountryCurrencyAdapter $countryCurrencyAdapter)
    {
        $this->countryCurrencyAdapter = $countryCurrencyAdapter;
    }

    public function getCurrencies()
    {
        return $this->getList('currencies');
    }

    public function hasCurrency($code)
    {
        return $this->hasListElement('currencies', $code);
    }

    public function getCurrency($code)
    {
        return $this->getListElement('currencies', $code);
    }

    protected function load()
    {
        if (is_null($this->currencies)) {
            $this->currencies = [];
            $currencyData = $this->getMainData($this->baseLocDir, 'currencies.json');
            $currencyMappings = array_flip($this->countryCurrencyAdapter->getCountryCurrencyMap());

            $defaultLocale = $this->localeService->getDefaultLocale();
            $availableLocales = $this->localeService->getAvailableLocales();

            // collect main data ...
            foreach ($currencyData['main'][$this->baseLocDir]['numbers']['currencies'] as $code => $list) {
                if (isset($currencyMappings[$code])) {
                    $this->currencies[$code] = new Currency($code);
                    $this->currencies[$code]->addName($defaultLocale, $list['displayName']);
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

                $locCurrencies = $this->getMainData($locDir, 'currencies.json');

                foreach ($locCurrencies['main'][$locDir]['numbers']['currencies'] as $locCode => $locs) {
                    if (isset($this->currencies[$locCode])) {
                        $this->currencies[$locCode]->addName($loc, $locs['displayName']);
                    }
                }
            }
        }
    }
}
