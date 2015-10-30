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
use Agit\LocaleDataBundle\Adapter\CurrencyAdapter;

class CurrencySeedData
{
    private $localeService;

    private $currencyAdapter;

    public function __construct(LocaleService $localeService, CurrencyAdapter $currencyAdapter)
    {
        $this->localeService = $localeService;
        $this->currencyAdapter = $currencyAdapter;
    }

    public function onRegistration(SeedRegistrationEvent $registrationEvent)
    {
        $defaultLocale = $this->localeService->getDefaultLocale();
        $currencyList = $this->currencyAdapter->getCurrencyList();

        foreach ($currencyList as $currency)
        {
            $registrationData = $registrationEvent->createContainer();

            $registrationData->setData([
                'id' => $currency->getCode(),
                'name' => $currency->getName($defaultLocale)
            ]);

            $registrationEvent->register($registrationData);
        }
    }
}
