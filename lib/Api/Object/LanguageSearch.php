<?php

/*
 * @package    agitation/localedata-bundle
 * @link       http://github.com/agitation/localedata-bundle
 * @author     Alexander Günsche
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Api\Object;

use Agit\ApiBundle\Annotation\Object;
use Agit\ApiBundle\Api\Object\AbstractRequestObject;

/**
 * @Object\Object(namespace="localedata.v1")
 *
 * Language search request object. Actually, this is just a dummy object, as
 * the Language.search method doesn’t take any methods anyway.
 */
class LanguageSearch extends AbstractRequestObject
{
}
