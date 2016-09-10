<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

/**
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 *
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\EventListener;

use Agit\IntlBundle\Event\TranslationsEvent;
use Agit\IntlBundle\Service\LocaleService;
use Agit\LocaleDataBundle\Adapter\CountryAdapter;
use Agit\LocaleDataBundle\Adapter\CurrencyAdapter;
use Agit\LocaleDataBundle\Adapter\LanguageAdapter;
use Agit\LocaleDataBundle\Adapter\TimeAdapter;
use Agit\LocaleDataBundle\Adapter\TimezoneAdapter;
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

    private $timeAdapter;

    public function __construct(
        Filesystem $filesystem,
        LocaleService $localeService,
        CurrencyAdapter $currencyAdapter,
        CountryAdapter $countryAdapter,
        LanguageAdapter $languageAdapter,
        TimeAdapter $timeAdapter,
        TimezoneAdapter $timezoneAdapter
    ) {
        $this->filesystem = $filesystem;
        $this->localeService = $localeService;
        $this->currencyAdapter = $currencyAdapter;
        $this->countryAdapter = $countryAdapter;
        $this->languageAdapter = $languageAdapter;
        $this->timeAdapter = $timeAdapter;
        $this->timezoneAdapter = $timezoneAdapter;
    }

    public function onRegistration(TranslationsEvent $event)
    {
        $defaultLocale = $this->localeService->getDefaultLocale();
        $locales = $this->localeService->getAvailableLocales();
        $catalogs = [];

        $lists = [];
        $lists["currency"] = $this->currencyAdapter->getCurrencies();
        $lists["country"] = $this->countryAdapter->getCountries();
        $lists["timezone"] = $this->timezoneAdapter->getTimezones();
        $lists["month"] = $this->timeAdapter->getMonths();
        $lists["weekday"] = $this->timeAdapter->getWeekdays();
        $lists["language"] = $this->languageAdapter->getLanguages();

        foreach ($locales as $locale) {
            $catalog = "";

            foreach ($lists as $type => $list) {
                foreach ($list as $id => $elem) {
                    $context = (in_array($type, ["currency", "country", "timezone", "language"])) ? $type : "";

                    $translation = new Translation($context, $elem->getName($defaultLocale));
                    $translation->setTranslation($elem->getName($locale));
                    $translation->addReference("localedata:$type:$id");
                    $event->addTranslation($locale, $translation);

                    if (in_array($type, ["weekday", "month"])) {
                        $translation = new Translation("", $elem->getAbbr($defaultLocale));
                        $translation->setTranslation($elem->getAbbr($locale));
                        $translation->addReference("localedata:$type:$id");
                        $event->addTranslation($locale, $translation);
                    }
                }
            }
        }
    }
}
