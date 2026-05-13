<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use Illuminate\Http\Request;

class ArticleCommentController extends Controller
{
    public function getComments(string $articleId)
    {
        $article = Article::find($articleId);

        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        return response()->json($article->comments()->orderByDesc('id')->get());
    }

    public function store(Request $request, string $articleId)
    {
        $request->validate([
            'content' => 'required|string',
            'commenter_name' => 'nullable|string|max:255',
        ]);

        $article = Article::find($articleId);

        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        $comment = ArticleComment::create([
            'article_id' => $article->id,
            'commenter_name' => $request->commenter_name ?: 'Guest',
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'comment' => $comment,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'content' => 'required|string',
            'commenter_name' => 'nullable|string|max:255',
        ]);

        $comment = ArticleComment::find($id);

        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        $comment->update([
            'commenter_name' => $request->commenter_name ?: 'Guest',
            'content' => $request->content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully',
            'comment' => $comment,
        ]);
    }

    public function destroy(string $id)
    {
        $comment = ArticleComment::find($id);

        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully',
        ]);
    }
}
