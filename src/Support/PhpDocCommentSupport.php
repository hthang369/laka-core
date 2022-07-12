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
        return $docBlock->getSummary();
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
            return [
                'property' => $item->getName(),
                'type' => $this->getPhpDocTagsByName($className, $item->getName())->getType(),
                'default' => $item->getDefaultValue(),
                'description' => $this->getPhpDocTagsByName($className, $item->getName())->getDescription()->getBodyTemplate()
            ];
        }, $params);
    }
}
