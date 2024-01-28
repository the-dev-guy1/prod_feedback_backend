<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MentionedInComment;

class CommentController extends Controller
{
    public function index(Feedback $feedback)
    {
        $comments = $feedback->comments()->paginate(10);

        return response()->json(['comments' => $comments]);
    }

    public function store(Request $request, Feedback $feedback)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $content = $request->input('content');

        // Notify mentioned users
        $mentionedUsers = $this->notifyMentionedUsers($content);

        // Create the comment
        $comment = new Comment([
            'content' => $content,
            'user_id' => auth()->id(),
        ]);

        $feedback->comments()->save($comment);

        // Insert mention data into comments_mentions table
        $this->insertMentionData($comment, $mentionedUsers);

        // Notify mentioned users with the actual comment instance
        Notification::send($mentionedUsers, new MentionedInComment($comment));

        return response()->json(['message' => 'Comment created successfully', 'comment' => $comment]);
    }

    public function show(Feedback $feedback, Comment $comment)
    {
        return response()->json(['comment' => $comment]);
    }

    public function update(Request $request, Feedback $feedback, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $content = $request->input('content');

        // Notify mentioned users
        $mentionedUsers = $this->notifyMentionedUsers($content);

        // Update the comment
        $comment->update([
            'content' => $content,
        ]);

        // Insert mention data into comments_mentions table
        $this->insertMentionData($comment, $mentionedUsers);

        // Notify mentioned users with the actual comment instance
        Notification::send($mentionedUsers, new MentionedInComment($comment));

        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment]);
    }

    public function destroy(Feedback $feedback, Comment $comment)
    {
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }

    private function notifyMentionedUsers($content)
    {
        // Parse the content to find mentioned users
        preg_match_all('/@(\w+)/', $content, $matches);

        // Get usernames from the matches
        $usernames = $matches[1];

        // Find users by username
        $mentionedUsers = User::whereIn('username', $usernames)
            ->where('id', '!=', auth()->id()) // Exclude the logged-in user
            ->get();

        // Notify mentioned users
        Notification::send($mentionedUsers, new MentionedInComment($content));

        return $mentionedUsers;
    }

    private function insertMentionData(Comment $comment, $mentionedUsers)
    {
        // Insert mention data into comments_mentions table
        foreach ($mentionedUsers as $mentionedUser) {
            $comment->mentions()->create([
                'user_id' => $mentionedUser->id,
            ]);
        }
    }
}
