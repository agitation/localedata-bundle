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
use Agit\LocaleDataBundle\Adapter\Object\Locale;

class LocaleAdapter extends AbstractAdapter
{
    protected $CountryAdapter;

    protected $LocaleList = null;

    public function __construct(CountryAdapter $CountryAdapter)
    {
        $this->CountryAdapter = $CountryAdapter;
    }

    public function getLocaleList()
    {
        return $this->getList('LocaleList');
    }

    public function hasLocale($code)
    {
        return $this->hasListElement('LocaleList', $code);
    }

    public function getLocale($code)
    {
        return $this->getListElement('LocaleList', $code);
    }

    protected function load()
    {
        if (is_null($this->LocaleList))
        {
            $defaultLocale = $this->LocaleService->getDefaultLocale();
            $availableLocales = $this->LocaleService->getAvailableLocales();

            $this->LocaleList = [];

            foreach ($availableLocales as $locale)
            {
                $lang = substr($locale, 0, 2);
                $country = substr($locale, 3, 2);
                $data = $this->getMainData($this->baseLocDir, 'languages.json');

                if (!isset($data['main'][$this->baseLocDir]['localeDisplayNames']['languages'][$lang]))
                    continue;

                $this->LocaleList[$locale] = new Locale($locale, $this->CountryAdapter->getCountry($country));
                $this->LocaleList[$locale]->addName($defaultLocale, $data['main'][$this->baseLocDir]['localeDisplayNames']['languages'][$lang]);

                foreach ($availableLocales as $loc)
                {
                    if ($loc === $defaultLocale) continue;

                    $locDir = $this->findLocDirForLocale($loc);
                    if (!$locDir) continue;

                    $locData = $this->getMainData($locDir, 'languages.json');
                    $locLang = substr($loc, 0, 2);

                    $this->LocaleList[$locale]->addName($loc, $locData['main'][$locDir]['localeDisplayNames']['languages'][$lang]);
                }
            }
        }
    }
}