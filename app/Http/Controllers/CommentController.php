<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Queries\CommentDataTable;
use App\Repositories\CommentRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class CommentController extends AppBaseController
{
    /** @var  CommentRepository */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepo)
    {
        $this->commentRepository = $commentRepo;
    }

    /**
     * Display a listing of the Comment.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new CommentDataTable())
                ->get($request->only(['module_id', 'owner_id',])))
                ->make(true);
        }

        return view('comments.index');
    }

    /**
     * Store a newly created Comment in storage.
     *
     * @param  CreateCommentRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateCommentRequest $request)
    {
        $input = $request->all();

        $comment = $this->commentRepository->create($input);

        return $this->sendResponse($comment, 'Comment saved successfully.');
    }

    /**
     * Show the form for editing the specified Comment.
     *
     * @param  Comment  $comment
     *
     * @return JsonResponse
     */
    public function edit(Comment $comment)
    {
        return $this->sendResponse($comment, 'Comment retrieved successfully.');
    }

    /**
     * Update the specified Comment in storage.
     *
     * @param  Comment  $comment
     *
     * @param  UpdateCommentRequest  $request
     *
     * @return JsonResponse
     */
    public function update(Comment $comment, UpdateCommentRequest $request)
    {
        $comment = $this->commentRepository->update($request->all(), $comment->id);

        activity()->performedOn($comment)->causedBy(getLoggedInUser())
            ->useLog('Comment updated.')
            ->log($comment->description.' Comment updated.');

        return $this->sendSuccess('Comment updated successfully.');
    }

    /**
     * Remove the specified Comment from storage.
     *
     * @param  Comment  $comment
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    public function destroy(Comment $comment)
    {
        activity()->performedOn($comment)->causedBy(getLoggedInUser())
            ->useLog('Comment deleted.')
            ->log($comment->description.' Comment deleted.');

        $this->commentRepository->delete($comment->id);

        return $this->sendSuccess('Comment deleted successfully.');
    }
}
