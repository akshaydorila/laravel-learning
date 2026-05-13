const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
              document.querySelector('input[name="_token"]')?.value;
let currentCommentEditId = null;

$(document).ready(function () {
    loadArticles();
    setupEventListeners();
});

function loadArticles() {
    $.ajax({
        url: '/api/articles',
        type: 'GET',
        dataType: 'json',
        success: function (articles) {
            displayArticles(articles);
        },
        error: function (xhr, status, error) {
            console.error('Error loading articles:', error);
            showError('Failed to load articles');
        }
    });
}

function displayArticles(articles) {
    const tbody = $('#articleTableBody');
    const emptyState = $('#emptyState');

    tbody.empty();

    if (articles.length === 0) {
        emptyState.removeClass('d-none');
        return;
    }

    emptyState.addClass('d-none');

    articles.forEach(article => {
        const createdAt = new Date(article.created_at).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });

        const content = article.content ? escapeHtml(article.content.substring(0, 100)) + (article.content.length > 100 ? '...' : '') : '<span class="text-muted">-</span>';
        const commentCount = article.comments_count || 0;

        const row = `
            <tr>
                <td>
                    <strong>${escapeHtml(article.title)}</strong>
                </td>
                <td>
                    ${content}
                </td>
                <td>
                    <small class="text-muted">${createdAt}</small>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-info btn-sm me-1" onclick="openCommentsModal(${article.id})" data-mdb-ripple-init title="Comments">
                            <i class="fas fa-comments"></i>
                            <span class="badge bg-white text-dark ms-1">${commentCount}</span>
                        </button>
                        <button type="button" class="btn btn-primary btn-sm me-1" onclick="editArticle(${article.id})" data-mdb-ripple-init title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(${article.id}, '${escapeJs(article.title)}')" data-mdb-ripple-init title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;

        tbody.append(row);
    });
}

function setupEventListeners() {
    $('#articleForm').on('submit', function (e) {
        e.preventDefault();
        saveArticle();
    });

    $('#confirmDeleteBtn').on('click', function () {
        deleteArticle();
    });

    $('#commentForm').on('submit', function (e) {
        e.preventDefault();
        saveComment();
    });
}

function openAddModal() {
    clearArticleForm();
    $('#articleModalTitle').text('Add Article');
    $('#submitArticleBtnText').text('Save Article');
    const modal = mdb.Modal.getOrCreateInstance(document.getElementById('articleModal'));
    modal.show();
}

function editArticle(id) {
    $.ajax({
        url: `/articles/${id}`,
        type: 'GET',
        dataType: 'json',
        success: function (article) {
            $('#articleId').val(article.id);
            $('#articleTitle').val(article.title);
            $('#articleContent').val(article.content);
            $('#articleModalTitle').text('Edit Article');
            $('#submitArticleBtnText').text('Update Article');

            const modal = mdb.Modal.getOrCreateInstance(document.getElementById('articleModal'));
            modal.show();
        },
        error: function (xhr, status, error) {
            console.error('Error loading article:', error);
            showError('Failed to load article');
        }
    });
}

function saveArticle() {
    clearArticleErrors();

    const articleId = $('#articleId').val();
    const title = $('#articleTitle').val().trim();
    const content = $('#articleContent').val().trim();

    const url = articleId ? `/articles/${articleId}` : '/articles';
    const method = articleId ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        type: method,
        dataType: 'json',
        data: {
            _token: token,
            title: title,
            content: content,
            _method: method,
        },
        success: function (response) {
            if (response.success) {
                showSuccess(response.message);
                const modal = mdb.Modal.getOrCreateInstance(document.getElementById('articleModal'));
                modal.hide();
                clearArticleForm();
                loadArticles();
            }
        },
        error: function (xhr, status, error) {
            console.error('Error saving article:', error);
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                displayArticleErrors(xhr.responseJSON.errors);
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                showError(xhr.responseJSON.message);
            } else {
                showError('Failed to save article');
            }
        }
    });
}

function confirmDelete(id, title) {
    window.deleteArticleId = id;
    $('#deleteItemTitle').text(title);
    const modal = mdb.Modal.getOrCreateInstance(document.getElementById('deleteModal'));
    modal.show();
}

function deleteArticle() {
    const id = window.deleteArticleId;

    $.ajax({
        url: `/articles/${id}`,
        type: 'DELETE',
        dataType: 'json',
        data: {
            _token: token,
            _method: 'DELETE',
        },
        success: function (response) {
            if (response.success) {
                showSuccess(response.message);
                const modal = mdb.Modal.getInstance(document.getElementById('deleteModal'));
                if (modal) {
                    modal.hide();
                }
                loadArticles();
            }
        },
        error: function (xhr, status, error) {
            console.error('Error deleting article:', error);
            if (xhr.responseJSON && xhr.responseJSON.message) {
                showError(xhr.responseJSON.message);
            } else {
                showError('Failed to delete article');
            }
        }
    });
}

function openCommentsModal(articleId) {
    currentCommentEditId = null;
    $('#commentsArticleId').val(articleId);
    $('#commentEditId').val('');
    $('#commentFormTitle').text('Add Comment');
    $('#commenterName').val('');
    $('#commentContent').val('');
    $('#commentContentError').text('');
    $('#commentContent').removeClass('is-invalid');
    $('#cancelCommentEditBtn').addClass('d-none');
    $('#commentsList').empty();
    $('#commentsEmpty').addClass('d-none');
    $('#commentsLoading').removeClass('d-none');
    $('#commentsModalTitle').text('Comments');
    $('#commentsArticleTitle').text('Loading article...');

    const commentsModal = mdb.Modal.getOrCreateInstance(document.getElementById('commentsModal'));
    commentsModal.show();

    $.ajax({
        url: `/articles/${articleId}`,
        type: 'GET',
        dataType: 'json',
        success: function (article) {
            $('#commentsArticleTitle').text(article.title);
        },
        error: function () {
            $('#commentsArticleTitle').text('Unknown article');
        }
    });

    $.ajax({
        url: `/api/articles/${articleId}/comments`,
        type: 'GET',
        dataType: 'json',
        success: function (comments) {
            $('#commentsLoading').addClass('d-none');
            displayComments(comments);
        },
        error: function (xhr, status, error) {
            console.error('Error loading comments:', error);
            $('#commentsLoading').addClass('d-none');
            showError('Failed to load comments');
        }
    });
}

function displayComments(comments) {
    const list = $('#commentsList');
    list.empty();

    if (comments.length === 0) {
        $('#commentsEmpty').removeClass('d-none');
        return;
    }

    $('#commentsEmpty').addClass('d-none');

    comments.forEach(comment => {
        list.append(renderCommentItem(comment));
    });
}

function renderCommentItem(comment) {
    const createdAt = new Date(comment.created_at).toLocaleString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });

    return `
        <div id="commentItem${comment.id}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
            <div class="me-3 w-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <strong>${escapeHtml(comment.commenter_name || 'Guest')}</strong>
                        <p class="mb-1 mt-2">${escapeHtml(comment.content)}</p>
                    </div>
                    <small class="text-muted">${createdAt}</small>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="prepareEditComment(${comment.id}, '${escapeJs(comment.commenter_name || 'Guest')}', '${escapeJs(comment.content)}')" title="Edit comment" data-mdb-ripple-init>
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteComment(${comment.id})" title="Delete comment" data-mdb-ripple-init>
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
}

function saveComment() {
    clearCommentErrors();

    const articleId = $('#commentsArticleId').val();
    const commenterName = $('#commenterName').val().trim();
    const content = $('#commentContent').val().trim();
    const commentId = $('#commentEditId').val();
    const isEditing = Boolean(commentId);

    const url = isEditing ? `/api/comments/${commentId}` : `/api/articles/${articleId}/comments`;
    const type = isEditing ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        type: type,
        dataType: 'json',
        data: {
            _token: token,
            commenter_name: commenterName,
            content: content,
            _method: type,
        },
        success: function (response) {
            if (response.success) {
                showSuccess(response.message);

                if (isEditing) {
                    updateCommentInList(response.comment);
                    resetCommentForm();
                } else {
                    appendComment(response.comment);
                    $('#commenterName').val('');
                    $('#commentContent').val('');
                    $('#commentsEmpty').addClass('d-none');
                }

                loadArticles();
            }
        },
        error: function (xhr, status, error) {
            console.error('Error saving comment:', error);
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                displayCommentErrors(xhr.responseJSON.errors);
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                showError(xhr.responseJSON.message);
            } else {
                showError('Failed to save comment');
            }
        }
    });
}

function deleteComment(id) {
    if (!confirm('Delete this comment?')) {
        return;
    }

    $.ajax({
        url: `/api/comments/${id}`,
        type: 'DELETE',
        dataType: 'json',
        data: {
            _token: token,
            _method: 'DELETE',
        },
        success: function (response) {
            if (response.success) {
                showSuccess(response.message);
                $(`#commentItem${id}`).remove();
                if ($('#commentsList').children().length === 0) {
                    $('#commentsEmpty').removeClass('d-none');
                }
                loadArticles();
            }
        },
        error: function (xhr, status, error) {
            console.error('Error deleting comment:', error);
            if (xhr.responseJSON && xhr.responseJSON.message) {
                showError(xhr.responseJSON.message);
            } else {
                showError('Failed to delete comment');
            }
        }
    });
}

function prepareEditComment(id, commenterName, content) {
    currentCommentEditId = id;
    $('#commentEditId').val(id);
    $('#commenterName').val(commenterName !== 'Guest' ? commenterName : '');
    $('#commentContent').val(content);
    $('#commentFormTitle').text('Edit Comment');
    $('#cancelCommentEditBtn').removeClass('d-none');
}

function resetCommentForm() {
    currentCommentEditId = null;
    $('#commentEditId').val('');
    $('#commenterName').val('');
    $('#commentContent').val('');
    $('#commentContentError').text('');
    $('#commentContent').removeClass('is-invalid');
    $('#commentFormTitle').text('Add Comment');
    $('#cancelCommentEditBtn').addClass('d-none');
}

function appendComment(comment) {
    $('#commentsList').append(renderCommentItem(comment));
}

function updateCommentInList(comment) {
    const item = renderCommentItem(comment);
    $(`#commentItem${comment.id}`).replaceWith(item);
}

function clearArticleForm() {
    $('#articleForm')[0].reset();
    $('#articleId').val('');
    clearArticleErrors();
}

function clearArticleErrors() {
    $('#titleError').text('');
    $('#articleTitle').removeClass('is-invalid');
    $('#contentError').text('');
    $('#articleContent').removeClass('is-invalid');
}

function displayArticleErrors(errors) {
    if (errors.title) {
        $('#titleError').text(errors.title[0]);
        $('#articleTitle').addClass('is-invalid');
    }
    if (errors.content) {
        $('#contentError').text(errors.content[0]);
        $('#articleContent').addClass('is-invalid');
    }
}

function clearCommentErrors() {
    $('#commentContentError').text('');
    $('#commentContent').removeClass('is-invalid');
}

function displayCommentErrors(errors) {
    if (errors.content) {
        $('#commentContentError').text(errors.content[0]);
        $('#commentContent').addClass('is-invalid');
    }
}

function showSuccess(message) {
    const alert = $('#successAlert');
    $('#successMessage').text(message);
    alert.removeClass('d-none');

    setTimeout(function () {
        alert.addClass('d-none');
    }, 4000);
}

function showError(message) {
    const alert = $('#errorAlert');
    $('#errorMessage').text(message);
    alert.removeClass('d-none');

    setTimeout(function () {
        alert.addClass('d-none');
    }, 4000);
}

function escapeHtml(text) {
    if (!text) return '';
    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function escapeJs(text) {
    if (!text) return '';
    return String(text)
        .replace(/\\/g, '\\\\')
        .replace(/'/g, "\\'")
        .replace(/"/g, '\\"')
        .replace(/\r?\n/g, '\\n');
}
