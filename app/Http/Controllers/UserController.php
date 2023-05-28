<?php

namespace App\Http\Controllers;

use App\Http\Resources\FriendRequestResource;
use App\Http\Resources\PostResource;
use App\Models\FriendList;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function search(Request $request): Response
    {
        $query = $request->query('query');
        return Response([
            "users" =>
                User::where('name', 'like', '%' . $query . '%')
                    ->get()
        ]);
    }

    /**
     * @param int $id
     * @return Response
     */
    public function getSelectedUser(int $id): Response
    {
        return Response([
            "user" => User::where('id', $id)->first(),
            "isFriend" => FriendList::where([
                    'user_id' => Auth::id(),
                    'friend_id' => $id,
                    'accepted' => 1
                ])->whereOr([
                    'user_id' => $id,
                    'friend_id' => Auth::id(),
                    'accepted' => 1
                ])->count() > 0,
            "requested_sent" => FriendList::where([
                    'user_id' => Auth::id(),
                    'friend_id' => $id,
                    'accepted' => null
                ])->whereOr([
                    'user_id' => $id,
                    'friend_id' => Auth::id(),
                    'accepted' => null
                ])->count() > 0,
            "posts" => PostResource::collection(
                Post::where('user_id', '=', $id)->get()
            )
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addFriend(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int'
        ]);

        if ($validator->fails()) {
            return Response(['error' => $validator->errors()], 400);
        }

        $id = $request->get('id');

        $checkUp = FriendList::where([
            'user_id' => Auth::id(),
            'friend_id' => $id,
            'requested_by' => Auth::id()
        ])->whereOr([
            'user_id' => $id,
            'friend_id' => Auth::id(),
            'requested_by' => Auth::id()
        ])->count();

        if ($checkUp > 0) {
            return Response([
                'error' => 'Request already sent!'
            ]);
        }

        $friendRequest = FriendList::create([
            'user_id' => Auth::id(),
            'friend_id' => $id,
            'requested_by' => Auth::id()
        ]);

        FriendList::create([
            'user_id' => $id,
            'friend_id' => Auth::id(),
            'requested_by' => Auth::id()
        ]);

        return Response(["response" => FriendRequestResource::collection($friendRequest)], 200);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function acceptFriend(Request $request): Response
    {
        $friendRequestId = $request->get('id');
        $status = $request->get('status');
        $userId = $request->get('user_id');

        FriendList::where('id', $friendRequestId)->update([
            'accepted' => $status
        ]);

        FriendList::where(['user_id' => Auth::id(), 'friend_id' => $userId])->update([
            'accepted' => $status
        ]);

        return Response(["response" => $status]);
    }

    /**
     * @return Response
     */
    public function getFriendList(): Response
    {
        return Response([
            'friends' => User::join('friend_list as fl', 'users.id', '=', 'fl.user_id')
                ->select(['name', "surname", "email", "users.id"])
                ->get()->flatten()->unique("name")
        ]);
    }

    public function removeFriend(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|int'
        ]);

        if ($validator->fails()) {
            return Response(['error' => $validator->errors()], 400);
        }

        FriendList::where([
            'user_id' => Auth::id(),
            'friend_id' => $request->get('id')
        ])->delete();

        FriendList::where([
            'user_id' => $request->get('id'),
            'friend_id' => Auth::id(),
        ])->delete();

        return Response([
           "message" => "Removed",
           "status" => true
        ]);
    }
}
