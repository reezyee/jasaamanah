<!-- resources/views/pages/admin/partials/user.blade.php -->
<table class="w-full">
    <thead>
        <tr class="bg-gray-800 text-gray-300">
            <th class="py-3 px-4 text-left">#</th>
            <th class="py-3 px-4 text-left">Name</th>
            <th class="py-3 px-4 text-left">Email</th>
            <th class="py-3 px-4 text-left">Role</th>
            <th class="py-3 px-4 text-left">Division</th>
            <th class="py-3 px-4 text-left">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($filteredUsers as $index => $user)
            <tr class="border-b border-gray-700 hover:bg-gray-800 transition-colors text-gray-300">
                <td class="py-3 px-4">{{ $index + 1 }}</td>
                <td class="py-3 px-4">{{ $user->name }}</td>
                <td class="py-3 px-4">{{ $user->email }}</td>
                <td class="py-3 px-4">
                    <span
                        class="px-2 py-1 rounded text-xs font-medium
                        @if ($user->role == 'admin') bg-red-900 text-red-200
                        @elseif($user->role == 'worker') bg-blue-900 text-blue-200
                        @else bg-green-900 text-green-200 @endif">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="py-3 px-4">{{ $user->division ?? '-' }}</td>
                <td class="py-3 px-4 flex gap-2">
                    <button data-modal-target="userFormModal" data-modal-toggle="userFormModal"
                        class="px-3 py-1 bg-amber-600 hover:bg-amber-700 text-white rounded text-sm transition-colors flex items-center"
                        onclick="prepareEditUser({{ $user }})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </button>
                    <button
                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition-colors flex items-center"
                        onclick="prepareDeleteUser({{ $user->id }}, '{{ $user->name }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>