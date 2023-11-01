<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
		$response = User::query();
		
		if ($request->search) {
			$keyword=$request->search;
			$response->where(function($query) use ($keyword) {
				$query->where('name', 'like', '%'.$keyword.'%')
				->orWhere('email', 'like', '%'.$keyword.'%');
			}); 
		}

		if ($request->filter != 'all') {
			$response->where('role', '=', $request->filter);
			// return response("if block");
		}
		return UserResource::collection($response->orderBy('id', 'desc')->paginate(5)); // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data=$request->validated();
		$data['password'] = bcrypt($data['password']);
		$user = User::create($data);
		return response(new UserResource($user), 201);
	}

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data=$request->validated();
		if (isset($data['password'])) {
			$data['password'] = bcrypt($data['password']);
		}
		$user->update($data);
		return response(new UserResource($user), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

		return response('', 204);
    }
}
