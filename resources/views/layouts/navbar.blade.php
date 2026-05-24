<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid px-4">
        <!-- Brand -->
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <div class="bg-primary text-white rounded p-1 d-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.958l-7.128 2.852a1.5 1.5 0 0 1-1.114 0l-7.128-2.852A1 1 0 0 1 0 12.162V3.5a.5.5 0 0 1 .316-.465l7.127-2.853z"/>
                </svg>
            </div>
            Product Management
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Side Navigation -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold' : '' }}"
                        href="{{ route('dashboard') }}">🏠 Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.*') && !request()->routeIs('products.create') ? 'active fw-semibold' : '' }}"
                        href="{{ route('products.index') }}">📋 Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('products.create') ? 'active fw-semibold' : '' }}"
                        href="{{ route('products.create') }}">➕ Add Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('categories*') ? 'active fw-semibold' : '' }}"
                        href="{{ url('/categories') }}">🏷️ Categories</a>
                </li>
            </ul>

            <!-- Right Side Navigation & Actions -->
            <div class="d-flex align-items-center gap-3">
                <!-- Dark Mode Toggle -->
                <button id="darkModeBtn"
                    class="btn btn-sm btn-outline-light d-flex align-items-center gap-1 rounded-pill px-3">
                    🌙 <span class="d-none d-md-inline">Dark Mode</span>
                </button>

                <!-- User Dropdown & Logout -->
                @auth
                    <div class="dropdown">
                        <button
                            class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 rounded-pill px-3 shadow-sm border-0"
                            type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center"
                                style="width: 24px; height: 24px; font-size: 12px; font-weight: bold;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="fw-medium text-dark">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 rounded-3"
                            aria-labelledby="userDropdown">
                            <li>
                                <div class="px-3 py-2 text-muted small">
                                    Signed in as<br>
                                    <strong class="text-dark">{{ Auth::user()->email }}</strong>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <!-- បានកែសម្រួលត្រង់នេះ៖ ប្តូរទៅជា href="#" ដើម្បីកុំឱ្យជួបកំហុស RouteNotFound -->
                            <li class="px-2">
                                <a class="dropdown-item rounded" href="#">👤 Profile</a>
                            </li>

                            <li class="px-2">
                                <!-- Logout Form -->
                                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item rounded text-danger d-flex align-items-center gap-2 w-100 fw-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                            <path fill-rule="evenodd"
                                                d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <!-- Direct Logout Button -->
                    <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1 rounded-pill px-3 shadow-sm border-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Style overrides for dark mode support in the dropdown -->
<style>
    body.dark-mode .dropdown-menu {
        background-color: #1e1e1e;
        border: 1px solid #333;
    }

    body.dark-mode .dropdown-item {
        color: #e0e0e0;
    }

    body.dark-mode .dropdown-item:hover {
        background-color: #2a2a2a;
        color: #fff;
    }

    body.dark-mode .text-muted.small {
        color: #aaa !important;
    }

    body.dark-mode .text-dark {
        color: #fff !important;
    }

    body.dark-mode .dropdown-divider {
        border-color: #444;
    }
</style>
