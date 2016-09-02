<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter;

use Agit\BaseBundle\Exception\InternalErrorException;

class CountryCurrencyAdapter extends AbstractAdapter
{
    // manually blacklisted
    private $currencyBlacklist = ['USN'];
    private $countryBlacklist = ['ZZ'];

    public function getCountryCurrencyMap()
    {
        $currencyMappings = $this->getSupplementalData('currencyData.json');
        $results = [];

        foreach ($currencyMappings['supplemental']['currencyData']['region'] as $country => $list)
        {
            if (strlen($country) !== 2 || is_numeric($country) || in_array($country, $this->countryBlacklist)) continue;

            foreach ($list as $sublist)
            {
                foreach ($sublist as $currencyCode => $details)
                {
                    if (!isset($details['_to']) && (!isset($details['_tender']) || $details['_tender'] === "true") && !in_array($currencyCode, $this->currencyBlacklist))
                    {
                        $results[$country] = $currencyCode;
                        continue 3;
                    }
                }
            }
        }

        return $results;
    }

    protected function load() {}
}