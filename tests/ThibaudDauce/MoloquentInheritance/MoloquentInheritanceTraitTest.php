<?php namespace ThibaudDauce\MoloquentInheritance;

use PHPUnit_Framework_TestCase;
use ThibaudDauce\MoloquentInheritance\Models\Character;
use ThibaudDauce\MoloquentInheritance\Models\Wizard;

class MoloquentInheritanceTraitTest extends PHPUnit_Framework_TestCase
{

    protected $character;
    protected $wizard;

    public function setUp()
    {
        parent::setUp();

        $this->character = new Character;
        $this->wizard = new Wizard;
    }

    public function testGetParentClasses()
    {
        $classes = $this->wizard->getParentClasses();
        $this->assertEquals($classes, [get_class($this->wizard), get_class($this->character)]);

        $classes = $this->character->getParentClasses();
        $this->assertEquals($classes, [get_class($this->character)]);
    }

    public function testFillMoloquentInheritanceTrait()
    {
        $this->assertEquals($this->character->parent_classes, $this->character->getParentClasses());

        $this->assertEquals($this->wizard->parent_classes, $this->wizard->getParentClasses());
    }

    public function testNewFromBuilder()
    {
        // Test with the parent class without a class_name
        $character = new Character;
        $characterAttributes = [
            'name' => 'Antoine',
            'parent_classes' => [
                'ThibaudDauce\MoloquentInheritance\Character'
            ]
        ];
        $character = $character->newFromBuilder($characterAttributes);

        $this->assertTrue($character instanceof Character);
        $this->assertFalse($character instanceof Wizard);
        $this->assertEquals($characterAttributes['name'], $character->getAttribute('name'));

        // Test with a child class
        $wizard = new Wizard;
        $wizardAttributes = [
            'name' => 'Antoine',
            'rage' => 42,
            'parent_classes' => [
            'ThibaudDauce\MoloquentInheritance\Wizard',
                'ThibaudDauce\MoloquentInheritance\Character'
            ]
        ];
        $wizard = $wizard->newFromBuilder($wizardAttributes);

        $this->assertTrue($wizard instanceof Wizard);
        $this->assertEquals($wizardAttributes['name'], $wizard->getAttribute('name'));
        $this->assertEquals($wizardAttributes['rage'], $wizard->getAttribute('rage'));
    }
}
