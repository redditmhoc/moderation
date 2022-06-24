<?php

namespace App\Models\ModerationActions;

use App\Models\ImageAttachment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\ModerationActions\Ban
 *
 * @property int $id
 * @property string $reddit_username
 * @property string|null $discord_username
 * @property int|null $discord_id
 * @property string|null $aliases
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property string|null $responsible_user_id
 * @property string|null $summary
 * @property string|null $comments
 * @property string|null $evidence
 * @property int $permanent
 * @property string $platforms
 * @property int $user_can_appeal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $responsibleUser
 * @method static Builder|Ban current()
 * @method static Builder|Ban expired()
 * @method static \Database\Factories\ModerationActions\BanFactory factory(...$parameters)
 * @method static Builder|Ban newModelQuery()
 * @method static Builder|Ban newQuery()
 * @method static Builder|Ban overturned()
 * @method static Builder|Ban permanent()
 * @method static Builder|Ban query()
 * @method static Builder|Ban whereAliases($value)
 * @method static Builder|Ban whereComments($value)
 * @method static Builder|Ban whereCreatedAt($value)
 * @method static Builder|Ban whereDiscordId($value)
 * @method static Builder|Ban whereDiscordUsername($value)
 * @method static Builder|Ban whereEndAt($value)
 * @method static Builder|Ban whereEvidence($value)
 * @method static Builder|Ban whereId($value)
 * @method static Builder|Ban wherePermanent($value)
 * @method static Builder|Ban wherePlatforms($value)
 * @method static Builder|Ban whereRedditUsername($value)
 * @method static Builder|Ban whereResponsibleUserId($value)
 * @method static Builder|Ban whereStartAt($value)
 * @method static Builder|Ban whereSummary($value)
 * @method static Builder|Ban whereUpdatedAt($value)
 * @method static Builder|Ban whereUserCanAppeal($value)
 * @mixin \Eloquent
 * @property-read int|null $duration_in_days
 * @property-read Model|\Eloquent $imageAttachments
 * @property-read bool $is_current
 * @property-read int|null $image_attachments_count
 * @property-read int|null $days_remaining
 * @property int $overturned
 * @property string|null $overturned_by_user_id
 * @property string|null $overturned_reason
 * @property string|null $overturned_at
 * @method static Builder|Ban whereOverturned($value)
 * @method static Builder|Ban whereOverturnedAt($value)
 * @method static Builder|Ban whereOverturnedByUserId($value)
 * @method static Builder|Ban whereOverturnedReason($value)
 * @property-read User|null $overturnedByUser
 */
class Ban extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'reddit_username', 'discord_username', 'discord_id', 'aliases', 'start_at', 'end_at', 'responsible_user_id', 'summary', 'comments', 'evidence', 'permanent', 'platforms', 'user_can_appeal', 'overturned', 'overturned_reason', 'overturned_by_user_id', 'overturned_at'
    ];

    protected $dates = [
        'start_at', 'end_at', 'overturned_at'
    ];

    /**
     * Return the ban length in days.
     *
     * @return int|null
     */
    public function getDurationInDaysAttribute(): ?int
    {
        if (! $this->end_at) return null;
        return $this->start_at->diffInDays($this->end_at);
    }

    /**
     * Return whether the ban is current or not.
     *
     * @return bool
     */
    public function getIsCurrentAttribute(): bool
    {
        return ($this->end_at != null) && ($this->end_at > now());
    }

    /**
     * Return the days remaining of the ban, if current.
     *
     * @return int|null
     */
    public function getDaysRemainingAttribute(): ?int
    {
        if (! $this->is_current) return null;
        return $this->end_at->diffInDays(now());
    }

    /**
     * Return the user responsible for the ban.
     *
     * @return BelongsTo
     */
    public function responsibleUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    /**
     * Return the user responsible for overturning the ban.
     *
     * @return BelongsTo
     */
    public function overturnedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'overturned_by_user_id');
    }

    /**
     * Return images attached to the ban.
     *
     * @return MorphMany
     */
    public function imageAttachments(): MorphMany
    {
        return $this->morphMany(ImageAttachment::class, 'attachable');
    }

    /**
     * Scope to current bans.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeCurrent(Builder $query): Builder
    {
        return $query->where('permanent', false)->whereNotNull('end_at')->whereDate('end_at', '>', now());
    }

    /**
     * Scope to permanent bans.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePermanent(Builder $query): Builder
    {
        return $query->where('permanent', true);
    }

    /**
     * Scope to expired bans.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('permanent', false)->whereNotNull('end_at')->whereDate('end_at', '<', now())->where('overturned', false);
    }

    /**
     * Scope to overturned bans.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOverturned(Builder $query): Builder
    {
        return $query->where('overturned', true);
    }
}
