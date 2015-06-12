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
use Agit\LocaleDataBundle\Adapter\LanguageAdapter;

class LanguageSeedData
{
    private $LocaleService;

    private $LanguageAdapter;

    public function __construct(LocaleService $LocaleService, LanguageAdapter $LanguageAdapter)
    {
        $this->LocaleService = $LocaleService;
        $this->LanguageAdapter = $LanguageAdapter;
    }

    public function onRegistration(SeedRegistrationEvent $RegistrationEvent)
    {
        $defaultLocale = $this->LocaleService->getDefaultLocale();
        $LanguageList = $this->LanguageAdapter->getLanguageList();

        foreach ($LanguageList as $Language)
        {
            $RegistrationData = $RegistrationEvent->createContainer();

            $countryList = array_map(
                function($Country){ return $Country->getCode(); },
                $Language->getCountryList());

            $RegistrationData->setData([
                'id' => $Language->getCode(),
                'name' => $Language->getName($defaultLocale),
                'localName' => mb_convert_case($Language->getLocalName(),  MB_CASE_TITLE, 'UTF-8')
            ]);

            $RegistrationEvent->register($RegistrationData);
        }
    }
}
