<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
  protected $table = 'client_machines';
  use HasFactory;
  use SoftDeletes;
  protected $fillable = [
    'client_id',
    'department_id',
    'machine_type',
    'name',
    'add_type',
    'type',
    'make_model',
    'offer_details',
    'offer_details_file',
    'po_details',
    'po_details_file',
    'invoice',
    'invoice_file',
    'serial',
    'platform_size',
    'platform_max_capacity',
    'platform_min_capacity',
    'platform_least_count',
    'loadcell_modal',
    'loadcell_type',
    'loadcell_capacity',
    'loadcell_serial_no',
    'system_modal',
    'system_type',
    'system_cables',
    'system_least_count',
    'jb_modal',
    'jb_ports',
    'inclusion',
    'inclusionAdditional',
    'exclusion',
    'exclusionAdditional',
    'specification',
    'description',
    'stamping_vc',
    'brochure',
    'datasheet',
    'product_link',
    'machine_model',
];

  protected $casts = [
    'inclusion' => 'array',
    'exclusion' => 'array',
    'additional' => 'array',
  ];
}
