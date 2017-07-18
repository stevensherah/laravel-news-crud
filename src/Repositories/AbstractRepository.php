<?php

namespace Sevenpluss\NewsCrud\Repositories;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Sevenpluss\NewsCrud\Criteria\Contracts\CriteriaAbleInterface;
use Sevenpluss\NewsCrud\Criteria\Contracts\CriteriaInterface as Criteria;
use Sevenpluss\NewsCrud\Repositories\Contracts\RepositoryInterface;
use Sevenpluss\NewsCrud\Exceptions\RepositoryException;

/**
 * Class AbstractRepository
 * @package Sevenpluss\NewsCrud\Repositories
 */
abstract class AbstractRepository implements RepositoryInterface, CriteriaAbleInterface
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $model;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $criteria;

    /**
     * @var bool
     */
    protected $skipCriteria = false;

    /**
     * @return string
     */
    abstract public function getModel(): string;

    /**
     * AbstractRepository constructor.
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->criteria = $this->app->make(Collection::class);
        $this->makeModel();
    }

    /**
     * @return Model|\Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    protected function makeModel():\Illuminate\Database\Eloquent\Builder
    {
        $model = $this->app->make($this->getModel());

        if (!$model instanceof Model) {
            throw new RepositoryException(trans('news::common.messages.repository_model_instance',
                ['model' => $this->getModel()]));
        }

        return $this->model = $model->newQuery();
    }

    /**
     * @return $this
     * @throws RepositoryException
     */
    public function resetModel()
    {
        $this->makeModel();
        return $this;
    }

    /**
     * @return $this
     */
    public function resetScope()
    {
        $this->skipCriteria(false);
        return $this;
    }

    /**
     * @param bool $status
     * @return $this
     */
    public function skipCriteria(bool $status = true)
    {
        $this->skipCriteria = $status;
        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function resetCriteria():\Illuminate\Support\Collection
    {
        return $this->criteria = $this->app->make(Collection::class);
    }

    /**
     * Pop Criteria
     * @param Criteria $criteria
     * @return $this
     */
    public function popCriteria(Criteria $criteria)
    {
        $this->criteria = $this->criteria->reject(function (Criteria $item) use ($criteria) {
            return get_class($item) === get_class($criteria);
        });
        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCriteria():\Illuminate\Support\Collection
    {
        return $this->criteria;
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function getByCriteria(Criteria $criteria)
    {
        $this->model = $criteria->apply($this->model, $this);
        return $this;
    }

    /**
     * @param Criteria $criteria
     * @return $this
     */
    public function pushCriteria(Criteria $criteria)
    {
        $this->criteria->push($criteria);
        return $this;
    }

    /**
     * @return $this
     */
    public function applyCriteria()
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        $this->getCriteria()->map(function ($criteria) {
            if ($criteria instanceof Criteria) {
                $this->model = $criteria->apply($this->model, $this);
            }
        });

        return $this;
    }

    /**
     * Find a model by its primary key.
     *
     * @param int|string|array $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|static[]|static|null
     */
    public function find($id, array $columns = ['*'])
    {
        $this->applyCriteria();
        $model = $this->model->findOrFail($id, $columns);
        $this->resetModel();

        return $model;
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function findBy(string $field, $value, array $columns = ['*']):\Illuminate\Support\Collection
    {
        $this->applyCriteria();
        $model = $this->model->where($field, $value)->get($columns);
        $this->resetModel();

        return $model;
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param int|string $id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id, array $columns = ['*'])
    {
        $this->applyCriteria();
        $model = $this->model->findOrFail($id, $columns);
        $this->resetModel();

        return $model;
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param array $columns
     * @return \Illuminate\Support\Collection|static[]
     */
    public function all(array $columns = ['*']):\Illuminate\Support\Collection
    {
        $this->applyCriteria();
        $model = $this->model->get($columns);
        $this->resetModel();

        return $model;
    }

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param int|null $perPage
     * @param array $columns
     * @param string $pageName
     * @param int|null $page
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function simplePaginate($perPage = 12, $columns = ['*'], $pageName = 'page', $page = null):\Illuminate\Contracts\Pagination\Paginator
    {
        $this->applyCriteria();
        $model = $this->model->simplePaginate($perPage, $columns, $pageName, $page);
        $this->resetModel();

        return $model;
    }

    /**
     * Paginate the given query.
     *
     * @param int $perPage
     * @param array $columns
     * @param string $pageName
     * @param null $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 12, $columns = ['*'], $pageName = 'page', $page = null):\Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $this->applyCriteria();
        $model = $this->model->paginate($perPage, $columns, $pageName, $page);
        $this->resetModel();

        return $model;
    }

    /**
     * Save a new model and return the instance.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model|$this
     */
    public function create(array $attributes = [])
    {
        return $this->model->create($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newInstance():\Illuminate\Database\Eloquent\Model
    {
        return $this->app->make($this->getModel());
    }

    /**
     * Update a record in the database.
     *
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = []):bool
    {
        return $this->model->update($attributes, $options);
    }

    /**
     * Destroy the models for the given IDs.
     *
     * @param int|string|array $id
     * @return bool
     */
    public function delete($id): bool
    {
        return $this->model->find($id)->destroy($id);
    }

    /**
     * Add a relationship count / exists condition to the query.
     *
     * @param string $relation
     * @return $this
     */
    public function has(string $relation)
    {
        $this->model = $this->model->has($relation);
        return $this;
    }

    /**
     * Set the relationships that should be eager loaded.
     *
     * @param array|string $relations
     * @return $this
     */
    public function with($relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    /**
     * Add subselect queries to count the relations.
     *
     * @param  mixed $relations
     * @return $this
     */
    public function withCount($relations)
    {
        $this->model = $this->model->withCount($relations);
        return $this;
    }

    /**
     * Add a relationship count / exists condition to the query with where clauses.
     *
     * @param string $relation
     * @param \Closure $closure
     * @return $this
     */
    public function whereHas(string $relation, \Closure $closure)
    {
        $this->model = $this->model->whereHas($relation, $closure);
        return $this;
    }

    /**
     * Add an "order by" clause to the query.
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $column, string $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);
        return $this;
    }

    /**
     * Set the hidden attributes for the model.
     *
     * @param array $fields
     * @return $this
     */
    public function hidden(array $fields)
    {
        $this->model->setHidden($fields);
        return $this;
    }

    /**
     * Set the visible attributes for the model.
     *
     * @param array $fields
     * @return $this
     */
    public function visible(array $fields)
    {
        $this->model->setVisible($fields);
        return $this;
    }
}
