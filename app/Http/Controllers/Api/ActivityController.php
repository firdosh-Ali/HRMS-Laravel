<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Activity;
use Validator;

class ActivityController extends Controller
{
    public function index()
    {
        return Activity::all();
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'updateStatus' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'updateStatus' => 'The Update status field is required',
            'name' => 'The name field is required.',
            'description' => 'The description field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ], 401);
        }

        $activity = $request->only('name', 'description','updateStatus');
        Activity::create($activity);

        return response()->json([
            'success' => true,
            'message' => 'Activity created successfully',
            'data' => $activity
        ],201);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'updateStatus' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'updateStatus' => 'The Update status field is required',
            'name' => 'The name field is required.',
            'description' => 'The description field is required.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ], 401);
        }
        $activity = Activity::find($id);
        if (!$activity) {
            return response()->json([
                'success' => false,
                'message' => 'Activity not found',
            ], 404);
        }
        $activity->update($request->only('name', 'description', 'updateStatus'));


        return response()->json([
            'success' => true,
            'message' => 'Activity updated successfully',
            'data' => $activity
        ], 200);
    }

public function destroy($id){

        $activity = Activity::find($id);

        if(!$activity){
            return response()->json([
                'sucess' => false,
                'message' => 'Activity not found'
            ],404);
        }

        $activity->delete();

        return response()->json([
            'success'=> true,
            'message'=> 'Activity deleted successfully'
        ],200);
}
}
