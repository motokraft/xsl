<?php namespace Motokraft\Xsl\Template;

/**
 * @name        Генерация шаблонов XSLT для XML документа
 * @package     motokraft/xsl
 *
 * @copyright   2022 Motokraft. MIT License
 * @link https://github.com/motokraft/xsl
 */

use \Motokraft\HtmlElement\HtmlElement;

interface InterfaceTemplate
{
    function setMatch(string $match);
    function setName(string $name);
    function setPriority(string $priority);
    function setMode(string $mode);
    function getMatch();
    function getName();
    function getPriority();
    function getMode();
    function render(HtmlElement $element);
}