<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\EventListener;

use Agit\BaseBundle\Event\TranslationCatalogEvent;
use Symfony\Component\Filesystem\Filesystem;
use Agit\BaseBundle\Service\LocaleService;
use Agit\LocaleDataBundle\Adapter\CountryAdapter;
use Agit\LocaleDataBundle\Adapter\CurrencyAdapter;
use Agit\LocaleDataBundle\Adapter\LanguageAdapter;
use Agit\LocaleDataBundle\Adapter\TimeAdapter;
use Agit\LocaleDataBundle\Adapter\TimezoneAdapter;

class CldrCatalogListener
{
    private $filesystem;

    private $localeService;

    private $countryAdapter;

    private $currencyAdapter;

    private $languageAdapter;

    private $timezoneAdapter;

    private $timeAdapter;

    public function __construct
    (
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

    public function onRegistration(TranslationCatalogEvent $event)
    {
        $defaultLocale = $this->localeService->getDefaultLocale();
        $locales = $this->localeService->getAvailableLocales();
        $catalogs = [];

        $lists = [];
        $lists['currency'] = $this->currencyAdapter->getCurrencies();
        $lists['country'] = $this->countryAdapter->getCountries();
        $lists['timezone'] = $this->timezoneAdapter->getTimezones();
        $lists['month'] = $this->timeAdapter->getMonths();
        $lists['weekday'] = $this->timeAdapter->getWeekdays();
        $lists['language'] = $this->languageAdapter->getLanguages();

        foreach ($locales as $locale)
        {
            $catalog = '';

            foreach ($lists as $type => $list)
            {
                foreach ($list as $id => $elem)
                {
                    $catalog .= "\n";
                    $catalog .= "#: localedata:$type:$id\n";

                    if (in_array($type, ['currency', 'country', 'timezone', 'language']))
                        $catalog .= "msgctxt \"$type\"\n";

                    $msgId = addcslashes($elem->getName($defaultLocale), '"');

                    $catalog .= sprintf("msgid \"%s\"\n", $msgId);
                    $catalog .= sprintf("msgstr \"%s\"\n", addcslashes($elem->getName($locale), '"'));

                    if (in_array($type, ['weekday', 'month']))
                    {
                        $abbrMsgId = addcslashes($elem->getAbbr($defaultLocale), '"');

                        // avoid duplicate messages where long and short form are identical (May/May)
                        if ($msgId !== $abbrMsgId)
                        {
                            $catalog .= "\n";
                            $catalog .= "#: localedata:$type:$id\n";
                            $catalog .= sprintf("msgid \"%s\"\n", $abbrMsgId);
                            $catalog .= sprintf("msgstr \"%s\"\n", addcslashes($elem->getAbbr($locale), '"'));
                        }
                    }
                }
            }

            $catalogs[$locale] = $catalog;
        }

        // now, after fully successful generation, create and register files

        $cachePath = $event->getCacheBasePath() . md5(__CLASS__);
        $this->filesystem->mkdir($cachePath);

        foreach ($catalogs as $locale => $catalog)
        {
            $filePath = "$cachePath/cldr.$locale.po";
            $this->filesystem->dumpFile($filePath, $catalog);
            $event->registerCatalogFile($locale, $filePath);
        }
    }
}
