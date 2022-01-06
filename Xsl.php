<?php namespace Motokraft\Xsl;

/**
 * @name        Генерация шаблонов XSLT для XML документа
 * @package     motokraft/xsl
 *
 * @copyright   2022 Motokraft. MIT License
 * @link https://github.com/motokraft/xsl
 */

if(!defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}

if(!defined('ROOT_PATH'))
{
	define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
}

use \Motokraft\HtmlElement\HtmlElement;
use \Motokraft\Xsl\Template\InterfaceTemplate;
use \Motokraft\Xsl\Output\Output;
use \Motokraft\Xsl\Variable\BaseVariable;
use \Motokraft\Xsl\Param\BaseParam;

HtmlElement::addRenders([
    'xml-stylesheet' => '<?{type}{attrs}?>',
    'xsl:import' => '<{type}{attrs} />',
    'xsl:include' => '<{type}{attrs} />',
	'xsl:output' => '<{type}{attrs} />',
	'xsl:value-of' => '<{type}{attrs} />',
	'xsl:apply-templates' => '<{type} />'
]);

class Xsl
{
    use Traits\Variable {
        Traits\Variable::setVariable as traitSetVariable;
        Traits\Variable::removeVariable as traitRemoveVariable;
    }

    use Traits\Param {
        Traits\Param::setParam as traitSetParam;
        Traits\Param::removeParam as traitRemoveParam;
    }

    use Traits\ImportFile,
        Traits\IncludeFile;

    private static $instances = [];

    private $version;
    private $id;
    private $output;

    private $variables = [];
    private $params = [];
    private $templates = [];
    private $keys = [];

    function __construct(string $name, $version = '1.0')
    {
        $this->output = new Output($version);
        $this->setKeyCache('name:' . $name);

        if(defined('DEBUG'))
        {
            $this->setKeyCache('debug:' . DEBUG);
        }

        if(isset($version))
        {
            $this->setVersion($version);
        }
    }

    static function getInstance(string $name)
    {
        if(!isset(self::$instances[$name]))
        {
            self::$instances[$name] = new static($name);
        }

        return self::$instances[$name];
    }

    function setVersion(string $value)
    {
        $this->setKeyCache('version:' . $value);

        $this->version = $value;
        return $this;
    }

    function setId(string $value)
    {
        $this->setKeyCache('id:' . $value);

        $this->id = $value;
        return $this;
    }

    function getVersion()
    {
        return $this->version;
    }

    function getId()
    {
        return $this->id;
    }

    function getOutput()
    {
        return $this->output;
    }

    function setKeyCache(string $value)
    {
        $key = $this->hasKeyCache($value);
        if($key !== false) return false;

        array_push($this->keys, $value);
        return true;
    }

    function removeKeyCache(string $value)
    {
        $key = $this->hasKeyCache($value);
        if($key === false) return false;

        unset($this->keys[$key]);
        return true;
    }

    function hasKeyCache(string $value)
    {
        return array_search($value, $this->keys);
    }

    function setVariable(string $name, $value = null)
    {
        $result = $this->traitSetVariable($name, $value);

        if($result instanceof BaseVariable)
        {
            $this->setKeyCache('variable:' . $name);
        }

        return $result;
    }

    function removeVariable(string $name)
    {
        if($result = $this->traitRemoveVariable($name))
        {
            $this->removeKeyCache('variable:' . $name);
        }

        return $result;
    }

    function setParam(string $name, $value = null)
    {
        $result = $this->traitSetParam($name, $value);

        if($result instanceof BaseParam)
        {
            $this->setKeyCache('param:' . $name);
        }

        return $result;
    }

    function removeParam(string $name)
    {
        if($result = $this->traitRemoveParam($name))
        {
            $this->removeKeyCache('param:' . $name);
        }

        return $result;
    }

    function setTemplate(InterfaceTemplate $tmpl)
    {
        if($match = $tmpl->getMatch())
        {
            $this->setKeyCache('match:' . $match);
        }

        if($name = $tmpl->getName())
        {
            $this->setKeyCache('name:' . $name);
        }

        if($priority = $tmpl->getPriority())
        {
            $this->setKeyCache('priority:' . $priority);
        }

        if($mode = $tmpl->getMode())
        {
            $this->setKeyCache('mode:' . $mode);
        }

        $this->templates[$match] = $tmpl;
        return $tmpl;
    }

    function getTemplate(string $match)
    {
        if(!$this->hasTemplate($match))
        {
            return false;
        }

        return $this->templates[$match];
    }

    function removeTemplate(string $match)
    {
        if(!$this->hasTemplate($match))
        {
            return false;
        }

        unset($this->templates[$match]);
        return true;
    }

    function hasTemplate(string $match)
    {
        return isset($this->templates[$match]);
    }

    function render(HtmlElement $element)
    {
        $result = $element->beforeCreateHtml(
            'xml-stylesheet', ['type' => 'text/xsl']
        );

        $result->addAttribute('href', $this->save());

        return $result;
    }

    function save()
    {
        if(DEBUG)
        {
            $this->setKeyCache(rand().time());
        }

        $cache = md5(implode('', $this->keys));
        $filename = $cache . '.min.xsl';

        $filepath = ROOT_PATH . DS . 'tmp' . DS . 'xsl';

        if(!is_dir($filepath))
        {
            mkdir($filepath, 0777, true);
        }

        if(!is_file($filepath . DS . $filename))
        {
            $file = new \SplFileObject(
                $filepath . DS . $filename, 'a+'
            );

            $file->fwrite(strval($this));
        }

        return '/tmp/xsl/' . $filename;
    }

    function getHtmlElement()
    {
        $result = new HtmlElement('xsl:stylesheet', [
            'xmlns:xsl' => 'http://www.w3.org/1999/XSL/Transform'
        ]);

        if($version = $this->getVersion())
        {
            $result->addAttribute('version', $version);
        }

        foreach($this->imports as $import)
        {
            $el = $result->appendCreateHtml('xsl:import');
            $el->addAttribute('href', $import);
        }

        foreach($this->includes as $include)
        {
            $el = $result->appendCreateHtml('xsl:include');
            $el->addAttribute('href', $include);
        }

        $this->getOutput()->render($result);

        foreach($this->variables as $variable)
        {
            $variable->render($result);
        }

        foreach($this->params as $param)
        {
            $param->render($result);
        }

        foreach($this->templates as $template)
        {
            $template->render($result);
        }

        return $result;
    }

    function __toString()
    {
        return (string) $this->getHtmlElement();
    }
}