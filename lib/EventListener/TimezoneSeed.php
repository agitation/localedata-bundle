<?php
declare(strict_types=1);
/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\EventListener;

use Agit\CldrBundle\Adapter\TimezoneAdapter;
use Agit\IntlBundle\Service\LocaleService;
use Agit\SeedBundle\Event\SeedEvent;

class TimezoneSeed
{
    private $localeService;

    private $timezoneAdapter;

    public function __construct(LocaleService $localeService, TimezoneAdapter $timezoneAdapter)
    {
        $this->localeService = $localeService;
        $this->timezoneAdapter = $timezoneAdapter;
    }

    public function registerSeed(SeedEvent $event)
    {
        $defaultLocale = $this->localeService->getDefaultLocale();

        $timezones = $this->timezoneAdapter->getTimezones(
            $defaultLocale,
            $this->localeService->getAvailableLocales()
        );

        foreach ($timezones as $timezone)
        {
            $event->addSeedEntry('AgitLocaleDataBundle:Timezone', [
                'id' => $timezone->getCode(),
                'name' => $timezone->getName($defaultLocale),
                'country' => $timezone->getCountry()->getCode()
            ]);
        }
    }
}
