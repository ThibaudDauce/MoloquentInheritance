<?php namespace ThibaudDauce\MoloquentInheritance;

use Illuminate\Database\Eloquent\MassAssignmentException;
use ReflectionClass;
use Illuminate\Database\Eloquent\Model;

trait MoloquentInheritanceTrait {

    public $parentClasses;

    /**
     * Boot the moloquent inheritance for a model.
     *
     * @return void
     */
    public static function bootMoloquentInheritanceTrait()
    {
        static::addGlobalScope(new MoloquentInheritanceScope);
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @override Model
     * @param array $attributes
     * @return $this
     *
     * @throws MassAssignmentException
     */
    public function fill(array $attributes)
    {
        $this->setParentClasses();

        return parent::fill($attributes);
    }

    public function getParentClasses() {

        $reflection = new ReflectionClass($this);

        $classes = [$reflection->getName()];

        while ($reflection->getName() !== get_class()) {
            $reflection = $reflection->getParentClass();
            $classes[] = $reflection->getName();
        }

        return $classes;
    }

    public function setParentClasses() {

        $this->attributes['parent_classes'] = $this->getParentClasses();
    }

    /**
     * Create a new model instance that is existing.
     *
     * @override Model
     * @param array $attributes
     * @param null $connection
     * @return Model|static
     */
    public function newFromBuilder($attributes = array(), $connection = null)
    {
        $class = $attributes['parent_classes'][0];

        if ($this instanceof $class)
            return parent::newFromBuilder($attributes, $connection);

        $instance = new $class;

        return $instance->newFromBuilder($attributes, $connection);
    }
}
