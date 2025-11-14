<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="{{ route('dashboard') }}">
            SMS Portal
        </a>
        <ul class="mt-6">
            <!-- ========== GENERAL LINKS ========== -->
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="ml-4">Dashboard</span>
                </x-nav-link>
            </li>

            <li class="relative px-6 py-3 mt-4">
                <h2 class="font-semibold text-gray-500 uppercase text-xs tracking-wider">Community</h2>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('notices.view')" :active="request()->routeIs('notices.view')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-2.463 9.168-6l-2.732 7.647A4.001 4.001 0 0113 18H4.832c-.471 0-.92-.07-1.34-.201L2.55 19.5l.23-6.503A4.002 4.002 0 015.436 13.683z"></path></svg>
                    <span class="ml-4">Noticeboard</span>
                </x-nav-link>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('calendar.view')" :active="request()->routeIs('calendar.view')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="ml-4">School Calendar</span>
                </x-nav-link>
            </li>

            <li class="relative px-6 py-3 mt-4">
                <h2 class="font-semibold text-gray-500 uppercase text-xs tracking-wider">Resources</h2>
            </li>
             <li class="relative px-6 py-3">
                <x-nav-link :href="route('library.catalog')" :active="request()->routeIs('library.catalog')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path></svg>
                    <span class="ml-4">Library Catalog</span>
                </x-nav-link>
            </li>

            <!-- ========== ADMIN LINKS ========== -->
            @role('Admin')
            <li class="relative px-6 py-3 mt-4">
                <h2 class="font-semibold text-gray-500 uppercase text-xs tracking-wider">Admin Tools</h2>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="ml-4">Manage Students</span>
                </x-nav-link>
            </li>
             <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.staff.index')" :active="request()->routeIs('admin.staff.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span class="ml-4">Manage Staff</span>
                </x-nav-link>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.parents.index')" :active="request()->routeIs('admin.parents.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"></path></svg>
                    <span class="ml-4">Manage Parents</span>
                </x-nav-link>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.sessions.index')" :active="request()->routeIs('admin.sessions.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.546-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="ml-4">Academic Sessions</span>
                </x-nav-link>
            </li>
             <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.classes.index')" :active="request()->routeIs('admin.classes.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span class="ml-4">Classes & Arms</span>
                </x-nav-link>
            </li>
             <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.subjects.index')" :active="request()->routeIs('admin.subjects.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path></svg>
                    <span class="ml-4">Subjects</span>
                </x-nav-link>
            </li>
             <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.exams.index')" :active="request()->routeIs('admin.exams.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span class="ml-4">Exam Settings</span>
                </x-nav-link>
            </li>
             <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.results.process')" :active="request()->routeIs('admin.results.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span class="ml-4">Process Results</span>
                </x-nav-link>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.notices.index')" :active="request()->routeIs('admin.notices.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="ml-4">Manage Notices</span>
                </x-nav-link>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="ml-4">Manage Events</span>
                </x-nav-link>
            </li>

            <li class="relative px-6 py-3 mt-4">
                <h2 class="font-semibold text-gray-500 uppercase text-xs tracking-wider">Admin Tools</h2>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.analytics.index')" :active="request()->routeIs('admin.analytics.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    <span class="ml-4">Analytics & Insights</span>
                </x-nav-link>
            </li>
             <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.students.promote')" :active="request()->routeIs('admin.students.promote')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    <span class="ml-4">Promote Students</span>
                </x-nav-link>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="ml-4">System Settings</span>
                </x-nav-link>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="ml-4">System Settings</span>
                </x-nav-link>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.backups.index')" :active="request()->routeIs('admin.backups.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4M4 7v5c0 2.21 3.582 4 8 4s8-1.79 8-4V7"></path></svg>
                    <span class="ml-4">Backups</span>
                </x-nav-link>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('admin.activity-logs.index')" :active="request()->routeIs('admin.activity-logs.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="ml-4">Activity Logs</span>
                </x-nav-link>
            </li>
            @endrole
            <!-- ========== ACCOUNTANT LINKS ========== -->
            @role('Accountant|Admin')
<li class="relative px-6 py-3 mt-4">
    <a href="{{ route('accountant.dashboard') }}" class="font-semibold text-gray-500 uppercase text-xs tracking-wider hover:text-gray-700 dark:hover:text-gray-300">Finance Portal</a>
</li>
            <li class="relative px-6 py-3 mt-4">
                <h2 class="font-semibold text-gray-500 uppercase text-xs tracking-wider">Finance</h2>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('accountant.fees.index')" :active="request()->routeIs('accountant.fees.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="ml-4">Fee Management</span>
                </x-nav-link>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('accountant.invoices.index')" :active="request()->routeIs('accountant.invoices.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="ml-4">Invoices</span>
                </x-nav-link>
            </li>
            @endrole

            <!-- ========== LIBRARIAN LINKS ========== -->
            @role('Librarian|Admin')
<li class="relative px-6 py-3 mt-4">
    <a href="{{ route('librarian.dashboard') }}" class="font-semibold text-gray-500 uppercase text-xs tracking-wider hover:text-gray-700 dark:hover:text-gray-300">Librarian Portal</a>
</li>
            <li class="relative px-6 py-3 mt-4">
                <h2 class="font-semibold text-gray-500 uppercase text-xs tracking-wider">Librarian</h2>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('librarian.books.index')" :active="request()->routeIs('librarian.books.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v11.494m-9-5.747h18"></path></svg>
                    <span class="ml-4">Manage Catalog</span>
                </x-nav-link>
            </li>
            <li class="relative px-6 py-3">
                <x-nav-link :href="route('librarian.issue-return.index')" :active="request()->routeIs('librarian.issue-return.*')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M7 9l4-4 4 4M4 12h16M4 16v5h5m-5-5l4 4 4-4"></path></svg>
                    <span class="ml-4">Issue / Return Books</span>
                </x-nav-link>
            </li>
            @endrole

            <!-- ========== TEACHER LINKS ========== -->
          
   
        <!-- ========== TEACHER LINKS (UPDATED) ========== -->
        @role('Teacher|Admin')
         <li class="relative px-6 py-3 mt-4">
            <h2 class="font-semibold text-gray-500 uppercase text-xs tracking-wider">Teacher Portal</h2>
        </li>
         <li class="relative px-6 py-3">
            <x-nav-link :href="route('teacher.dashboard')" :active="request()->routeIs('teacher.dashboard')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="ml-4">Teacher Dashboard</span>
            </x-nav-link>
        </li>
         <li class="relative px-6 py-3">
            <x-nav-link :href="route('teacher.attendance.index')" :active="request()->routeIs('teacher.attendance.*')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                <span class="ml-4">Take Attendance</span>
            </x-nav-link>
        </li>
        <li class="relative px-6 py-3">
            <x-nav-link :href="route('teacher.scores.index')" :active="request()->routeIs('teacher.scores.*')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span class="ml-4">Enter Scores</span>
            </x-nav-link>
        </li>
        <li class="relative px-6 py-3">
            <x-nav-link :href="route('teacher.cbt.index')" :active="request()->routeIs('teacher.cbt.index')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="ml-4">CBT Management</span>
            </x-nav-link>
        </li>
         <li class="relative px-6 py-3">
            <x-nav-link :href="route('teacher.cbt.results')" :active="request()->routeIs('teacher.cbt.results')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="ml-4">View CBT Results</span>
            </x-nav-link>
        </li>
        @endrole
            <!-- ========== STUDENT LINKS (UPDATED) ========== -->
        @role('Student')
         <li class="relative px-6 py-3 mt-4">
            <h2 class="font-semibold text-gray-500 uppercase text-xs tracking-wider">My Portal</h2>
        </li>
        <li class="relative px-6 py-3">
            <x-nav-link :href="route('student.dashboard')" :active="request()->routeIs('student.dashboard')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="ml-4">My Dashboard</span>
            </x-nav-link>
        </li>
        <li class="relative px-6 py-3">
            <x-nav-link :href="route('student.results.index')" :active="request()->routeIs('student.results.*')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span class="ml-4">My Term Results</span>
            </x-nav-link>
        </li>
        <li class="relative px-6 py-3">
            <x-nav-link :href="route('student.cbt.index')" :active="request()->routeIs('student.cbt.index')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="ml-4">Available CBT Exams</span>
            </x-nav-link>
        </li>
        <li class="relative px-6 py-3">
            <x-nav-link :href="route('student.cbt.attempts')" :active="request()->routeIs('student.cbt.attempts')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="ml-4">My CBT Attempts</span>
            </x-nav-link>
        </li>
        <li class="relative px-6 py-3">
            <x-nav-link :href="route('student.timetable')" :active="request()->routeIs('student.timetable')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="ml-4">My Timetable</span>
            </x-nav-link>
        </li>
        <li class="relative px-6 py-3">
            <x-nav-link :href="route('student.invoices.index')" :active="request()->routeIs('student.invoices.*')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                <span class="ml-4">My Invoices</span>
            </x-nav-link>
        </li>
        @endrole
            <!-- ... inside the main <ul> tag ... -->
<!-- ========== PARENT LINKS ========== -->
@role('Parent')
 <li class="relative px-6 py-3 mt-4">
    <h2 class="font-semibold text-gray-500 uppercase text-xs tracking-wider">Parent Portal</h2>
</li>
<li class="relative px-6 py-3">
    <x-nav-link :href="route('parent.dashboard')" :active="request()->routeIs('parent.dashboard')">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        <span class="ml-4">My Dashboard</span>
    </x-nav-link>
</li>
<li class="relative px-6 py-3">
    <x-nav-link :href="route('parent.results')" :active="request()->routeIs('parent.results')">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <span class="ml-4">Wards' Results</span>
    </x-nav-link>
</li>
<li class="relative px-6 py-3">
    <x-nav-link :href="route('parent.payments')" :active="request()->routeIs('parent.payments')">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
        <span class="ml-4">Fee Payments</span>
    </x-nav-link>
</li>
@endrole
        </ul>
    </div>
</aside>