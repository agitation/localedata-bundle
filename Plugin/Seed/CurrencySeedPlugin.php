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
 * @SeedPlugin(entity="AgitLocaleDataBundle:Currency", depends={"agit.intl.locale", "agit.localedata.adapter.currency"})
 */
class CurrencySeedPlugin extends AbstractLocaleSeedPlugin
{
    public function getData()
    {
        $defaultLocale = $this->getService('agit.intl.locale')->getDefaultLocale();
        $currencies = $this->getService('agit.localedata.adapter.currency')->getCurrencies();
        $data = [];

        foreach ($currencies as $currency)
            $data[] = [
                'id' => $currency->getCode(),
                'name' => $currency->getName($defaultLocale)
            ];

        return $data;
    }
}
