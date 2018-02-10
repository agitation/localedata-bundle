<?php
declare(strict_types=1);
/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Api\Controller;

use Agit\ApiBundle\Annotation\Controller\Controller;
use Agit\ApiBundle\Annotation\Depends;
use Agit\ApiBundle\Annotation\Endpoint;

/**
 * @Controller(namespace="common.v1")
 * @Depends({"@agit.localedata.provider"})
 */
class Currency extends AbstractLocaledataController
{
    /**
     * @Endpoint\Endpoint(request="common.v1/ScalarNull", response="Currency[]")
     * @Endpoint\Security(capability="")
     * @Endpoint\CrossOrigin(allow="all")
     */
    public function search()
    {
        return $this->createSearchResult('Currency');
    }
}
