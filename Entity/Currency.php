<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Agit\IntlBundle\Translate;
use Agit\CommonBundle\Entity\AbstractEntity;

/**
 * @ORM\Entity(repositoryClass="Agit\LocaleDataBundle\Entity\CurrencyRepository")
 */
class Currency extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string",length=3,unique=true)
     */
    protected $id;

    /**
     * @ORM\Column(type="string",length=60)
     */
    protected $name;

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return Translate::x($this->name, 'currency');
    }
}
