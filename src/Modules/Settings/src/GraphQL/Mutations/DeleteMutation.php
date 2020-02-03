<?php

namespace Unite\UnisysApi\Modules\Settings\GraphQL\Mutations;

use Unite\UnisysApi\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Settings\SettingRepository;
use DB;

class DeleteMutation extends BaseDeleteMutation
{
    protected $attributes = [
        'name' => 'deleteSetting',
    ];

    public function args()
    {
        return [
            'key'   => [
                'type'  => Type::string(),
                'rules' => 'required|string',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        DB::beginTransaction();

        try {
            $object = $this->repository->getSettingByKey($args['key']);
            $object->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            throw $exception;
        }

        return true;
    }

    public function repositoryClass()
    : string
    {
        return SettingRepository::class;
    }
}
