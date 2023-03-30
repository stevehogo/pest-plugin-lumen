<?php

namespace Pest\Lumen\Testing\Concerns;
use Anik\Testbench\TestCase;
use PHPUnit\Metadata\Annotation\Parser\Registry as PHPUnit10Registry;
use PHPUnit\Runner\Version;
use Throwable;
trait HandlesAnnotations
{
    protected function parseAnnotation(string $annotation, string $class, string $ofMethod): array
    {
        if (!$this instanceof TestCase || !class_exists(Version::class)) {
            return [];
        }

        $registry = version_compare(Version::id(), '10', '>=')
            ? PHPUnit10Registry::getInstance()
            : \PHPUnit\Util\Annotation\Registry::getInstance();

        try {
            $annotations = $registry->forMethod($class, $ofMethod)->symbolAnnotations();
        } catch (Throwable $t) {
            return [];
        }

        return $annotations[$annotation] ?? [];
    }
}
