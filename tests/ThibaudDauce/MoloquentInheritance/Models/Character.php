<?php

namespace ThibaudDauce\MoloquentInheritance\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use ThibaudDauce\MoloquentInheritance\MoloquentInheritanceTrait;

class Character extends Model
{
    use MoloquentInheritanceTrait;
}
