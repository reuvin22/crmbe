<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDataRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::orderBy('id', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserDataRequest $request)
    {
        $data = $request->only('fName', 'lName', 'email', 'contactNumber');
        $user = User::create($data);

        if(!$user){
            return response()->json([
                'status' => 400,
                'message' => 'Failed to Insert Data'
            ], 400);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Data Inserted Successfully',
            'data' => $user
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::find($id);
        if($data === null){
            return response()->json([
                'status' => 400,
                'message' => 'No Record Found'
            ], 400);
        }

        return response()->json([
            'status' => 200,
            'data' => $data
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserDataRequest $request, string $id)
    {
        $user = User::find($id);
        if($user === null){
            return response()->json([
                'status' => 400,
                'message' => 'No Record Found'
            ], 400);
        }

        $data = $request->only('fName', 'lName', 'email', 'contactNumber');
        $updated = $user->update($data);

        if(!$updated) {
            return response()->json([
                'status' => 400,
                'message' => 'Failed to Update User'
            ], 400);
        }

        return response()->json([
            'status' => 200,
            'message' => 'User Updated Successfully',
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if($user === null){
            return response()->json([
                'status' => 400,
                'message' => 'No Record Found'
            ], 400);
        }

        $delete = $user->delete();

        if(!$delete) {
            return response()->json([
                'status' => 400,
                'message' => 'Failed to Delete User'
            ], 400);
        }

        return response()->json([
            'status' => 200,
            'message' => 'User Deleted Successfully'
        ], 200);
    }
}
