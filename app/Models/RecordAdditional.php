<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $count
 * @property ?string $properties
 * @property bool $can_joint_purchases
 * @property string $unit
 * @property ?string $image
 * @property bool $can_display_on_main
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class RecordAdditional extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_id',
    ];
}
