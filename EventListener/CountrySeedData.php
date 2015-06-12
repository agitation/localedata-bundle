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
use Agit\LocaleDataBundle\Adapter\CountryAdapter;

class CountrySeedData
{
    private $LocaleService;

    private $CountryAdapter;

    public function __construct(LocaleService $LocaleService, CountryAdapter $CountryAdapter)
    {
        $this->LocaleService = $LocaleService;
        $this->CountryAdapter = $CountryAdapter;
    }

    public function onRegistration(SeedRegistrationEvent $RegistrationEvent)
    {
        $defaultLocale = $this->LocaleService->getDefaultLocale();
        $CountryList = $this->CountryAdapter->getCountryList();

        foreach ($CountryList as $Country)
        {
            $RegistrationData = $RegistrationEvent->createContainer();

            $RegistrationData->setData([
                'id' => $Country->getCode(),
                'phone' => $Country->getPhone(),
                'name' => $Country->getName($defaultLocale),
                'Currency' => $Country->getCurrency()->getCode()
            ]);

            $RegistrationEvent->register($RegistrationData);
        }
    }
}
