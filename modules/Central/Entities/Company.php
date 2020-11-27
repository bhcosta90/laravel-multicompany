<?php

namespace Modules\Central\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\{Model, Factories\HasFactory, SoftDeletes};
use Illuminate\Support\Str;
use Modules\Integration\Traits\Model\UuidGenerate;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use HasFactory, UuidGenerate, SoftDeletes, HasApiTokens;

    protected $fillable = [
        'name',
        'document',
        'domain',
        'license',
        'date_start',
    ];

    protected $casts = [
        'date_start' => 'date',
        'date_expired' => 'date',
    ];

    public function setDocumentAttribute($value)
    {
        $this->attributes['document'] = Str::onlyNumber($value);
    }
    
    protected static function newFactory()
    {
        return \Modules\Central\Database\factories\CompanyFactory::new();
    }
}
