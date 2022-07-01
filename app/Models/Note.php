<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Note
 *
 * @property int $id
 * @property string $reddit_username
 * @property string|null $discord_username
 * @property int|null $discord_id
 * @property string|null $aliases
 * @property string|null $responsible_user_id
 * @property string $content
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note query()
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereAliases($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereDiscordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereDiscordUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereRedditUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereResponsibleUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Models\User|null $responsibleUser
 * @method static \Illuminate\Database\Query\Builder|Note onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Note withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Note withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ImageAttachment[] $imageAttachments
 * @property-read int|null $image_attachments_count
 * @method static \Database\Factories\NoteFactory factory(...$parameters)
 */
class Note extends Model
{
    use SoftDeletes, LogsActivity, HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'reddit_username', 'discord_username', 'discord_id', 'aliases', 'responsible_user_id', 'content'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function responsibleUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function imageAttachments(): HasMany
    {
        return $this->hasMany(ImageAttachment::class, 'attachable_id');
    }
}
