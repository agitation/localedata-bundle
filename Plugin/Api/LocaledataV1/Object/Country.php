<?php

namespace Agit\LocaleDataBundle\Plugin\Api\LocaledataV1\Object;

use Agit\ApiBundle\Annotation\Object;
use Agit\ApiBundle\Annotation\Property;
use Agit\ApiBundle\Common\AbstractEntityObject;

/**
 * @Object\Object
 *
 * A country.
 */
class Country extends AbstractEntityObject
{
    /**
     * @Property\StringType
     *
     * The ISO 3166 alpha-2 country code.
     */
    protected $id;

    /**
     * @Property\StringType
     *
     * Name of the country, in the requested locale.
     */
    protected $name;
}
