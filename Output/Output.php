<?php namespace Motokraft\Xsl\Output;

/**
 * @name        Генерация шаблонов XSLT для XML документа
 * @package     motokraft/xsl
 *
 * @copyright   2022 Motokraft. MIT License
 * @link https://github.com/motokraft/xsl
 */

use \Motokraft\HtmlElement\HtmlElement;

class Output
{
    private $method;
    private $version;
    private $encoding;
    private $omit_xml_declaration;
    private $standalone;
    private $doctype_public;
    private $doctype_system;
    private $cdata_section_elements;
    private $indent;
    private $media_type;

    function __construct(?string $version)
    {
        $this->setVersion($version);
    }

    function setMethod(string $value)
    {
        $this->method = $value;
        return $this;
    }

    function setVersion(string $value)
    {
        $this->version = $value;
        return $this;
    }

    function setEncoding(string $value)
    {
        $this->encoding = $value;
        return $this;
    }

    function setOmitXmlDeclaration(string $value)
    {
        $this->omit_xml_declaration = $value;
        return $this;
    }

    function setStandalone(string $value)
    {
        $this->standalone = $value;
        return $this;
    }

    function setDoctypePublic(string $value)
    {
        $this->doctype_public = $value;
        return $this;
    }

    function setDoctypeSystem(string $value)
    {
        $this->doctype_system = $value;
        return $this;
    }

    function setCdataSectionElements(string $value)
    {
        $this->cdata_section_elements = $value;
        return $this;
    }

    function setIndent(string $value)
    {
        $this->indent = $value;
        return $this;
    }

    function setMediaType(string $value)
    {
        $this->media_type = $value;
        return $this;
    }

    function getMethod()
    {
        return $this->method;
    }

    function getVersion()
    {
        return $this->version;
    }

    function getEncoding()
    {
        return $this->encoding;
    }

    function getOmitXmlDeclaration()
    {
        return $this->omit_xml_declaration;
    }

    function getStandalone()
    {
        return $this->standalone;
    }

    function getDoctypePublic()
    {
        return $this->doctype_public;
    }

    function getDoctypeSystem()
    {
        return $this->doctype_system;
    }

    function getCdataSectionElements()
    {
        return $this->cdata_section_elements;
    }

    function getIndent()
    {
        return $this->indent;
    }

    function getMediaType()
    {
        return $this->media_type;
    }

    function render(HtmlElement $element)
    {
        $result = $element->appendCreateHtml(
            'xsl:output'
        );

        if($method = $this->getMethod())
        {
            $result->addAttribute('method', $method);
        }

        if($version = $this->getVersion())
        {
            $result->addAttribute('version', $version);
        }

        if($encoding = $this->getEncoding())
        {
            $result->addAttribute('encoding', $encoding);
        }

        if($xml_declaration = $this->getOmitXmlDeclaration())
        {
            $result->addAttribute('omit_xml_declaration', $xml_declaration);
        }

        if($standalone = $this->getStandalone())
        {
            $result->addAttribute('standalone', $standalone);
        }

        if($doctype_public = $this->getDoctypePublic())
        {
            $result->addAttribute('doctype_public', $doctype_public);
        }

        if($doctype_system = $this->getDoctypeSystem())
        {
            $result->addAttribute('doctype_system', $doctype_system);
        }

        if($cdata_elements = $this->getCdataSectionElements())
        {
            $result->addAttribute('cdata_section_elements', $cdata_elements);
        }

        if($indent = $this->getIndent())
        {
            $result->addAttribute('indent', $indent);
        }

        if($media_type = $this->getMediaType())
        {
            $result->addAttribute('media_type', $media_type);
        }

        return $result;
    }
}