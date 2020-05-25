<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterAdmin extends Model
{

	protected $table = 'master_admin';

	public $timestamps = false;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_name', 'email'
	];

    protected $hidden = ['user_key'];

}