<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ClientContact extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['client_id','contact_person','phone','mobile','email','designation','department','billing_address','service_address','status'];
}
