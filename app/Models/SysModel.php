<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class SysModel extends Model
{
	public $timestamps = false;
	public $labels;
	public $errors = null;
	public function __construct()
	{
		$this->labels=$this->getLabels();
		$validator = Validator::make(array(),array());
		$this->errors = $validator->messages();
	}
}
