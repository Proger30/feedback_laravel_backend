<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Http\Resources\FeedbackResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */

	 public function index(Request $request)
	 {
		$response = Feedback::query();
		if (Auth::user()->role == 'ROLE_CLIENT') {
			$response->where('user_id', Auth::user()->id);
		} else {
			$response->with('user');
		}
		if ($request->search) {
			$response->where('subject', 'like', '%'.$request->search.'%');
			// return FeedbackResource::collection(Feedback::query()->where('subject', 'like', '%'.$request->search.'%')->orderBy('id', 'desc')->paginate(5)); //
		}
		if ($request->filter != 'all') {
			$response->where('isAnswered', '=', $request->filter == 'answered' ? 1 : 0);
		}
		return  FeedbackResource::collection($response->orderBy('id', 'desc')->paginate(5)); //
	 }
 

    // public function index(Request $request)
    // {
	// 	if (Auth::user()->role == 'ROLE_CLIENT') {
	// 		if ($request->search) {
	// 			return FeedbackResource::collection(Feedback::query()->where('user_id', Auth::user()->id)->where('subject', 'like', '%'.$request->search.'%')->orderBy('id', 'desc')->paginate(5));
	// 		}
	// 		return FeedbackResource::collection(Feedback::query()->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(5)); 
	// 	}
	// 	if ($request->search) {
	// 		return FeedbackResource::collection(Feedback::query()->where('subject', 'like', '%'.$request->search.'%')->with('user')->orderBy('id', 'desc')->paginate(5)); //
	// 	}
	// 	return FeedbackResource::collection(Feedback::query()->with('user')->orderBy('id', 'desc')->paginate(5)); //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeedbackRequest $request)
    {
		$data = $request->validated();
		// return response();
		$file=null;
		if ($request->hasFile('file')) {
			$file = $data['file']->storeAs('public/files', Auth::user()->id . '_' . time() . '_' . $request['file']->getClientOriginalName());
		}
		// $data['messages'] = json_encode($data['messages']);	
		$data['isAnswered'] = false;
		$data['file'] = $file ? $file : '';
		$feedback = Auth::user()->feedbacks()->create($data);
		Auth::user()->update(['last_feedback_created' => now()]);
		return response(new FeedbackResource($feedback), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        return new FeedbackResource($feedback);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        $data=$request->validated();
		$feedback->update($data);
		return response(new FeedbackResource($feedback), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
		if (Storage::exists($feedback['file'])) {
			Storage::delete($feedback['file']);
			echo "Файл успешно удален.";
		} 
        $feedback->delete();

		return response('', 204);
    }


	public function subject() {

		return response(1);
		// return response()->json($request);
		// if (Auth::user()->role == 'ROLE_CLIENT') {
		// 	return FeedbackResource::collection(Feedback::query()->where('user_id', Auth::user()->id)->where('subject', 'like', $search)->orderBy('id', 'desc')->paginate(5));
		// }
		// return FeedbackResource::collection(Feedback::query()->with('user')->orderBy('id', 'desc')->paginate(5));	
	}
}
