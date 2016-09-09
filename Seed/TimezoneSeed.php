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
use Agit\LocaleDataBundle\Adapter\TimezoneAdapter;
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
        $timezones = $this->timezoneAdapter->getTimezones();

        foreach ($timezones as $timezone)
        {
            $event->addSeedEntry("AgitLocaleDataBundle:Timezone", [
                "id" => $timezone->getCode(),
                "name" => $timezone->getName($defaultLocale),
                "country" => $timezone->getCountry()->getCode()
            ]);
        }
    }
}
