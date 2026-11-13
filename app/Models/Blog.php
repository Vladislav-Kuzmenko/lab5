<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Blog extends Model
{
    protected $table = 'blog';
    protected $primaryKey = 'blog_id';

    public const CREATED_AT = 'dt_created';
    public const UPDATED_AT = 'dt_updated';

    protected $fillable = [
        'title',
        'description',
        'text',
        'category_id',
        'user_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(BlogTranslation::class, 'blog_id', 'blog_id');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'blog_team', 'blog_id', 'team_id');
    }

    public function getTranslatedAttribute(string $field, string $locale = 'uk')
    {
        $translation = $this->translations->firstWhere('locale', $locale);
        if ($translation && !empty($translation->$field)) {
            return $translation->$field;
        }
        return $this->$field;
    }
}
