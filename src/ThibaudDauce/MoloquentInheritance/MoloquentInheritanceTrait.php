<?php namespace ThibaudDauce\MoloquentInheritance;

use ReflectionClass;

trait MoloquentInheritanceTrait {

  public $parentClasses;

  /**
	 * Fill the model with an array of attributes.
	 *
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

    $this->parentClasses = $this->getParentClasses();
  }
}
