<?php namespace Motokraft\Xsl\Variable;

/**
 * @name        Генерация шаблонов XSLT для XML документа
 * @package     motokraft/xsl
 *
 * @copyright   2022 Motokraft. MIT License
 * @link https://github.com/motokraft/xsl
 */

use \Motokraft\HtmlElement\HtmlElement;

class BaseVariable
{
    private $name;
    private $value;
    private $html;

    function __construct(string $name, $value)
    {
        $this->setName($name);
        $this->setValue($value);
    }

    function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    function setHtml($html)
    {
        $this->html = $html;
        return $this;
    }

    function getName()
    {
        return $this->name;
    }

    function getValue()
    {
        return $this->value;
    }

    function getHtml()
    {
        return $this->html;
    }

    function render(HtmlElement $element)
    {
        $result = $element->appendCreateHtml('xsl:variable');
            
        if($html = $this->getHtml())
        {
            $result->html($html, false);
        }

        if($name = $this->getName())
        {
            $result->addAttribute('name', $name);
        }

        if($value = $this->getValue())
        {
            $result->addAttribute('select', $value);
        }

        return $result;
    }
}