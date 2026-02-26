<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientJob extends Model
{
  use HasFactory;
  protected $fillable = [
    'client_id',
    'machine_id',
    'complaint_no',
    'complaint_date',
    'caller_name',
    'caller_contact',
    'caller_type',
    'call_for',
    'call_description',
    'call_tasks_list',
    'attachments',
  ];
}
