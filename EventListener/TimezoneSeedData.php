<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Agit\CoreBundle\Pluggable\Strategy\Seed\SeedRegistrationEvent;
use Agit\IntlBundle\Service\LocaleService;
use Agit\LocaleDataBundle\Adapter\TimezoneAdapter;

class TimezoneSeedData
{
    private $localeService;

    private $timezoneAdapter;

    public function __construct(LocaleService $localeService, TimezoneAdapter $timezoneAdapter)
    {
        $this->localeService = $localeService;
        $this->timezoneAdapter = $timezoneAdapter;
    }

    public function onRegistration(SeedRegistrationEvent $registrationEvent)
    {
        $defaultLocale = $this->localeService->getDefaultLocale();
        $timezoneList = $this->timezoneAdapter->getTimezoneList();

        foreach ($timezoneList as $timezone)
        {
            $registrationData = $registrationEvent->createContainer();
            $registrationData->setData([
                'id' => $timezone->getCode(),
                'name' => $timezone->getName($defaultLocale),
                'country' => $timezone->getCountry()->getCode()
            ]);
            $registrationEvent->register($registrationData);
        }
    }
}
