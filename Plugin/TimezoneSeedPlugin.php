<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Plugin;

use Agit\PluggableBundle\Strategy\Seed\SeedPlugin;
use Agit\PluggableBundle\Strategy\Seed\SeedEntry;

/**
 * @SeedPlugin(entity="AgitLocaleDataBundle:Timezone", depends={"agit.intl.locale", "agit.localedata.adapter.timezone"})
 */
class TimezoneSeedPlugin extends AbstractLocaleSeedPlugin
{
    public function getData()
    {
        $defaultLocale = $this->getService('agit.intl.locale')->getDefaultLocale();
        $timezoneList = $this->getService('agit.localedata.adapter.timezone')->getTimezoneList();
        $data = [];

        foreach ($timezoneList as $timezone)
        {
            $seedEntry = new SeedEntry();

            $seedEntry->setData([
                'id' => $timezone->getCode(),
                'name' => $timezone->getName($defaultLocale),
                'country' => $timezone->getCountry()->getCode()
            ]);

            $data[] = $seedEntry;
        }

        return $data;
    }
}
