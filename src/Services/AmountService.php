<?php

namespace Unite\UnisysApi\Services;

use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Models\ModelWithAmount;

class AmountService extends AbstractService
{
    const DIRECTION_INCREASE = 'increase';
    const DIRECTION_DECREASE = 'decrease';
    const DIRECTION_DECIDE = 'decide';

    public static function getTypes(): array
    {
        return [
            self::DIRECTION_INCREASE,
            self::DIRECTION_DECREASE,
            self::DIRECTION_DECIDE,
        ];
    }

    public function updateAttributeByAmount(Model $model, string $attribute, ModelWithAmount $source, string $type, bool $unsigned = true)
    {
        if ($type === self::DIRECTION_INCREASE) {
            $model->{$attribute} += $source->amount;
        } elseif ($type === self::DIRECTION_DECREASE) {
            $model->{$attribute} -= $source->amount;
        } elseif ($type === self::DIRECTION_DECIDE) {
            $original = $source->getOriginal();

            if (isset($original['amount']) && $source->amount !== $original['amount']) {
                $model->{$attribute} -= $original['amount'];
                $model->{$attribute} += $source->amount;
            }
        }

        if($unsigned && $model->{$attribute} < 0) {
            $model->{$attribute} = 0;
        }

        $model->save();
    }
}