<?php

namespace Agit\LocaleDataBundle\Plugin\Api\LocaledataV1\Object;

use Agit\ApiBundle\Annotation\Object;
use Agit\ApiBundle\Annotation\Property;
use Agit\ApiBundle\Common\AbstractRequestObject;

/**
 * @Object\Object
 *
 * Currency search request object. Actually, this is just a dummy object, as
 * the Currency.search method doesn’t take any methods anyway.
 */
class CurrencySearch extends AbstractRequestObject
{
}
