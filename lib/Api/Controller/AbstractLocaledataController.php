<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Api\Controller;

use Agit\ApiBundle\Api\Controller\AbstractController;
use Agit\LocaleDataBundle\Service\ProviderService;

abstract class AbstractLocaledataController extends AbstractController
{
    protected $provider;

    public function __construct(ProviderService $provider)
    {
        $this->provider = $provider;
    }

    protected function createSearchResult($entityName)
    {
        $entities = $this->provider->getList($entityName);
        $result = [];

        foreach ($entities as $entity) {
            $result[] = $this->createObject($entityName, $entity);
        }

        return $result;
    }
}
