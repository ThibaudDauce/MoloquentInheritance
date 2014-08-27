<?php namespace ThibaudDauce\MoloquentInheritance;

use ReflectionClass;

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
     * @override Illuminate\Database\Eloquent\Model
     * @param  array  $attributes
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
     * @override Illuminate\Database\Eloquent\Model
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function newFromBuilder($attributes = array())
    {
        $class = $attributes['parent_classes'][0];
        
        if ($this instanceof $class)
            return parent::newFromBuilder($attributes);

        $instance = new $class;

        $instance->newFromBuilder((array) $attributes);

        return $instance;
    }
}
