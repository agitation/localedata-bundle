<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter;

use Agit\CoreBundle\Exception\InternalErrorException;
use Agit\LocaleDataBundle\Adapter\Object\Timezone;

class TimezoneAdapter extends AbstractAdapter
{
    protected $CountryAdapter;

    protected $TimezoneList = null;

    public function __construct(CountryAdapter $CountryAdapter)
    {
        $this->CountryAdapter = $CountryAdapter;
    }

    public function getTimezoneList()
    {
        return $this->getList('TimezoneList');
    }

    public function hasTimezone($code)
    {
        return $this->hasListElement('TimezoneList', $code);
    }

    public function getTimezone($code)
    {
        return $this->getListElement('TimezoneList', $code);
    }

    protected function load()
    {
        if (is_null($this->TimezoneList))
        {

            $defaultLocale = $this->LocaleService->getDefaultLocale();
            $availableLocales = $this->LocaleService->getAvailableLocales();

            $this->TimezoneList = [];
            $data = $this->getMainData($this->baseLocDir, 'timeZoneNames.json');

            $allTimezones = [];
            $supportedTimezones = array_flip(\DateTimeZone::listIdentifiers());

            foreach ($data['main'][$this->baseLocDir]['dates']['timeZoneNames']['zone'] as $continent => $list)
                $allTimezones = array_merge($allTimezones, $this->getCodesFromSublist($continent, $list));

            $CountryList = $this->CountryAdapter->getCountryList();

            foreach ($allTimezones as $tzName => $tzCity)
            {
                if (isset($supportedTimezones[$tzName]))
                {
                    $DateTimezone = new \DateTimeZone($tzName);
                    $locData = $DateTimezone->getLocation();

                    if (is_array($locData) && isset($locData['country_code']) && isset($CountryList[$locData['country_code']]))
                    {
                        $this->TimezoneList[$tzName] = new Timezone($tzName, $CountryList[$locData['country_code']]);
                        $this->TimezoneList[$tzName]->addName($defaultLocale, $this->makeName($tzCity, $this->TimezoneList[$tzName]->getCountry(), $defaultLocale));
                    }
                }
            }

            // ... and fill up with translations
            foreach ($availableLocales as $loc)
            {
                if ($loc === $defaultLocale) continue;


                $locDir = $this->findLocDirForLocale($loc);
                if (!$locDir) continue;

                $locData = $this->getMainData($locDir, 'timeZoneNames.json');
                $locTimezones = [];

                foreach ($locData['main'][$locDir]['dates']['timeZoneNames']['zone'] as $locContinent => $locList)
                    $locTimezones = array_merge($locTimezones, $this->getCodesFromSublist($locContinent, $locList));

                foreach ($locTimezones as $locTzName => $locTzCity)
                    if (isset($this->TimezoneList[$locTzName]))
                        $this->TimezoneList[$locTzName]->addName($loc, $this->makeName($locTzCity, $this->TimezoneList[$locTzName]->getCountry(), $loc));

            }

        }
    }

    private function getCodesFromSublist($continent, $list)
    {
        $timezones = [];

        if (!in_array($continent, ['Etc', 'Arctic', 'Antarctica']))
        {
            foreach ($list as $city => $sublist)
            {
                if (is_array($sublist))
                {
                    if (isset($sublist['exemplarCity']))
                    {
                        $timezones["$continent/$city"] = $sublist['exemplarCity'];
                    }
                    else // some timezones have three sections, for some reason
                    {
                        foreach ($sublist as $realCity => $realSublist)
                        {
                            if (isset($realSublist['exemplarCity']))
                                $timezones["$continent/$city/$realCity"] = $realSublist['exemplarCity'];
                        }
                    }
                }
            }
        }

        return $timezones;
    }

    private function makeName($name, $Country, $locale)
    {
        return sprintf("%s, %s", $Country->getName($locale), $name);
    }
}