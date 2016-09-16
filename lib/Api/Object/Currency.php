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
 * A currency.
 */
class Currency extends AbstractEntityObject
{
    /**
     * @Property\StringType
     *
     * The ISO 4217 currency code.
     */
    protected $id;

    /**
     * @Property\StringType
     *
     * Name of the currency, in the requested locale.
     */
    protected $name;
}
