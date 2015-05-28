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
use Agit\LocaleDataBundle\Adapter\LocaleAdapter;

class LocaleSeedData
{
    private $LocaleService;

    private $LocaleAdapter;

    public function __construct(LocaleService $LocaleService, LocaleAdapter $LocaleAdapter)
    {
        $this->LocaleService = $LocaleService;
        $this->LocaleAdapter = $LocaleAdapter;
    }

    public function onRegistration(SeedRegistrationEvent $RegistrationEvent)
    {
        $defaultLocale = $this->LocaleService->getDefaultLocale();
        $LocaleList = $this->LocaleAdapter->getLocaleList();

        foreach ($LocaleList as $Locale)
        {
            $RegistrationData = $RegistrationEvent->createContainer();

            $RegistrationData->setData([
                'id' => $Locale->getCode(),
                'name' => mb_convert_case($Locale->getName($defaultLocale),  MB_CASE_TITLE, 'UTF-8'),
                'localName' => mb_convert_case($Locale->getLocalName(),  MB_CASE_TITLE, 'UTF-8'),
                'Country' => $Locale->getCountry()->getCode()
            ]);

            $RegistrationEvent->register($RegistrationData);
        }
    }
}