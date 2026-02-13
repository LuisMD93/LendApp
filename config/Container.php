<?php

namespace Config;

use ReflectionClass;
use Exception;

class Container
{
    private array $bindings = [];
    private array $instances = [];

    /**
     * Registrar servicio o factory
     */
    public function set(string $id, $value): void // dame un nombre para crear la posicion y un dato que contendra la posicion
    {
        $this->bindings[$id] = $value; //dentro del array bindings en la posicion id guarda este valor que te estoy pasando
               //bindings[2] = ControllerValue;
    }

    /**
     * Resolver un servicio
     */
    public function get(string $id)
    {
        // Si ya existe como singleton
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        // Si existe un factory definido
        if (isset($this->bindings[$id])) {

            $service = $this->bindings[$id];

            // Si es un factory (closure)
            if ($service instanceof \Closure) {
                $object = $service($this);
                $this->instances[$id] = $object;  // Guardamos singleton
                return $object;
            }

            // Si es una instancia ya creada
            $this->instances[$id] = $service;
            return $service;
        }

        // Si no está registrado, usar autowiring
        return $this->autowire($id);
    }

    /**
     * Autoconstrucción mediante Reflection
     */
    private function autowire(string $class)
    {
        if (!class_exists($class)) {

            throw new Exception("Class {$class} does not exist.");
        }

        $reflection = new ReflectionClass($class);

        // Si no tiene constructor → crear instancia simple
        $constructor = $reflection->getConstructor();
        if (!$constructor) {
            $instance = new $class();
            $this->instances[$class] = $instance;
            return $instance;
        }

        // Resolver dependencias del constructor
        $params = [];
        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();
             
            if ($type === null) {
                throw new Exception("Cannot autowire parameter \${$param->name} in {$class}: no type defined.");
            }

            $typeName = $type->getName();
           
            $params[] = $this->get($typeName);  // Recursivo
        }

        // Crear instancia con dependencias inyectadas
        $instance = $reflection->newInstanceArgs($params);
        $this->instances[$class] = $instance;

        return $instance;
    }
}
