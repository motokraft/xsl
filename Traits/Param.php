<?php namespace Motokraft\Xsl\Traits;

/**
 * @name        Генерация шаблонов XSLT для XML документа
 * @package     motokraft/xsl
 *
 * @copyright   2022 Motokraft. MIT License
 * @link https://github.com/motokraft/xsl
 */
 
use \Motokraft\Xsl\Param\BaseParam;

trait Param
{
    function setParam(string $name, $value = null)
    {
        if($this->hasParam($name))
        {
            return false;
        }

        $param = new BaseParam($name, $value);
        $this->params[$name] = $param;

        return $param;
    }

    function getParam(string $name, $default = null)
    {
        if(!$this->hasParam($name))
        {
            return $default;
        }

        return $this->params[$name];
    }

    function removeParam(string $name)
    {
        if(!$this->hasParam($name))
        {
            return false;
        }

        unset($this->params[$name]);
        return true;
    }

    function hasParam(string $name)
    {
        return isset($this->params[$name]);
    }
}