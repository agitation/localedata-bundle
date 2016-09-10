<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Plugin\Api\LocaledataV1\Endpoint;

use Agit\ApiBundle\Annotation\Endpoint\EntityController;
use Agit\ApiBundle\Common\AbstractEntityController;

/**
 * @EntityController(entity="AgitLocaleDataBundle:Timezone", endpoints={"get", "search"}, cap="")
 */
class Currency extends AbstractEntityController
{
}
