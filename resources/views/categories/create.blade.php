@extends('layouts.app')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..0,700;1,100..0,700&family=Koh+Santepheap:wght@100;300;400;700;900&display=swap"
    rel="stylesheet">

<style>
    /* កំណត់ Font ឱ្យទៅកាន់ Form ទាំងមូល */
    .custom-font-container {
        font-family: 'Koh Santepheap', 'Segoe UI', sans-serif;
    }

    /* កំណត់ Font ពិសេសសម្រាប់ក្បាលរឿង (Headings) */
    .custom-heading {
        font-family: 'Kantumruy Pro', 'Segoe UI', sans-serif;
        font-weight: 700;
    }

    /* បន្ថែមល្បាក់អក្សរឱ្យមើលទៅមានទម្ងន់ទាក់ទាញ */
    .form-label-custom {
        font-size: 0.8rem;
        letter-spacing: 0.8px;
        font-weight: 700;
        color: #6c757d;
    }
</style>

@section('content')
    <div class="container py-5 custom-font-container" style="max-width: 700px;">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="font-size: 0.85rem;">
                <li class="breadcrumb-item">
                    <a href="{{ url('/categories') }}"
                        class="text-decoration-none text-muted d-inline-flex align-items-center gap-1 font-weight-bold">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                        Categories
                    </a>
                </li>
                <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">Create New</li>
            </ol>
        </nav>

        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

            <div class="card-header bg-light border-bottom p-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="p-2.5 bg-primary bg-opacity-10 text-primary rounded-3">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="card-title mb-0 text-dark custom-heading" style="font-size: 1.2rem;">
                            Add New Category</h4>
                        <small class="text-muted"
                            style="font-size: 0.85rem; font-weight: 300;">Please fill in the information below to create a new category</small>
                    </div>
                </div>

                <a href="{{ url('/categories') }}"
                    class="btn btn-sm btn-outline-secondary rounded-3 d-inline-flex align-items-center gap-1 fw-bold"
                    style="font-size: 0.8rem;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0a9 9 0 01-18 0z" />
                    </svg>
                    Back
                </a>
            </div>

            <div class="card-body p-4 p-sm-5">
                <form action="/categories" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="form-label text-muted uppercase form-label-custom mb-2">
                            Category Name <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3 px-3">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <input type="text" name="name" id="name"
                                class="form-control border-start-0 bg-light bg-opacity-20 rounded-end-3 py-2.5"
                                style="font-size: 0.95rem; font-weight: 400;"
                                placeholder="e.g., Office Supplies, Electronics..." required autocomplete="off"
                                value="{{ old('name') }}">
                        </div>

                        @error('name')
                            <div class="alert alert-danger d-flex align-items-center gap-2 mt-2 py-2 px-3 rounded-3"
                                style="font-size: 0.85rem; font-weight: 400;">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0118 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="pt-3 border-top d-flex flex-column-reverse flex-sm-row justify-content-end gap-2"
                        style="font-size: 0.9rem;">
                        <a href="{{ url('/categories') }}"
                            class="btn btn-light border text-secondary fw-bold rounded-3 px-4 py-2">
                            Cancel
                        </a>

                        <button type="submit"
                            class="btn btn-primary fw-bold rounded-3 px-4 py-2 d-inline-flex align-items-center justify-content-center gap-1 shadow-sm">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Category
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection
