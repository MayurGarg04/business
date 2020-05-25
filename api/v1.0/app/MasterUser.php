<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterUser extends Model
{
	protected $table = 'master_user';

	public $timestamps = false;
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name', 'email', 'dob', 'city', 'amount', 'phone', 'app_id'   
	];
}