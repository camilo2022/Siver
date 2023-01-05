<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes';

	protected $fillable = [
		'codigobarras',
		'pathimg1',
		'pathimg2'
	];

}