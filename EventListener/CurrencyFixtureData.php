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
use Agit\CoreBundle\Pluggable\Strategy\Fixture\FixtureRegistrationEvent;
use Agit\IntlBundle\Service\LocaleService;
use Agit\LocaleDataBundle\Adapter\CurrencyAdapter;

class CurrencyFixtureData
{
    private $LocaleService;

    private $CurrencyAdapter;

    public function __construct(LocaleService $LocaleService, CurrencyAdapter $CurrencyAdapter)
    {
        $this->LocaleService = $LocaleService;
        $this->CurrencyAdapter = $CurrencyAdapter;
    }

    public function onRegistration(FixtureRegistrationEvent $RegistrationEvent)
    {
        $defaultLocale = $this->LocaleService->getDefaultLocale();
        $CurrencyList = $this->CurrencyAdapter->getCurrencyList();

        foreach ($CurrencyList as $Currency)
        {
            $RegistrationData = $RegistrationEvent->createContainer();

            $RegistrationData->setData([
                'id' => $Currency->getCode(),
                'name' => $Currency->getName($defaultLocale)
            ]);

            $RegistrationEvent->register($RegistrationData);
        }
    }
}
