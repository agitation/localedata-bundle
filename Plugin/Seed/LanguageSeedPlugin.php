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
 * @SeedPlugin(entity="AgitLocaleDataBundle:Language", depends={"agit.intl.locale", "agit.localedata.adapter.language"})
 */
class LanguageSeedPlugin extends AbstractLocaleSeedPlugin
{
    public function getData()
    {
        $defaultLocale = $this->getService('agit.intl.locale')->getDefaultLocale();
        $languages = $this->getService('agit.localedata.adapter.language')->getLanguages();
        $data = [];

        foreach ($languages as $language)
            $data[] = [
                'id' => $language->getCode(),
                'name' => $language->getName($defaultLocale),
                'localName' => mb_convert_case($language->getLocalName(),  MB_CASE_TITLE, 'UTF-8')
            ];

        return $data;
    }
}
