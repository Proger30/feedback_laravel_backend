<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

	protected $fillable = [
        'subject',
        'category',
		'isAnswered',
		'messages',
		'file'
		];

	public function user () {
		return $this->belongsTo(User::class);
	}
}
