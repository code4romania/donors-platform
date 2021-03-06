<?php

declare(strict_types=1);

namespace App\Traits;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;

trait Draftable
{
    /**
     * Include draft records in query results.
     *
     * @param  Builder $query
     * @return void
     */
    public function scopePublished(Builder $query)
    {
        $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now());
    }

    /**
     * Exclude published records from query results.
     *
     * @param  Builder $query
     * @return void
     */
    public function scopeOnlyDrafts(Builder $query)
    {
        $query->where(function (Builder $query) {
            $query
                ->whereNull('published_at')
                ->orWhere('published_at', '>', Carbon::now());
        });
    }

    /**
     * Determine if the model is published.
     *
     * @return bool
     */
    public function isPublished()
    {
        return ! is_null($this->published_at)
            && $this->published_at <= Carbon::now();
    }

    /**
     * Determine if the model is draft.
     *
     * @return bool
     */
    public function isDraft()
    {
        return ! $this->isPublished();
    }

    /**
     * Set the value of the model's published at column.
     *
     * @param  DateTimeInterface|string|null $date
     * @return $this
     */
    public function setPublishedAt($date)
    {
        if (! is_null($date)) {
            $date = Carbon::parse($date);
        }

        $this->published_at = $date;

        return $this;
    }

    /**
     * Set the value of the model's published status.
     *
     * @param  bool  $published
     * @return $this
     */
    public function setPublished($published)
    {
        if (! $published) {
            return $this->setPublishedAt(null);
        }

        if ($this->isDraft()) {
            return $this->setPublishedAt(Carbon::now());
        }

        return $this;
    }

    /**
     * Schedule the model to be published.
     *
     * @param  DateTimeInterface|string|null $date
     * @return $this
     */
    public function publishAt($date)
    {
        $this->setPublishedAt($date)->save();

        return $this;
    }

    /**
     * Mark the model as published.
     *
     * @param  bool  $publish
     * @return $this
     */
    public function publish(bool $publish = true)
    {
        $this->setPublished($publish)->save();

        return $this;
    }

    /**
     * Mark the model as draft.
     *
     * @return $this
     */
    public function draft()
    {
        return $this->publish(false);
    }

    public function getPublishedStatusAttribute()
    {
        return $this->isPublished() ? 'published' : 'draft';
    }
}
