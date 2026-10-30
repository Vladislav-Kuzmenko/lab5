<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    // Хелпер для отримання локалізованого тексту з фолбеком на замовчуванням
    public function getTranslatedAttribute(string $field, string $locale = 'uk')
    {
        $translation = $this->translations->firstWhere('locale', $locale);
        if ($translation && !empty($translation->$field)) {
            return $translation->$field;
        }
        return $this->$field;
    }
}
