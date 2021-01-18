<?php

namespace Niji\AutoAttributeOptionsSetterBundle\DependencyInjection\Compiler;

use Akeneo\Pim\Enrichment\Bundle\DependencyInjection\Compiler\RegisterProductUpdaterPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class PropertySetterCompilerPass implements CompilerPassInterface
{
    const SETTER_TAG = 'pim_catalog.updater.setter.before';

    public function process(ContainerBuilder $container): void
    {
        $registry = $container->getDefinition(RegisterProductUpdaterPass::SETTER_REGISTRY);
        $setters = $container->findTaggedServiceIds(static::SETTER_TAG);
        foreach ($setters as $setterId => $tags) {
            foreach ($tags as $tag) {
                if (!array_key_exists('before', $tag)) {
                    continue;
                }
                $this->registerSetter($registry, $setterId, $tag['before']);
            }
        }
    }

    private function registerSetter(Definition $definition, string $setterId, string $before): void
    {
        $definition->setMethodCalls(
            array_reduce(
                $definition->getMethodCalls(),
                function (array $carry, array $call) use ($setterId, $before): array {
                    [$method, $arguments] = $call;
                    [$reference] = $arguments;
                    if ((string)$reference === $before) {
                        $carry[] = [
                            $method,
                            [new Reference($setterId)]
                        ];
                    }
                    $carry[] = $call;
                    return $carry;
                },
                []
            )
        );
    }
}
