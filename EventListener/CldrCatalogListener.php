<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\EventListener;

use Agit\IntlBundle\Event\CatalogRegistrationEvent;
use Agit\IntlBundle\EventListener\AbstractTemporaryFilesListener;
use Symfony\Component\Filesystem\Filesystem;
use Agit\IntlBundle\Service\LocaleService;
use Agit\LocaleDataBundle\Adapter\CountryAdapter;
use Agit\LocaleDataBundle\Adapter\CurrencyAdapter;
use Agit\LocaleDataBundle\Adapter\LocaleAdapter;
use Agit\LocaleDataBundle\Adapter\TimeAdapter;
use Agit\LocaleDataBundle\Adapter\TimezoneAdapter;

class CldrCatalogListener extends AbstractTemporaryFilesListener
{
    private $Filesystem;

    private $LocaleService;

    private $CountryAdapter;

    private $CurrencyAdapter;

    private $LocaleAdapter;

    private $TimezoneAdapter;

    private $TimeAdapter;

    public function __construct
    (
        Filesystem $Filesystem,
        LocaleService $LocaleService,
        CurrencyAdapter $CurrencyAdapter,
        CountryAdapter $CountryAdapter,
        LocaleAdapter $LocaleAdapter,
        TimeAdapter $TimeAdapter,
        TimezoneAdapter $TimezoneAdapter
    ) {
        $this->Filesystem = $Filesystem;
        $this->LocaleService = $LocaleService;
        $this->CurrencyAdapter = $CurrencyAdapter;
        $this->CountryAdapter = $CountryAdapter;
        $this->LocaleAdapter = $LocaleAdapter;
        $this->TimeAdapter = $TimeAdapter;
        $this->TimezoneAdapter = $TimezoneAdapter;
    }

    public function onRegistration(CatalogRegistrationEvent $RegistrationEvent)
    {
        $defaultLocale = $this->LocaleService->getDefaultLocale();
        $localeList = $this->LocaleService->getAvailableLocales();
        $catalogs = [];

        $lists = [];
        $lists['currency'] = $this->CurrencyAdapter->getCurrencyList();
        $lists['country'] = $this->CountryAdapter->getCountryList();
        $lists['timezone'] = $this->TimezoneAdapter->getTimezoneList();
        $lists['month'] = $this->TimeAdapter->getMonthList();
        $lists['weekday'] = $this->TimeAdapter->getWeekdayList();
        $lists['language'] = $this->LocaleAdapter->getLocaleList();

        foreach ($localeList as $locale)
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

                    $catalog .= sprintf("msgid \"%s\"\n", addcslashes($elem->getName($defaultLocale), '"'));
                    $catalog .= sprintf("msgstr \"%s\"\n", addcslashes($elem->getName($locale), '"'));
                }
            }

            $catalogs[$locale] = $catalog;
        }

        // now, after fully successful generation, create and register files

        $tmpPath = $this->getCachePath();

        if (!$this->Filesystem->exists($tmpPath))
            $this->Filesystem->mkdir($tmpPath);

        foreach ($catalogs as $locale => $catalog)
        {
            $filePath = "$tmpPath/cldr.$locale.po";
            $this->Filesystem->dumpFile($filePath, $catalog);
            $RegistrationEvent->registerCatalogFile($locale, $filePath);
        }
    }
}
