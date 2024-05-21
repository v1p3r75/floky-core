<?php

namespace Floky\Container;

use Closure;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;

class Container implements ContainerInterface
{
    private array $services = [];

    private static ?Container $instance = null;

    private function __construct() {}

    public static function getInstance(): self {

        if (!self::$instance) {

            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(string $id)
    {

        if ($this->has($id)) {

            return $this->services[$id];
        }
        return $this->resolveDependencies($id);
    }

    public function set(string $id, callable $definition)
    {
        if ($this->has($id)) {

            return false;
        }

        $this->services[$id] = $definition();

        return true;
    }

    public function has(string $id): bool
    {

        return isset($this->services[$id]);
    }

    private function resolveDependencies($id)
    {
        $reflection = new ReflectionClass($id);

        if ($reflection->isInterface()) {

            if ($this->has($id))

                return $this->services[$id];
            
            throw new \Exception("Interface [$id] have not a binding class in service container");
        }

        $constructor = $reflection->getConstructor();

        if (!$constructor) {

            return $reflection->newInstance();
        }

        $parameters = $constructor->getParameters();
       
        $dependencies =  $this->resolveParameters($reflection, $parameters);

        return $reflection->newInstanceArgs($dependencies);
    }

    private function resolveParameters(ReflectionClass | ReflectionMethod | ReflectionFunction $reflection, array $parameters): array {

        $dependencies = [];

        foreach ($parameters as $parameter) {

            $type = $parameter->getType();

            if (!$type || $type->isBuiltin()) {

                $dependencies[] = $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null;

            } else {

                $resolve_dependencies = $this->get($type->getName());
                $dependencies[] = $resolve_dependencies;
            }
        }

        return $dependencies;
    }

    public function getMethod($class, $name, ...$args): array {

        $reflection = new ReflectionMethod($class, $name);

        $parameters = $reflection->getParameters();

        $dependencies = $this->resolveParameters($reflection, $parameters);

        $params = $this->addParams($dependencies, $args);

        /**TODO: Don't add parameters if $args is null */
        
        return [$reflection, $class, $params];

    }

    public function resolveFunction(Closure | callable $function, ...$args): array {

        $reflection = new ReflectionFunction($function);

        $parameters = $reflection->getParameters();

        $dependencies = $this->resolveParameters($reflection, $parameters);

        $params = $this->addParams($dependencies, $args);

        return [$reflection->getClosure(), $params];

    }

    public function runMethod(array $reflection_data) {

        /**Example $reflection_data = [$reflection, $class, $params];*/
        
        return $reflection_data[0]->invokeArgs($reflection_data[1], $reflection_data[2]);
    }

    private function addParams(array $dependencies, $args): array {

        $params = array_merge($dependencies, ...$args);

        $dependencies = [];

        foreach($params as $param) {

            if (is_null($param)) {
                continue;
            }
            $dependencies[] = $param;
        }

        return $dependencies;
    }

}
