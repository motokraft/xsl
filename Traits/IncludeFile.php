<?php namespace Motokraft\Xsl\Traits;

/**
 * @name        Генерация шаблонов XSLT для XML документа
 * @package     motokraft/xsl
 *
 * @copyright   2022 Motokraft. MIT License
 * @link https://github.com/motokraft/xsl
 */

trait IncludeFile
{
    private $includes = [];

    function setIncludeFile(string $href)
    {
        $key = $this->hasIncludeFile($href);
        if($key !== false) return false;

        array_push($this->includes, $href);
        $this->setKeyCache('include:' . $href);

        return true;
    }

    function removeIncludeFile(string $href)
    {
        $key = $this->hasIncludeFile($href);
        if($key === false) return false;

        $this->removeKeyCache('include:' . $href);
        unset($this->includes[$key]);

        return true;
    }

    function hasIncludeFile(string $href)
    {
        return array_search($href, $this->includes);
    }
}