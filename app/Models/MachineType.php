<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineType extends Model
{
    use HasFactory;

    protected $table = 'machine_types';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    public $timestamps = false;
}
