<?php

namespace App\Models;

use App\Traits\HasAddresses;
use App\Traits\HasEmails;
use App\Traits\HasPhones;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $middle_name
 **/
class Person extends AbstractModel
{
    use HasFactory, HasPhones, HasEmails, HasAddresses;

    protected $table = 'persons';
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
