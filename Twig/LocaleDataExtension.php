<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Twig;

use Agit\IntlBundle\Service\LocaleService;
use Agit\LocaleDataBundle\Service\ProviderService;

class LocaleDataExtension extends \Twig_Extension
{
    private $ProviderService;

    private $LocaleService;

    public function __construct(ProviderService $ProviderService, LocaleService $LocaleService)
    {
        $this->ProviderService = $ProviderService;
        $this->LocaleService = $LocaleService;
    }

    public function getFunctions()
    {
        return [
            'getCountries' => new \Twig_Function_Method($this, 'getCountries'),
            'getCurrencies' => new \Twig_Function_Method($this, 'getCurrencies'),
            'getLanguages' => new \Twig_Function_Method($this, 'getLanguages'),
            'getTimezones' => new \Twig_Function_Method($this, 'getTimezones')
        ];
    }

    public function getName()
    {
        return 'agit.localedata';
    }

    public function getCountries(array $list = null)
    {
        return $this->getList(__FUNCTION__, $list);
    }

    public function getCurrencies(array $list = null)
    {
        return $this->getList(__FUNCTION__, $list);
    }

    public function getLanguages(array $list = null)
    {
        return $this->getList(__FUNCTION__, $list);
    }

    public function getTimezones(array $list = null)
    {
        return $this->getList(__FUNCTION__, $list);
    }

    private function getList($method, array $list = null)
    {
        $results = [];

        foreach ($this->ProviderService->$method($list) as $Entity)
            $results[$Entity->getId()] = $Entity->getName();

        if (class_exists('Collator'))
        {
            $Collator = new \Collator($this->LocaleService->getLocale());
            uasort($results, [$Collator, 'compare']);
        }

        return $results;
    }
}
