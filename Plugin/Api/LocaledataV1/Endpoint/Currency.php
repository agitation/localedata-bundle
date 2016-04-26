<?php

namespace Agit\LocaleDataBundle\Plugin\Api\LocaledataV1\Endpoint;

use Agit\ApiBundle\Annotation\Endpoint\EntityEndpointClass;
use Agit\ApiBundle\Common\AbstractEntityEndpointClass;

/**
 * @EntityEndpointClass(entity="AgitLocaleDataBundle:Timezone", endpoints={"get", "search"}, cap="")
 */
class Currency extends AbstractEntityEndpointClass
{
}
