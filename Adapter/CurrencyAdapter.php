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
    protected $CurrencyList = null;

    protected $CountryCurrencyAdapter;

    public function __construct(CountryCurrencyAdapter $CountryCurrencyAdapter)
    {
        $this->CountryCurrencyAdapter = $CountryCurrencyAdapter;
    }

    public function getCurrencyList()
    {
        return $this->getList('CurrencyList');
    }

    public function hasCurrency($code)
    {
        return $this->hasListElement('CurrencyList', $code);
    }

    public function getCurrency($code)
    {
        return $this->getListElement('CurrencyList', $code);
    }

    protected function load()
    {
        if (is_null($this->CurrencyList))
        {
            $this->CurrencyList = [];
            $currencyData = $this->getMainData($this->baseLocDir, 'currencies.json');
            $currencyMappings = array_flip($this->CountryCurrencyAdapter->getCountryCurrencyMap());

            $defaultLocale = $this->LocaleService->getDefaultLocale();
            $availableLocales = $this->LocaleService->getAvailableLocales();

            // collect main data ...
            foreach ($currencyData['main'][$this->baseLocDir]['numbers']['currencies'] as $code => $list)
            {
                if (isset($currencyMappings[$code]))
                {
                    $this->CurrencyList[$code] = new Currency($code);
                    $this->CurrencyList[$code]->addName($defaultLocale, $list['displayName']);
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
                    if (isset($this->CurrencyList[$locCode]))
                        $this->CurrencyList[$locCode]->addName($loc, $locList['displayName']);
            }
        }
    }
}