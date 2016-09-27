<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Api\Controller;

use Agit\ApiBundle\Annotation\Controller\Controller;
use Agit\ApiBundle\Annotation\Depends;
use Agit\ApiBundle\Annotation\Endpoint\Endpoint;
use Agit\ApiBundle\Annotation\Endpoint\Security;

/**
 * @Controller(namespace="localedata.v1")
 * @Depends({"@agit.localedata.provider"})
 */
class Currency extends AbstractLocaledataController
{
    /**
     * @Endpoint(request="common.v1/Null", response="Currency[]")
     * @Security(capability="", allowCrossOrigin=true)
     */
    public function search()
    {
        return $this->createSearchResult("Currency");
    }
}
