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
use Agit\LocaleDataBundle\Adapter\Object\Currency;

class CurrencyAdapter extends AbstractAdapter
{
    protected $currencyList = null;

    protected $countryCurrencyAdapter;

    public function __construct(CountryCurrencyAdapter $countryCurrencyAdapter)
    {
        $this->countryCurrencyAdapter = $countryCurrencyAdapter;
    }

    public function getCurrencyList()
    {
        return $this->getList('currencyList');
    }

    public function hasCurrency($code)
    {
        return $this->hasListElement('currencyList', $code);
    }

    public function getCurrency($code)
    {
        return $this->getListElement('currencyList', $code);
    }

    protected function load()
    {
        if (is_null($this->currencyList))
        {
            $this->currencyList = [];
            $currencyData = $this->getMainData($this->baseLocDir, 'currencies.json');
            $currencyMappings = array_flip($this->countryCurrencyAdapter->getCountryCurrencyMap());

            $defaultLocale = $this->localeService->getDefaultLocale();
            $availableLocales = $this->localeService->getAvailableLocales();

            // collect main data ...
            foreach ($currencyData['main'][$this->baseLocDir]['numbers']['currencies'] as $code => $list)
            {
                if (isset($currencyMappings[$code]))
                {
                    $this->currencyList[$code] = new Currency($code);
                    $this->currencyList[$code]->addName($defaultLocale, $list['displayName']);
                }
            }

            // ... and fill up with translations
            foreach ($availableLocales as $loc)
            {
                if ($loc === $defaultLocale) continue;

                $locDir = $this->findLocDirForLocale($loc);
                if (!$locDir) continue;

                $locCurrencies = $this->getMainData($locDir, 'currencies.json');

                foreach ($locCurrencies['main'][$locDir]['numbers']['currencies'] as $locCode => $locList)
                    if (isset($this->currencyList[$locCode]))
                        $this->currencyList[$locCode]->addName($loc, $locList['displayName']);
            }
        }
    }
}
