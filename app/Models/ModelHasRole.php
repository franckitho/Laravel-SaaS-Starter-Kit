<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;

class ModelHasRole extends Model
{
    use HasFactory;

    protected $table = 'model_has_roles';

    protected $primaryKey = 'role_id';

    protected $fillable = ['model_id', 'roles_id', 'model_type'];

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
