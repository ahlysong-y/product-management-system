<!-- resources/views/categories/index.blade.php -->
<!DOCTYPE html>
<html lang="km">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>បញ្ជីប្រភេទទិន្នន័យ (Categories)</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Google Fonts (Kantumruy Pro សម្រាប់អក្សរខ្មែរ) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Kantumruy Pro', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm backdrop-blur-md bg-white/90">
        <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-indigo-600 text-white p-2 rounded-lg shadow-md shadow-indigo-100">
                    <!-- Dashboard Icon -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z">
                        </path>
                    </svg>
                </div>
                <span class="text-lg font-bold tracking-wide text-slate-900">គ្រប់គ្រងទិន្នន័យ</span>
            </div>
            <div class="text-sm text-slate-500 font-medium">ឆ្នាំ ២០២៦</div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="max-w-5xl w-full mx-auto px-4 py-8 flex-grow">

        <!-- Alert Notification -->
        @if (session('success'))
            <div
                class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-emerald-800 flex items-center space-x-3 shadow-sm animate-fade-in">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight sm:text-3xl">បញ្ជីប្រភេទទិន្នន័យ</h1>
                <p class="text-sm text-slate-500 mt-1">បង្ហាញព័ត៌មាន និងគ្រប់គ្រងប្រភេទទិន្នន័យទាំងអស់នៅក្នុងប្រព័ន្ធ
                </p>
            </div>
            <div>
                <a href="{{ url('/categories/create') }}"
                    class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-100 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                    បង្កើតប្រភេទថ្មី
                </a>
            </div>
        </div>

        <!-- Data Card / Table Container -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            @if ($categories->isEmpty())
                <!-- Empty State -->
                <div class="p-12 text-center">
                    <div class="inline-flex p-4 bg-slate-50 rounded-full text-slate-400 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-800">មិនទាន់មានទិន្នន័យនៅឡើយទេ</h3>
                    <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">សូមចុចប៊ូតុង "បង្កើតប្រភេទថ្មី"
                        ខាងលើដើម្បីបញ្ចូលទិន្នន័យដំបូងរបស់អ្នក។</p>
                </div>
            @else
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                                <th class="py-4 px-6 w-20 text-center">ល.រ</th>
                                <th class="py-4 px-6">ឈ្មោះប្រភេទទិន្នន័យ</th>
                                <th class="py-4 px-6 text-right">សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                            @foreach ($categories as $index => $category)
                                <tr class="hover:bg-slate-50/70 transition-colors duration-150">
                                    <td class="py-4 px-6 text-center font-normal text-slate-400">{{ $index + 1 }}
                                    </td>
                                    <td class="py-4 px-6 text-slate-950 font-semibold">{{ $category->name }}</td>
                                    <td class="py-4 px-6 text-right">
                                        <!-- Action Buttons Layout 2026 -->
                                        <div class="inline-flex items-center space-x-2">
                                            <button
                                                class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                                title="កែប្រែ">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button
                                                class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                                title="លុប">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Table Footer Info -->
                <div
                    class="bg-slate-50 px-6 py-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                    <div>សរុបសរុប៖ {{ $categories->count() }} ប្រភេទ</div>
                </div>
            @endif
        </div>

    </main>

    <!-- Simple Modern Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-400 font-medium">
        &copy; 2026 រក្សាសិទ្ធិគ្រប់យ៉ាងដោយប្រព័ន្ធគ្រប់គ្រងរបស់អ្នក។
    </footer>

</body>

</html>
