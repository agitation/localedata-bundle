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
    private $localeService;

    private $languageAdapter;

    public function __construct(LocaleService $localeService, LanguageAdapter $languageAdapter)
    {
        $this->localeService = $localeService;
        $this->languageAdapter = $languageAdapter;
    }

    public function onRegistration(SeedRegistrationEvent $registrationEvent)
    {
        $defaultLocale = $this->localeService->getDefaultLocale();
        $languageList = $this->languageAdapter->getLanguageList();

        foreach ($languageList as $language)
        {
            $registrationData = $registrationEvent->createContainer();

            $countryList = array_map(
                function($country){ return $country->getCode(); },
                $language->getCountryList());

            $registrationData->setData([
                'id' => $language->getCode(),
                'name' => $language->getName($defaultLocale),
                'localName' => mb_convert_case($language->getLocalName(),  MB_CASE_TITLE, 'UTF-8')
            ]);

            $registrationEvent->register($registrationData);
        }
    }
}
