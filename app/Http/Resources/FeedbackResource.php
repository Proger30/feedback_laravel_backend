<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FeedbackResource extends JsonResource
{
	public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
			'id'=>$this->id,
			'subject'=>$this->subject,
			'category'=>$this->category,
			'messages'=>$this->messages,
			'file'=>$this->file,
			'user_name'=>$this->user->name,
			'user_email'=>$this->user->email,
			'user_id'=>$this->user->id,
			'isAnswered'=>$this->isAnswered,
			'created_at'=>$this->created_at->format('Y-m-d H:i:s'),
		];
    }
}
