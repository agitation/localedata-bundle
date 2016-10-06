<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Api\Object;

use Agit\ApiBundle\Annotation\Object;
use Agit\ApiBundle\Annotation\Property;
use Agit\ApiBundle\Api\Object\AbstractEntityObject;

/**
 * @Object\Object(namespace="localedata.v1")
 *
 * A timezone.
 */
class Timezone extends AbstractEntityObject
{
    /**
     * @Property\Name("ID")
     * @Property\StringType
     *
     * The timezone identifier.
     */
    public $id;

    /**
     * @Property\Name("Name")
     * @Property\StringType
     *
     * Name of the timezone, in the requested locale.
     */
    public $name;
}
