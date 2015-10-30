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
use Agit\LocaleDataBundle\Adapter\Object\Month;
use Agit\LocaleDataBundle\Adapter\Object\Weekday;

class TimeAdapter extends AbstractAdapter
{
    protected $monthList = null;

    protected $weekdayList = null;

    public function getMonthList()
    {
        return $this->getList('monthList');
    }

    public function hasMonth($code)
    {
        return $this->hasListElement('monthList', $code);
    }

    public function getMonth($code)
    {
        return $this->getListElement('monthList', $code);
    }

    public function getWeekdayList()
    {
        return $this->getList('weekdayList');
    }

    public function hasWeekday($code)
    {
        return $this->hasListElement('weekdayList', $code);
    }

    public function getWeekday($code)
    {
        return $this->getListElement('weekdayList', $code);
    }

    protected function load()
    {
        if (is_null($this->monthList))
        {
            $this->monthList = [];
            $this->weekdayList = [];

            $defaultLocale = $this->localeService->getDefaultLocale();
            $availableLocales = $this->localeService->getAvailableLocales();
            $data = $this->getMainData($this->baseLocDir, 'ca-gregorian.json');
            $dataNode = $data['main'][$this->baseLocDir]['dates']['calendars']['gregorian'];

            foreach ($dataNode['months']['stand-alone']['wide'] as $id => $name)
            {
                $this->monthList[$id] = new Month($id);
                $this->monthList[$id]->addName($defaultLocale, $name, $dataNode['months']['stand-alone']['abbreviated'][$id]);
            }

            foreach ($dataNode['days']['stand-alone']['wide'] as $id => $name)
            {
                $this->weekdayList[$id] = new Weekday($id);
                $this->weekdayList[$id]->addName($defaultLocale, $name, $dataNode['days']['stand-alone']['abbreviated'][$id]);
            }

            // ... and fill up with translations
            foreach ($availableLocales as $loc)
            {
                if ($loc === $defaultLocale) continue;

                $locDir = $this->findLocDirForLocale($loc);
                if (!$locDir) continue;

                $locData = $this->getMainData($locDir, 'ca-gregorian.json');
                $locDataNode = $locData['main'][$locDir]['dates']['calendars']['gregorian'];

                foreach ($locDataNode['months']['stand-alone']['wide'] as $id => $name)
                    $this->monthList[$id]->addName($loc, $name, $locDataNode['months']['stand-alone']['abbreviated'][$id]);

                foreach ($locDataNode['days']['stand-alone']['wide'] as $id => $name)
                    $this->weekdayList[$id]->addName($loc, $name, $locDataNode['days']['stand-alone']['abbreviated'][$id]);
            }
        }
    }
}
