<?php namespace ThibaudDauce\MoloquentInheritance;

use PHPUnit_Framework_TestCase;
use ThibaudDauce\MoloquentInheritance\MoloquentInheritanceTrait;
use Jenssegers\Eloquent\Model;

class MoloquentInheritanceTraitTest extends PHPUnit_Framework_TestCase {

  protected $character;
  protected $wizzard;

  public function setUp()
  {
    parent::setUp();

    $this->character = new Character;
    $this->wizzard = new Wizzard;
  }

  public function testGetParentClasses()
  {
    $classes = $this->wizzard->getParentClasses();
    $this->assertEquals($classes, [get_class($this->wizzard), get_class($this->character)]);

    $classes = $this->character->getParentClasses();
    $this->assertEquals($classes, [get_class($this->character)]);
  }

  public function testFillMoloquentInheritanceTrait()
  {
    $this->assertEquals($this->character->parentClasses, $this->character->getParentClasses());

    $this->assertEquals($this->wizzard->parentClasses, $this->wizzard->getParentClasses());
  }
}

class Character extends Model {

  use MoloquentInheritanceTrait;
}

class Wizzard extends Character {

}
