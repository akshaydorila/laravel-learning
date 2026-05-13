@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-newspaper fa-fw me-2"></i>Articles Management
                    </h5>
                    <button class="btn btn-light btn-sm" data-mdb-ripple-init onclick="openAddModal()">
                        <i class="fas fa-plus fa-fw me-1"></i>Add Article
                    </button>
                </div>
                <div class="card-body">
                    <div id="successAlert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <span id="successMessage"></span>
                        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div id="errorAlert" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <span id="errorMessage"></span>
                        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="articlesTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="articleTableBody">
                                <!-- Articles will be loaded here via AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <div id="emptyState" class="text-center py-5 d-none">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No articles found. Click "Add Article" to create one.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="articleModal" tabindex="-1" data-mdb-backdrop="static" data-mdb-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="articleModalTitle">Add Article</h5>
                    <button type="button" class="btn-close btn-close-white" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="articleForm">
                    <div class="modal-body">
                        <input type="hidden" id="articleId">
                        @csrf

                        <div class="mb-3">
                            <label for="articleTitle" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="articleTitle" placeholder="Enter article title" required>
                            <div class="invalid-feedback" id="titleError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="articleContent" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="articleContent" rows="6" placeholder="Enter article content" required></textarea>
                            <div class="invalid-feedback" id="contentError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Close
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitArticleBtn">
                            <i class="fas fa-save me-1"></i><span id="submitArticleBtnText">Save Article</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" data-mdb-backdrop="static" data-mdb-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete Article</h5>
                    <button type="button" class="btn-close btn-close-white" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this article?</p>
                    <p class="text-danger fw-bold" id="deleteItemTitle"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="commentsModal" tabindex="-1" data-mdb-backdrop="static" data-mdb-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="commentsModalTitle">Comments</h5>
                    <button type="button" class="btn-close btn-close-white" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="commentsArticleId">
                    <div class="mb-3">
                        <p class="mb-1">Article:</p>
                        <h6 id="commentsArticleTitle" class="fw-bold"></h6>
                    </div>

                    <div id="commentsLoading" class="text-center py-4">
                        <div class="spinner-border text-info" role="status"></div>
                        <p class="mt-3 mb-0">Loading comments...</p>
                    </div>

                    <div id="commentsEmpty" class="text-center py-4 d-none">
                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No comments yet. Add the first comment below.</p>
                    </div>

                    <div id="commentsList" class="list-group mb-4"></div>

                    <div class="card bg-light border">
                        <div class="card-body">
                            <h6 id="commentFormTitle" class="card-title">Add Comment</h6>
                            <form id="commentForm">
                                @csrf
                                <input type="hidden" id="commentEditId">
                                <div class="mb-3">
                                    <label for="commenterName" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="commenterName" placeholder="Enter your name">
                                </div>
                                <div class="mb-3">
                                    <label for="commentContent" class="form-label">Comment <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="commentContent" rows="4" placeholder="Write a comment" required></textarea>
                                    <div class="invalid-feedback" id="commentContentError"></div>
                                </div>
                                <button type="submit" class="btn btn-info" id="submitCommentBtn">
                                    <i class="fas fa-paper-plane me-1"></i>Submit Comment
                                </button>
                                <button type="button" class="btn btn-outline-secondary ms-2 d-none" id="cancelCommentEditBtn" onclick="resetCommentForm()">
                                    Cancel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/articles.js') }}"></script>
@endpush
