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
    private $LocaleService;

    private $TimezoneAdapter;

    public function __construct(LocaleService $LocaleService, TimezoneAdapter $TimezoneAdapter)
    {
        $this->LocaleService = $LocaleService;
        $this->TimezoneAdapter = $TimezoneAdapter;
    }

    public function onRegistration(SeedRegistrationEvent $RegistrationEvent)
    {
        $defaultLocale = $this->LocaleService->getDefaultLocale();
        $TimezoneList = $this->TimezoneAdapter->getTimezoneList();

        foreach ($TimezoneList as $Timezone)
        {
            $RegistrationData = $RegistrationEvent->createContainer();
            $RegistrationData->setData([
                'id' => $Timezone->getCode(),
                'name' => $Timezone->getName($defaultLocale),
                'Country' => $Timezone->getCountry()->getCode()
            ]);
            $RegistrationEvent->register($RegistrationData);
        }
    }
}
