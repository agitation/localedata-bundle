<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\EventListener;

use Agit\IntlBundle\Service\LocaleService;
use Agit\LocaleDataBundle\Adapter\CurrencyAdapter;
use Agit\SeedBundle\Event\SeedEvent;

class CurrencySeed
{
    private $localeService;

    private $currencyAdapter;

    public function __construct(LocaleService $localeService, CurrencyAdapter $currencyAdapter)
    {
        $this->localeService = $localeService;
        $this->currencyAdapter = $currencyAdapter;
    }

    public function registerSeed(SeedEvent $event)
    {
        $defaultLocale = $this->localeService->getDefaultLocale();
        $currencies = $this->currencyAdapter->getCurrencies();

        foreach ($currencies as $currency) {
            $event->addSeedEntry("AgitLocaleDataBundle:Currency", [
                "id"   => $currency->getCode(),
                "name" => $currency->getName($defaultLocale)
            ]);
        }
    }
}
