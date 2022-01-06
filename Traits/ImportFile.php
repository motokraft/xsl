<?php namespace Motokraft\Xsl\Traits;

/**
 * @name        Генерация шаблонов XSLT для XML документа
 * @package     motokraft/xsl
 *
 * @copyright   2022 Motokraft. MIT License
 * @link https://github.com/motokraft/xsl
 */

trait ImportFile
{
    private $imports = [];

    function setImportFile($href)
    {
        $key = $this->hasImportFile($href);
        if($key !== false) return false;

        array_push($this->imports, $href);
        $this->setKeyCache('import:' . $href);

        return true;
    }

    function removeImportFile(string $href)
    {
        $key = $this->hasImportFile($href);
        if($key === false) return false;

        $this->removeKeyCache('import:' . $href);
        unset($this->imports[$key]);

        return true;
    }

    function hasImportFile(string $href)
    {
        return array_search($href, $this->imports);
    }
}