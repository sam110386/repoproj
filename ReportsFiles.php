<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ReportsFiles extends Model
{
     //use Notifiable;

    protected $fillable = [
        'reports_id',
        'filename'
        
    ];

/*
protected $hidden = [
        'password', 'remember_token',
    ];
    */ 
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.reports_files'));

        parent::__construct($attributes);
    }
}
