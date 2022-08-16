<?php

namespace App\Models\ModerationActions;

use App\Models\ImageAttachment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\ModerationActions\Mute
 *
 * @property string $id
 * @property string $reddit_username
 * @property string|null $discord_username
 * @property int|null $discord_id
 * @property string|null $aliases
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property string|null $responsible_user_id
 * @property string|null $summary
 * @property string|null $comments
 * @property string|null $evidence
 * @property string $platforms
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read int|null $days_remaining
 * @property-read int|null $duration_in_days
 * @property-read int|null $hours_remaining
 * @property-read bool $is_current
 * @property-read \Illuminate\Database\Eloquent\Collection|ImageAttachment[] $imageAttachments
 * @property-read int|null $image_attachments_count
 * @property-read User|null $responsibleUser
 * @method static Builder|Mute current()
 * @method static Builder|Mute expired()
 * @method static Builder|Mute newModelQuery()
 * @method static Builder|Mute newQuery()
 * @method static \Illuminate\Database\Query\Builder|Mute onlyTrashed()
 * @method static Builder|Mute query()
 * @method static Builder|Mute whereAliases($value)
 * @method static Builder|Mute whereComments($value)
 * @method static Builder|Mute whereCreatedAt($value)
 * @method static Builder|Mute whereDeletedAt($value)
 * @method static Builder|Mute whereDiscordId($value)
 * @method static Builder|Mute whereDiscordUsername($value)
 * @method static Builder|Mute whereEndAt($value)
 * @method static Builder|Mute whereEvidence($value)
 * @method static Builder|Mute whereId($value)
 * @method static Builder|Mute wherePlatforms($value)
 * @method static Builder|Mute whereRedditUsername($value)
 * @method static Builder|Mute whereResponsibleUserId($value)
 * @method static Builder|Mute whereStartAt($value)
 * @method static Builder|Mute whereSummary($value)
 * @method static Builder|Mute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Mute withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Mute withoutTrashed()
 * @mixin \Eloquent
 * @method static \Database\Factories\ModerationActions\MuteFactory factory(...$parameters)
 * @property-read int|null $duration_in_hours
 */
class Mute extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'reddit_username', 'discord_username', 'discord_id', 'aliases', 'start_at', 'end_at', 'responsible_user_id', 'summary', 'comments', 'evidence', 'platforms'
    ];

    protected $dates = [
        'start_at', 'end_at'
    ];

    /**
     * Return the mute length in days.
     *
     * @return int|null
     */
    public function getDurationInDaysAttribute(): ?int
    {
        return !$this->end_at ? null : $this->start_at->diffInDays($this->end_at);
    }

    /**
     * Return the mute length in hours.
     *
     * @return int|null
     */
    public function getDurationInHoursAttribute(): ?int
    {
        return !$this->end_at ? null : $this->start_at->diffInHours($this->end_at);
    }

    /**
     * Return whether the mute is current or not.
     *
     * @return bool
     */
    public function getIsCurrentAttribute(): bool
    {
        return ($this->end_at != null) && ($this->end_at > now());
    }

    /**
     * Return the days remaining of the mute, if current.
     *
     * @return int|null
     */
    public function getDaysRemainingAttribute(): ?int
    {
        if (! $this->is_current) {
            return null;
        }
        return $this->end_at->diffInDays(now());
    }

    /**
     * Return the hours remaining of the mute, if current.
     *
     * @return int|null
     */
    public function getHoursRemainingAttribute(): ?int
    {
        if (! $this->is_current) {
            return null;
        }
        return $this->end_at->diffInHours(now());
    }

    /**
     * Return the user responsible for the mute.
     *
     * @return BelongsTo
     */
    public function responsibleUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    /**
     * Return images attached to the mute.
     *
     * @return MorphMany
     */
    public function imageAttachments(): MorphMany
    {
        return $this->morphMany(ImageAttachment::class, 'attachable');
    }

    /**
     * Scope to current mutes.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeCurrent(Builder $query): Builder
    {
        return $query->where('end_at', '>', now());
    }

    /**
     * Scope to expired mutes.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('end_at', '<', now());
    }

    /**
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
