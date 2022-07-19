<?php

namespace Laka\Core\Support;

use phpDocumentor\Reflection\DocBlockFactory;

class PhpDocCommentSupport
{
    protected $factory;

    public function __construct()
    {
        $this->factory = DocBlockFactory::createInstance();
    }

    protected function getPhpDocComment($className, $fnName = null)
    {
        $reflector = new \ReflectionClass($className);
        $docComment = $reflector->getDocComment();
        if ($fnName) {
            $docComment = $reflector->getMethod($fnName)->getDocComment();
        }

        if ($docComment) {
            return $this->factory->create($docComment);
        }
        return null;
    }

    public function getPhpDocSummary($className)
    {
        $docBlock = $this->getPhpDocComment($className);
        return $docBlock ? $docBlock->getSummary() : '';
    }

    public function getPhpDocTags($className)
    {
        $docBlock = $this->getPhpDocComment($className, '__construct');
        return $docBlock->getTags();
    }

    protected function getPhpDocTagsByName($className, $name)
    {
        $tags = $this->getPhpDocTags($className);
        return head(array_filter($tags, function($item) use($name) {
            return str_is($item->getVariableName(), $name);
        }));
    }

    public function getPhpDocProperties($className)
    {
        $reflector = new \ReflectionClass($className);
        $params = $reflector->getMethod('__construct')->getParameters();
        return array_map(function($item) use($className) {
            $docTag = $this->getPhpDocTagsByName($className, $item->getName());
            return [
                'property' => $item->getName(),
                'type' => !$docTag ?: $docTag->getType(),
                'default' => $this->getDefaultValue($item),
                'description' => !$docTag ?: $docTag->getDescription()->getBodyTemplate()
            ];
        }, $params);
    }

    private function getDefaultValue($item)
    {
        $defaultValue = $item->getDefaultValue();
        if (is_bool($defaultValue)) return $defaultValue ? 'true' : 'false';
        if (is_array($defaultValue)) return '[]';
        return $defaultValue;
    }
}
