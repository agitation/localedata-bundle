<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter;

class CountryCurrencyAdapter extends AbstractAdapter
{
    // manually blacklisted
    private $currencyBlacklist = ['USN'];
    private $countryBlacklist = ['ZZ'];

    public function getCountryCurrencyMap()
    {
        $currencyMappings = $this->getSupplementalData('currencyData.json');
        $results = [];

        foreach ($currencyMappings['supplemental']['currencyData']['region'] as $country => $list) {
            if (strlen($country) !== 2 || is_numeric($country) || in_array($country, $this->countryBlacklist)) {
                continue;
            }

            foreach ($list as $sublist) {
                foreach ($sublist as $currencyCode => $details) {
                    if (! isset($details['_to']) && (! isset($details['_tender']) || $details['_tender'] === "true") && ! in_array($currencyCode, $this->currencyBlacklist)) {
                        $results[$country] = $currencyCode;
                        continue 3;
                    }
                }
            }
        }

        return $results;
    }

    protected function load()
    {
    }
}
