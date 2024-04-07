<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelHasPermission extends Model
{
    use HasFactory;

    protected $table = 'model_has_permissions';

    protected $primaryKey = 'permission_id';

    protected $fillable = ['model_id', 'permission_id', 'model_type'];

    public function permissions()
    {
        return $this->belongsTo(Permission::class, 'permission_id', 'id');
    }
}
