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
    private $localeService;

    private $countryAdapter;

    public function __construct(LocaleService $localeService, CountryAdapter $countryAdapter)
    {
        $this->localeService = $localeService;
        $this->countryAdapter = $countryAdapter;
    }

    public function onRegistration(SeedRegistrationEvent $registrationEvent)
    {
        $defaultLocale = $this->localeService->getDefaultLocale();
        $countryList = $this->countryAdapter->getCountryList();

        foreach ($countryList as $country)
        {
            $registrationData = $registrationEvent->createContainer();

            $registrationData->setData([
                'id' => $country->getCode(),
                'phone' => $country->getPhone(),
                'name' => $country->getName($defaultLocale),
                'currency' => $country->getCurrency()->getCode()
            ]);

            $registrationEvent->register($registrationData);
        }
    }
}
