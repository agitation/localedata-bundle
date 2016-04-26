<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Plugin\Seed;

use Agit\PluggableBundle\Strategy\Seed\SeedPlugin;

/**
 * @SeedPlugin(entity="AgitLocaleDataBundle:Timezone", depends={"agit.intl.locale", "agit.localedata.adapter.timezone"})
 */
class TimezoneSeedPlugin extends AbstractLocaleSeedPlugin
{
    public function getData()
    {
        $defaultLocale = $this->getService('agit.intl.locale')->getDefaultLocale();
        $timezones = $this->getService('agit.localedata.adapter.timezone')->getTimezones();
        $data = [];

        foreach ($timezones as $timezone)
            $data[] = [
                'id' => $timezone->getCode(),
                'name' => $timezone->getName($defaultLocale),
                'country' => $timezone->getCountry()->getCode()
            ];

        return $data;
    }
}
