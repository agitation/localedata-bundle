<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Plugin\Seed;

use Agit\BaseBundle\Pluggable\Seed\SeedPlugin;

/**
 * @SeedPlugin(entity="AgitLocaleDataBundle:Country", depends={"@agit.intl.locale", "@agit.localedata.adapter.country"})
 */
class CountrySeedPlugin extends AbstractLocaleSeedPlugin
{
    public function getData()
    {
        $defaultLocale = $this->getService('agit.intl.locale')->getDefaultLocale();
        $countries = $this->getService('agit.localedata.adapter.country')->getCountries();
        $data = [];

        foreach ($countries as $country)
            $data[] = [
                'id' => $country->getCode(),
                'code' => $country->getLongCode(),
                'phone' => $country->getPhone(),
                'name' => $country->getName($defaultLocale),
                'currency' => $country->getCurrency()->getCode()
            ];

        return $data;
    }
}
