<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Soft-archive via archived_at (null = active).
 * Normal queries exclude archived rows; use withArchived() / onlyArchived().
 */
trait Archivable
{
    public static function bootArchivable(): void
    {
        static::addGlobalScope('not_archived', function (Builder $builder): void {
            $builder->whereNull($builder->getModel()->getQualifiedArchivedAtColumn());
        });
    }

    public function initializeArchivable(): void
    {
        if (! isset($this->casts['archived_at'])) {
            $this->casts['archived_at'] = 'datetime';
        }
    }

    public function getArchivedAtColumn(): string
    {
        return 'archived_at';
    }

    public function getQualifiedArchivedAtColumn(): string
    {
        return $this->qualifyColumn($this->getArchivedAtColumn());
    }

    public function archive(): bool
    {
        $this->{$this->getArchivedAtColumn()} = $this->freshTimestamp();

        return $this->save();
    }

    public function unarchive(): bool
    {
        $this->{$this->getArchivedAtColumn()} = null;

        return $this->save();
    }

    public function isArchived(): bool
    {
        return $this->{$this->getArchivedAtColumn()} !== null;
    }

    /**
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    public function scopeWithArchived(Builder $query): Builder
    {
        return $query->withoutGlobalScope('not_archived');
    }

    /**
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    public function scopeOnlyArchived(Builder $query): Builder
    {
        return $query->withoutGlobalScope('not_archived')
            ->whereNotNull($this->getQualifiedArchivedAtColumn());
    }
}
