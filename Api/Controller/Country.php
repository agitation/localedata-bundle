<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Api\Controller;

use Agit\ApiBundle\Annotation\Controller\EntityController;
use Agit\ApiBundle\Api\Controller\EntityGetTrait;
use Agit\ApiBundle\Api\Controller\EntitySearchTrait;
use Agit\ApiBundle\Api\Controller\AbstractEntityController;

/**
 * @EntityController(namespace="localedata.v1", entity="AgitLocaleDataBundle:Country", cap="")
 */
class Country extends AbstractEntityController
{
    use EntityGetTrait;
    use EntitySearchTrait;
}
