<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\IssueReport
 *
 * @property string $id
 * @property string|null $user_id
 * @property string $page_url
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|IssueReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IssueReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IssueReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|IssueReport whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssueReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssueReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssueReport wherePageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssueReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IssueReport whereUserId($value)
 * @mixin \Eloquent
 */
class IssueReport extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id', 'user_id', 'page_url', 'content'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
