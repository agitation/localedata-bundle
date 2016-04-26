<?php

namespace Agit\LocaleDataBundle\Plugin\Api\LocaledataV1\Endpoint;

use Agit\ApiBundle\Annotation\Endpoint\EntityController;
use Agit\ApiBundle\Common\AbstractEntityController;

/**
 * @EntityController(entity="AgitLocaleDataBundle:Country", endpoints={"get", "search"}, cap="")
 */
class Country extends AbstractEntityController
{
}
