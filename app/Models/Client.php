<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $fillable = [
    'client_code',
    'name',
    'parent_id',
    'billing_address',
    'service_address',
    'client_reference',
    'cin_no',
    'client_cin',
    'msme_no',
    'msme',
    'iec_no',
    'client_iec',
    'pancard_no',
    'pancard',
    'gst_no',
    'gst',
    'certification',
    'client_type',
    'category_id',
    'subcategory_id',
    'other',
    'status'
  ];
}
