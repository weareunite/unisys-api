<?php

namespace Unite\UnisysApi\GraphQL\Mutations;

use Rebing\GraphQL\Support\Mutation as BaseMutation;
use Unite\UnisysApi\Contracts\Repository;

abstract class Mutation extends BaseMutation
{
    /** @var Repository  */
    protected $repository;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->repository = app($this->repositoryClass());
    }

    abstract public function repositoryClass(): string;
}
