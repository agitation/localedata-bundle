<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\EventListener;

use Agit\IntlBundle\Service\LocaleService;
use Agit\LocaleDataBundle\Adapter\CountryAdapter;
use Agit\SeedBundle\Event\SeedEvent;

class CountrySeed
{
    private $localeService;

    private $countryAdapter;

    public function __construct(LocaleService $localeService, CountryAdapter $countryAdapter)
    {
        $this->localeService = $localeService;
        $this->countryAdapter = $countryAdapter;
    }

    public function registerSeed(SeedEvent $event)
    {
        $defaultLocale = $this->localeService->getDefaultLocale();
        $countries = $this->countryAdapter->getCountries();

        foreach ($countries as $country) {
            $event->addSeedEntry("AgitLocaleDataBundle:Country", [
                "id"       => $country->getCode(),
                "code"     => $country->getLongCode(),
                "phone"    => $country->getPhone(),
                "name"     => $country->getName($defaultLocale),
                "currency" => $country->getCurrency()->getCode()
            ]);
        }
    }
}
