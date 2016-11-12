<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\EventListener;

use Agit\CldrBundle\Adapter\CountryAdapter;
use Agit\CldrBundle\Adapter\CurrencyAdapter;
use Agit\CldrBundle\Adapter\LanguageAdapter;
use Agit\CldrBundle\Adapter\TimezoneAdapter;
use Agit\IntlBundle\Event\TranslationsEvent;
use Agit\IntlBundle\Service\LocaleService;
use Gettext\Translation;
use Symfony\Component\Filesystem\Filesystem;

class CldrCatalogListener
{
    private $filesystem;

    private $localeService;

    private $countryAdapter;

    private $currencyAdapter;

    private $languageAdapter;

    private $timezoneAdapter;

    public function __construct(
        Filesystem $filesystem,
        LocaleService $localeService,
        CurrencyAdapter $currencyAdapter,
        CountryAdapter $countryAdapter,
        LanguageAdapter $languageAdapter,
        TimezoneAdapter $timezoneAdapter
    ) {
        $this->filesystem = $filesystem;
        $this->localeService = $localeService;
        $this->currencyAdapter = $currencyAdapter;
        $this->countryAdapter = $countryAdapter;
        $this->languageAdapter = $languageAdapter;
        $this->timezoneAdapter = $timezoneAdapter;
    }

    public function onRegistration(TranslationsEvent $event)
    {
        $defaultLocale = $this->localeService->getDefaultLocale();
        $locales = $this->localeService->getAvailableLocales();

        $lists = [];
        $lists["currency"] = $this->currencyAdapter->getCurrencies($defaultLocale, $locales);
        $lists["country"] = $this->countryAdapter->getCountries($defaultLocale, $locales);
        $lists["timezone"] = $this->timezoneAdapter->getTimezones($defaultLocale, $locales);
        $lists["language"] = $this->languageAdapter->getLanguages($defaultLocale, $locales);

        foreach ($locales as $locale) {
            foreach ($lists as $type => $list) {
                foreach ($list as $id => $elem) {
                    $translation = new Translation($type, $elem->getName($defaultLocale));
                    $translation->setTranslation($elem->getName($locale));
                    $translation->addReference("localedata:$type:$id");
                    $event->addTranslation($locale, $translation);
                }
            }
        }
    }
}
