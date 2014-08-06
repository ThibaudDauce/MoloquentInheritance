<?php namespace ThibaudDauce\MoloquentInheritance;

use ReflectionClass;

trait MoloquentInheritanceTrait {

  public function getParentClasses() {

    $reflection = new ReflectionClass($this);

    $classes = [$reflection->getName()];

    while ($reflection->getName() !== get_class()) {
      $reflection = $reflection->getParentClass();
      $classes[] = $reflection->getName();
    }

    return $classes;
  }
}
