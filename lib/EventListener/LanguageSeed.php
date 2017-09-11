<?php
declare(strict_types=1);
/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\EventListener;

use Agit\CldrBundle\Adapter\LanguageAdapter;
use Agit\IntlBundle\Service\LocaleService;
use Agit\SeedBundle\Event\SeedEvent;

class LanguageSeed
{
    private $localeService;

    private $languageAdapter;

    public function __construct(LocaleService $localeService, LanguageAdapter $languageAdapter)
    {
        $this->localeService = $localeService;
        $this->languageAdapter = $languageAdapter;
    }

    public function registerSeed(SeedEvent $event)
    {
        $defaultLocale = $this->localeService->getDefaultLocale();

        $languages = $this->languageAdapter->getLanguages(
            $defaultLocale,
            $this->localeService->getAvailableLocales()
        );

        foreach ($languages as $language)
        {
            $event->addSeedEntry('AgitLocaleDataBundle:Language', [
                'id' => $language->getCode(),
                'name' => $language->getName($defaultLocale),
                'localName' => mb_convert_case($language->getLocalName(), MB_CASE_TITLE, 'UTF-8')
            ]);
        }
    }
}
