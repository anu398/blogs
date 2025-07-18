<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    
    public const STATUS_PENDING = 'Pending';
    public const STATUS_PUBLISHED = 'Published';
    public const STATUS_REJECTED = 'Rejected';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
