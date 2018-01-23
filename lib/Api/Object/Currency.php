<?php
declare(strict_types=1);
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
     * @Property\Name("ID")
     * @Property\StringType
     *
     * The ISO 4217 currency code.
     */
    protected $id;

    /**
     * @Property\Name("Name")
     * @Property\StringType
     *
     * Name of the currency, in the requested locale.
     */
    protected $name;

    /**
     * @Property\Name("Symbol")
     * @Property\StringType
     *
     * Symbol to be used with a value expression of this currency.
     */
    protected $symbol;

    /**
     * @Property\Name("Digits")
     * @Property\IntegerType
     *
     * Number of fraction digits
     */
    protected $digits;
}
