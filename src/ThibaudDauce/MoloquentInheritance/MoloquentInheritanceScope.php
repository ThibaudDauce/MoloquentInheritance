<?php namespace ThibaudDauce\MoloquentInheritance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class MoloquentInheritanceScope implements Scope {

	/**
	 * All of the extensions to be added to the builder.
	 *
	 * @var array
	 */
	protected $extensions = ['OnlyParent'];

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     */
	public function apply(Builder $builder, Model $model)
	{
		$builder->where('parent_classes', 'all', [get_class($model)]);
	}
}
