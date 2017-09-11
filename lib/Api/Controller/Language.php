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
use Agit\ApiBundle\Annotation\Endpoint\Endpoint;
use Agit\ApiBundle\Annotation\Endpoint\Security;

/**
 * @Controller(namespace="localedata.v1")
 * @Depends({"@agit.localedata.provider"})
 */
class Language extends AbstractLocaledataController
{
    /**
     * @Endpoint(request="common.v1/ScalarNull", response="Language[]")
     * @Security(capability="", allowCrossOrigin=true)
     */
    public function search()
    {
        return $this->createSearchResult('Language');
    }
}
