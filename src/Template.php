<?php


namespace Futape\PhpTemplate;


use Futape\PhpTemplate\Exception\InvalidVariableNameException;
use Futape\Utility\Php\Php;
use Futape\Utility\String\Strings;

class Template
{
    /** @var string[] */
    protected $variables = [];

    /** @var string */
    protected $path;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->setPath($path);
    }

    /**
     * @param string|null $name
     * @return array|mixed|null
     */
    public function getVariables(?string $name = null)
    {
        if ($name !== null) {
            return $this->variables[$name] ?? null;
        }

        return $this->variables;
    }

    /**
     * @param array $variables
     * @return self
     *
     * @throws InvalidVariableNameException
     */
    public function setVariables(array $variables): self
    {
        foreach (array_keys($this->variables) as $name) {
            $this->removeVariable($name);
        }

        foreach ($variables as $name => $value) {
            $this->addVariable($name, $value);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param $value
     * @return self
     *
     * @throws InvalidVariableNameException
     */
    public function addVariable(string $name, $value): self
    {
        if (!Php::isValidVariableName($name)) {
            throw new InvalidVariableNameException($name);
        }

        $this->variables[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     * @return self
     */
    public function removeVariable(string $name): self
    {
        unset($this->variables[$name]);

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string|null
     */
    public function render(): ?string
    {
        $render = $this->getRenderMethod();

        ob_start();

        $include = $render(...array_values($this->getVariables()));
        $rendered = ob_get_clean();

        if ($include === false) {
            return null;
        }

        return $rendered;
    }

    /**
     * @return callable
     */
    protected function getRenderMethod(): callable
    {
        if (count($this->getVariables()) > 0) {
            $argumentList = '$' . implode(', $', array_keys($this->getVariables()));
        } else {
            $argumentList = '';
        }

        return eval('return function (' . $argumentList . ') {return include "' . Strings::escape($this->getPath()) . '";};');
    }
}
