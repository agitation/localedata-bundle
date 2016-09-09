<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Seed;

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

        foreach ($currencies as $currency)
        {
            $event->addSeedEntry("AgitLocaleDataBundle:Currency", [
                "id" => $currency->getCode(),
                "name" => $currency->getName($defaultLocale)
            ]);
        }
    }
}
