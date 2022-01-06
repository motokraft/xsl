<?php namespace Motokraft\Xsl\Template;

/**
 * @name        Генерация шаблонов XSLT для XML документа
 * @package     motokraft/xsl
 *
 * @copyright   2022 Motokraft. MIT License
 * @link https://github.com/motokraft/xsl
 */

use \Motokraft\HtmlElement\HtmlElement;
use \Motokraft\Xsl\Traits\Variable;
use \Motokraft\Xsl\Traits\Param;

class BaseTemplate implements InterfaceTemplate
{
    use Variable, Param;

    private $match;
    private $name;
    private $priority;
    private $mode;

    private $variables = [];
    private $params = [];

    function __construct(?string $match = null)
    {
        if(isset($match))
        {
            $this->setMatch($match);
        }
    }

    function setMatch(string $match)
    {
        $this->match = $match;
        return $this;
    }

    function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    function setPriority(string $priority)
    {
        $this->priority = $priority;
        return $this;
    }

    function setMode(string $mode)
    {
        $this->mode = $mode;
        return $this;
    }

    function getMatch()
    {
        return $this->match;
    }

    function getName()
    {
        return $this->name;
    }

    function getPriority()
    {
        return $this->priority;
    }

    function getMode()
    {
        return $this->mode;
    }

    function render(HtmlElement $element)
    {
        $result = $element->appendCreateHtml('xsl:template');

        if($match = $this->getMatch())
        {
            $result->addAttribute('match', $match);
        }

        if($name = $this->getName())
        {
            $result->addAttribute('name', $name);
        }

        if($priority = $this->getPriority())
        {
            $result->addAttribute('priority', $priority);
        }

        if($mode = $this->getMode())
        {
            $result->addAttribute('mode', $mode);
        }

        foreach($this->variables as $variable)
        {
            $el = $result->appendCreateHtml('xsl:variable');

            if($html = $variable->getHtml())
            {
                $el->html($html, false);
            }
            
            if($name = $variable->getName())
            {
                $el->addAttribute('name', $name);
            }

            if($value = $variable->getValue())
            {
                $el->addAttribute('select', $value);
            }
        }

        foreach($this->params as $param)
        {
            $el = $result->appendCreateHtml('xsl:param');
            
            if($html = $param->getHtml())
            {
                $el->html($html, false);
            }

            if($name = $param->getName())
            {
                $el->addAttribute('name', $name);
            }

            if($value = $param->getValue())
            {
                $el->addAttribute('select', $value);
            }
        }

        return $result;
    }
}