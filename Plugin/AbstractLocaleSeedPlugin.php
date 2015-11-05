<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Plugin;

use Agit\PluggableBundle\Strategy\Seed\SeedPluginInterface;
use Agit\PluggableBundle\Strategy\ServiceAwarePluginInterface;
use Agit\PluggableBundle\Strategy\ServiceAwarePluginTrait;
use Agit\PluggableBundle\Strategy\Seed\SeedEntry;

abstract class AbstractLocaleSeedPlugin implements SeedPluginInterface, ServiceAwarePluginInterface
{
    use ServiceAwarePluginTrait;

    private $data = [];

    public function load()
    {
        foreach ($this->getData() as $entry)
        {
            $seedEntry = new SeedEntry();
            $seedEntry->setDoUpdate(true);
            $seedEntry->setData($entry);
            $this->data[] = $seedEntry;
        }
    }

    public function nextSeedEntry()
    {
        return array_pop($this->data);
    }

    abstract protected function getData();
}
