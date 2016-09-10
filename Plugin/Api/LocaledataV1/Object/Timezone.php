<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Plugin\Api\LocaledataV1\Object;

use Agit\ApiBundle\Annotation\Object;
use Agit\ApiBundle\Annotation\Property;
use Agit\ApiBundle\Common\AbstractEntityObject;

/**
 * @Object\Object
 *
 * A timezone.
 */
class Timezone extends AbstractEntityObject
{
    /**
     * @Property\StringType
     *
     * The timezone identifier.
     */
    public $id;

    /**
     * @Property\StringType
     *
     * Name of the timezone, in the requested locale.
     */
    public $name;
}
