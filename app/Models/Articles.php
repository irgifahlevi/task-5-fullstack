<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Articles extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'content',
        'image',
        'user_id',
        'category_id'
    ];

    // public function categories()
    // {
    //     return $this->belongsTo(Categories::class, 'category_id', 'id');
    // }

    /**
     * Get the user that owns the Articles
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }
}
