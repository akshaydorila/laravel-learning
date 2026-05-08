// CSRF Token from Laravel
const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
              document.querySelector('input[name="_token"]')?.value;

// Initialize on document ready
$(document).ready(function () {
    loadCategories();
    setupEventListeners();
});

// Load all categories via AJAX
function loadCategories() {
    $.ajax({
        url: '/api/categories',
        type: 'GET',
        dataType: 'json',
        success: function (categories) {
            displayCategories(categories);
        },
        error: function (xhr, status, error) {
            console.error('Error loading categories:', error);
            showError('Failed to load categories');
        }
    });
}

// Display categories in table
function displayCategories(categories) {
    const tbody = $('#categoryTableBody');
    const emptyState = $('#emptyState');

    tbody.empty();

    if (categories.length === 0) {
        emptyState.removeClass('d-none');
        return;
    }

    emptyState.addClass('d-none');

    categories.forEach(category => {
        const createdAt = new Date(category.created_at).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });

        const row = `
            <tr>
                <td>
                    <strong>${escapeHtml(category.name)}</strong>
                </td>
                <td>
                    ${category.description ? escapeHtml(category.description.substring(0, 50)) + (category.description.length > 50 ? '...' : '') : '<span class="text-muted">-</span>'}
                </td>
                <td>
                    <small class="text-muted">${createdAt}</small>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-primary btn-sm me-1" onclick="editCategory(${category.id})" data-mdb-ripple-init title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm ms-1" onclick="confirmDelete(${category.id}, '${escapeHtml(category.name)}')" data-mdb-ripple-init title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;

        tbody.append(row);
    });
}

// Setup event listeners
function setupEventListeners() {
    // Form submission
    $('#categoryForm').on('submit', function (e) {
        e.preventDefault();
        saveCategory();
    });

    // Confirm delete
    $('#confirmDeleteBtn').on('click', function () {
        deleteCategory();
    });
}

// Open Add Modal
function openAddModal() {
    clearForm();
    $('#modalTitle').text('Add Category');
    $('#submitBtnText').text('Save Category');
    const modal = new mdb.Modal(document.getElementById('categoryModal'));
    modal.show();
}

// Edit Category
function editCategory(id) {
    $.ajax({
        url: `/categories/${id}`,
        type: 'GET',
        dataType: 'json',
        success: function (category) {
            $('#categoryId').val(category.id);
            $('#categoryName').val(category.name);
            $('#categoryDescription').val(category.description || '');
            $('#modalTitle').text('Edit Category');
            $('#submitBtnText').text('Update Category');

            const modal = new mdb.Modal(document.getElementById('categoryModal'));
            modal.show();
        },
        error: function (xhr, status, error) {
            console.error('Error loading category:', error);
            showError('Failed to load category');
        }
    });
}

// Save Category (Create or Update)
function saveCategory() {
    const categoryId = $('#categoryId').val();
    const name = $('#categoryName').val().trim();
    const description = $('#categoryDescription').val().trim();

    // Validate
    if (!name) {
        showError('Category name is required');
        return;
    }

    const url = categoryId ? `/categories/${categoryId}` : '/categories';
    const method = categoryId ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        type: method,
        dataType: 'json',
        data: {
            _token: token,
            name: name,
            description: description,
            _method: method
        },
        success: function (response) {
            if (response.success) {
                showSuccess(response.message);

                // Close modal
                const modal = mdb.Modal.getInstance(document.getElementById('categoryModal'));
                if (modal) {
                    modal.hide();
                }

                clearForm();
                loadCategories();
            }
        },
        error: function (xhr, status, error) {
            console.error('Error saving category:', error);
            if (xhr.responseJSON && xhr.responseJSON.message) {
                showError(xhr.responseJSON.message);
            } else {
                showError('Failed to save category');
            }
        }
    });
}

// Confirm Delete
function confirmDelete(id, name) {
    window.deleteId = id;
    $('#deleteItemName').text(name);
    const modal = new mdb.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Delete Category
function deleteCategory() {
    const id = window.deleteId;

    $.ajax({
        url: `/categories/${id}`,
        type: 'DELETE',
        dataType: 'json',
        data: {
            _token: token,
            _method: 'DELETE'
        },
        success: function (response) {
            if (response.success) {
                showSuccess(response.message);

                // Close modal
                const modal = mdb.Modal.getInstance(document.getElementById('deleteModal'));
                if (modal) {
                    modal.hide();
                }

                loadCategories();
            }
        },
        error: function (xhr, status, error) {
            console.error('Error deleting category:', error);
            if (xhr.responseJSON && xhr.responseJSON.message) {
                showError(xhr.responseJSON.message);
            } else {
                showError('Failed to delete category');
            }
        }
    });
}

// Clear Form
function clearForm() {
    $('#categoryForm')[0].reset();
    $('#categoryId').val('');
    $('.invalid-feedback').text('');
}

// Show Success Message
function showSuccess(message) {
    const alert = $('#successAlert');
    $('#successMessage').text(message);
    alert.removeClass('d-none');

    setTimeout(function () {
        alert.addClass('d-none');
    }, 4000);
}

// Show Error Message
function showError(message) {
    const alert = $('#errorAlert');
    $('#errorMessage').text(message);
    alert.removeClass('d-none');

    setTimeout(function () {
        alert.addClass('d-none');
    }, 4000);
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    if (!text) return '';
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}
