<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter;

use Agit\CommonBundle\Exception\InternalErrorException;
use Agit\LocaleDataBundle\Adapter\Object\Timezone;

class TimezoneAdapter extends AbstractAdapter
{
    protected $countryAdapter;

    protected $timezoneList = null;

    public function __construct(CountryAdapter $countryAdapter)
    {
        $this->countryAdapter = $countryAdapter;
    }

    public function getTimezoneList()
    {
        return $this->getList('timezoneList');
    }

    public function hasTimezone($code)
    {
        return $this->hasListElement('timezoneList', $code);
    }

    public function getTimezone($code)
    {
        return $this->getListElement('timezoneList', $code);
    }

    protected function load()
    {
        if (is_null($this->timezoneList))
        {

            $defaultLocale = $this->localeService->getDefaultLocale();
            $availableLocales = $this->localeService->getAvailableLocales();

            $this->timezoneList = [];
            $data = $this->getMainData($this->baseLocDir, 'timeZoneNames.json');

            $allTimezones = [];
            $supportedTimezones = array_flip(\DateTimeZone::listIdentifiers());

            foreach ($data['main'][$this->baseLocDir]['dates']['timeZoneNames']['zone'] as $continent => $list)
                $allTimezones = array_merge($allTimezones, $this->getCodesFromSublist($continent, $list));

            $countryList = $this->countryAdapter->getCountryList();

            foreach ($allTimezones as $tzName => $tzCity)
            {
                if (isset($supportedTimezones[$tzName]))
                {
                    $dateTimezone = new \DateTimeZone($tzName);
                    $locData = $dateTimezone->getLocation();

                    if (is_array($locData) && isset($locData['country_code']) && isset($countryList[$locData['country_code']]))
                    {
                        $this->timezoneList[$tzName] = new Timezone($tzName, $countryList[$locData['country_code']]);
                        $this->timezoneList[$tzName]->addName($defaultLocale, $this->makeName($tzCity, $this->timezoneList[$tzName]->getCountry(), $defaultLocale));
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
                    if (isset($this->timezoneList[$locTzName]))
                        $this->timezoneList[$locTzName]->addName($loc, $this->makeName($locTzCity, $this->timezoneList[$locTzName]->getCountry(), $loc));

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

    private function makeName($name, $country, $locale)
    {
        return sprintf("%s, %s", $country->getName($locale), $name);
    }
}
