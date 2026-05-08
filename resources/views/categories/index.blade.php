@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list fa-fw me-2"></i>Categories Management
                    </h5>
                    <button class="btn btn-light btn-sm" data-mdb-ripple-init onclick="openAddModal()">
                        <i class="fas fa-plus fa-fw me-1"></i>Add Category
                    </button>
                </div>
                <div class="card-body">
                    <!-- Success Alert -->
                    <div id="successAlert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <span id="successMessage"></span>
                        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <!-- Error Alert -->
                    <div id="errorAlert" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <span id="errorMessage"></span>
                        <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <!-- Categories Table -->
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="categoriesTable">
                            <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="categoryTableBody">
                                <!-- Categories will be loaded here via AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    <div id="emptyState" class="text-center py-5 d-none">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No categories found. Click "Add Category" to create one.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Category Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" data-mdb-backdrop="static" data-mdb-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitle">Add Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="categoryForm">
                    <div class="modal-body">
                        <input type="hidden" id="categoryId">
                        @csrf

                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="categoryName" placeholder="Enter category name" required>
                            <div class="invalid-feedback" id="nameError"></div>
                        </div>

                        <div class="mb-3">
                            <label for="categoryDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="categoryDescription" rows="4" placeholder="Enter category description"></textarea>
                            <div class="invalid-feedback" id="descriptionError"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Close
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-save me-1"></i><span id="submitBtnText">Save Category</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" data-mdb-backdrop="static" data-mdb-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this category?</p>
                    <p class="text-danger fw-bold" id="deleteItemName"></p>
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
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/categories.js') }}"></script>
@endpush
