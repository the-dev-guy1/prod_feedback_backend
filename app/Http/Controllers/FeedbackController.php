<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::paginate(10);

        return response()->json(['feedback' => $feedback]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:bug,feature,improvement',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $feedback = Feedback::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category' => $request->input('category'),
            'user_id' => auth()->id(),
        ]);

        return response()->json(['message' => 'Feedback stored successfully', 'feedback' => $feedback]);
    }

    public function show(Feedback $feedback)
    {
        return response()->json(['feedback' => $feedback]);
    }

    public function update(Request $request, Feedback $feedback)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:bug,feature,improvement',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $feedback->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'category' => $request->input('category'),
        ]);

        return response()->json(['message' => 'Feedback updated successfully', 'feedback' => $feedback]);
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return response()->json(['message' => 'Feedback deleted successfully']);
    }
}
