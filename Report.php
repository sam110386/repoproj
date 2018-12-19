<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Report extends Model
{
   //use Notifiable;

    protected $fillable = [
        'report_category',
        'submission_period'
        
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

        $this->setTable(config('admin.database.reports'));

        parent::__construct($attributes);
    }

}
