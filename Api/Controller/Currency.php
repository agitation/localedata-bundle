<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Api\Controller;

use Agit\ApiBundle\Annotation\Controller\EntityController;
use Agit\ApiBundle\Api\Controller\AbstractEntityController;

/**
 * @EntityController(namespace="localedata.v1", entity="AgitLocaleDataBundle:Timezone", endpoints={"get", "search"}, cap="")
 */
class Currency extends AbstractEntityController
{
}
