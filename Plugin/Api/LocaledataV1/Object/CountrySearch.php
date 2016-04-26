<?php

namespace Agit\LocaleDataBundle\Plugin\Api\LocaledataV1\Object;

use Agit\ApiBundle\Annotation\Object;
use Agit\ApiBundle\Annotation\Property;
use Agit\ApiBundle\Common\AbstractRequestObject;

/**
 * @Object\Object
 *
 * Country search request object. Actually, this is just a dummy object, as
 * the Country.search method doesn’t take any methods anyway.
 */
class CountrySearch extends AbstractRequestObject
{
}
