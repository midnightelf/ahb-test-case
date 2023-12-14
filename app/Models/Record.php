<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property float $price
 * @property float $price_sp
 * @property string $level1
 * @property string $level2
 * @property string $level3
 * @property int $record_additionals
 * @property RecordAdditional $additional
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Record extends Model
{
    use HasFactory;

    const CSV_HEADERS = [
        'Код'                 => 'code',
        'Наименование'        => 'name',
        'Уровень1'            => 'level1',
        'Уровень2'            => 'level2',
        'Уровень3'            => 'level3',
        'Цена'                => 'price',
        'ЦенаСП'              => 'price_sp',
        'Количество'          => 'count',
        'Поля свойств'        => 'properties',
        'Совместные покупки'  => 'can_joint_purchases',
        'Единица измерения'   => 'unit',
        'Картинка'            => 'image',
        'Выводить на главной' => 'can_display_on_main',
        'Описание'            => 'description',
    ];

    public function additional(): HasOne
    {
        return $this->hasOne(RecordAdditional::class);
    }
}
