<?php
/**
 * @package    agitation/localedata
 * @link       http://github.com/agitation/AgitLocaleDataBundle
 * @author     Alex Günsche <http://www.agitsol.com/>
 * @copyright  2012-2015 AGITsol GmbH
 * @license    http://opensource.org/licenses/MIT
 */

namespace Agit\LocaleDataBundle\Adapter;

use Agit\CoreBundle\Exception\InternalErrorException;

abstract class AbstractAdapter
{
    protected $LocaleService;

    protected $cldrDir;

    protected $baseLocDir = 'en-GB';

    // cache for raw retrieved data
    protected $dataCache = [];

    public function setLocaleService($LocaleService)
    {
        $this->LocaleService = $LocaleService;
    }

    public function setCldrDir($cldrDir)
    {
        $this->cldrDir = realpath(__DIR__."/../$cldrDir");
    }

    protected function getMainData($locDir, $filename)
    {
        $path = sprintf('%s/main/%s/%s', $this->cldrDir, $locDir ?: $this->baseLocDir, $filename);
        return $this->getData($path);
    }

    protected function findLocDirForLocale($locale)
    {
        $locDir = null;
        $variants = [str_replace('_', '-', $locale), substr($locale, 0, 2)];

        foreach ($variants as $variant)
        {
            $path = sprintf('%s/main/%s', $this->cldrDir, $variant);

            if (is_dir($path))
            {
                $locDir = $variant;
                break;
            }
        }

        return $locDir;
    }

    protected function getSupplementalData($filename)
    {
        $path = sprintf('%s/supplemental/%s', $this->cldrDir, $filename);
        return $this->getData($path);
    }

    private function getData($path)
    {
        if (!isset($this->dataCache[$path]))
        {
            if (!is_readable($path))
                throw new InternalErrorException("Cannot read '$path'.");

            $this->dataCache[$path] = json_decode(file_get_contents($path), true);
        }

        return $this->dataCache[$path];
    }

    protected function getList($listname)
    {
        $this->load();

        if (!property_exists($this, $listname) || !is_array($this->$listname))
            throw new InternalErrorException("No list named '$listname' found.");

        return $this->$listname;
    }

    protected function getListElement($listname, $code)
    {
        $list = $this->getList($listname);

        if (!isset($list[$code]))
            throw new InternalErrorException("No element with name '$code' found.");

        return $list[$code];
    }

    protected function hasListElement($listname, $code)
    {
        $list = $this->getList($listname);
        return (isset($list[$code]));
    }

    abstract protected function load();
}