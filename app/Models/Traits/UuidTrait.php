<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait UuidTrait
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootUuidTrait()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    /**
     * Get the name of the UUID column.
     *
     * @return string
     */
    public function getUuidColumnName()
    {
        return 'uuid';
    }

    /**
     * Get the value of the UUID column.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->{$this->getUuidColumnName()};
    }

    /**
     * Scope a query to find a model by its UUID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUuid($query, $uuid)
    {
        return $query->where($this->getUuidColumnName(), $uuid);
    }
}
