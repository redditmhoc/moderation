<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ImageAttachment
 *
 * @property string $id
 * @property string $url
 * @property string|null $user_id
 * @property string|null $caption
 * @property string $attachable_id
 * @property string $attachable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAttachment whereAttachableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAttachment whereAttachableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAttachment whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAttachment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAttachment whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAttachment whereUserId($value)
 * @mixin \Eloquent
 * @property-read Model|\Eloquent $attachable
 * @property-read \App\Models\User|null $user
 */
class ImageAttachment extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['id', 'user_id', 'attachable_type', 'attachable_id', 'caption', 'url'];

    public function attachable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
