<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Plugin\Api\LocaledataV1\Object;

use Agit\ApiBundle\Annotation\Object;
use Agit\ApiBundle\Common\AbstractRequestObject;

/**
 * @Object\Object
 *
 * Timezones search request object. Actually, this is just a dummy object, as
 * the Timezone.search method doesn’t take any methods anyway.
 */
class TimezoneSearch extends AbstractRequestObject
{
}
