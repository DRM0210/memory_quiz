<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['client_id','name','address','description'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
