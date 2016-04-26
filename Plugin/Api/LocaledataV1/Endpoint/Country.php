<?php

namespace Agit\LocaleDataBundle\Plugin\Api\LocaledataV1\Endpoint;

use Agit\ApiBundle\Annotation\Endpoint\EntityEndpointClass;
use Agit\ApiBundle\Common\AbstractEntityEndpointClass;

/**
 * @EntityEndpointClass(entity="AgitLocaleDataBundle:Country", endpoints={"get", "search"}, cap="")
 */
class Country extends AbstractEntityEndpointClass
{
}
