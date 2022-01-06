<?php namespace Motokraft\Xsl\Traits;

/**
 * @name        Генерация шаблонов XSLT для XML документа
 * @package     motokraft/xsl
 *
 * @copyright   2022 Motokraft. MIT License
 * @link https://github.com/motokraft/xsl
 */

use \Motokraft\Xsl\Variable\BaseVariable;

trait Variable
{
    function setVariable(string $name, $value = null)
    {
        if($this->hasVariable($name))
        {
            return false;
        }

        $variable = new BaseVariable($name, $value);
        $this->variables[$name] = $variable;

        return $variable;
    }

    function getVariable(string $name, $default = null)
    {
        if(!$this->hasVariable($name))
        {
            return $default;
        }

        return $this->variables[$name];
    }

    function removeVariable(string $name)
    {
        if(!$this->hasVariable($name))
        {
            return false;
        }

        unset($this->variables[$name]);
        return true;
    }

    function hasVariable(string $name)
    {
        return isset($this->variables[$name]);
    }
}