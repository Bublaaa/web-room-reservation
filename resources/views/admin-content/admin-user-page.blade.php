@extends('admin-page')

@section('admin-content')
<div class="w-full mt-14">
    <div class="flex flex-wrap w-full">
        <div class="w-full flex md:flex-row flex-col gap-4 mb-4">
            <!-- Table Header -->
            <div class="w-full h-fit  p-6 bg-white border border-gray-200 rounded-lg shadow order-last md:order-first">
                <div class="flex flex-row justify-between items-center mb-4">
                    <div class="flex flex-row items-center gap-4">
                        <button type="button" class="primary-button rounded-lg px-3 py-3 inline-flex items-center"
                            id="openRegisterModal">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                            </svg>
                        </button>
                        <h5 class="text-2xl font-semibold tracking-tight text-gray-900">All Users
                        </h5>
                    </div>
                    <form>
                        <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" id="search"
                                class="block w-full px-4 py-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Search Username" required />
                    </form>
                </div>
            </div>
            <!-- Table -->
            <div class="overflow-x-auto w-full">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <select id="roleFilter" class="rounded-full select-form">
                                    <option value="">All Roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                            <th scope="col" class="px-6 py-3">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">{{ $user->username }}</div>
                                    <div class="font-normal text-gray-500">{{ $user->email }}</div>
                                </div>
                            </th>
                            <td class="px-6 py-4 font-bold text-center">
                                {{ ucwords($user->role) }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="#"
                                    onclick="openEditModal({{ $user->id }}, '{{ $user->username }}', '{{ $user->email }}', '{{ $user->role }}')"
                                    class="font-medium text-blue-600 hover:underline">Edit
                                    user</a>
                            </td>
                            <td class="px-6 py-4">
                                <button type="button"
                                    onclick="openDeleteModal({{ $user->id }}, '{{ $user->username }}')"
                                    class="danger-button rounded-lg px-3 py-3 inline-flex items-center">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Account Setting Card-->
        <div class="w-full md:max-w-sm min-w-sm p-6 h-fit bg-white border border-gray-200 rounded-lg shadow">
            <svg class="w-8 h-8 text-gray-500 mb-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
            </svg>
            <a href="#">
                <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900">Account Setting
                </h5>
            </a>
            <p class="mb-3 font-normal text-gray-500">Change your account detail</p>
            <form id="editAccountForm" method="POST" action="{{ route('admin.update.account', $admin->id) }}">
                @csrf
                @method('PUT')

                <!-- Username Field -->
                <div class="mb-4">
                    <label for="editAccountUsername" class="form-label">Username</label>
                    <input type="text" id="editAccountUsername" name="username" class="text-form"
                        value="{{ $admin->username }}" required>
                </div>

                <!-- Email Field -->
                <div class="mb-4">
                    <label for="editEmail" class="form-label">Email</label>
                    <input type="email" id="editAccountEmail" name="email" class="text-form" value="{{ $admin->email }}"
                        required>
                </div>

                <!-- Checkbox for Password Update -->
                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="changePasswordCheckbox" class="mr-2" onchange="togglePasswordFields()">
                    <label for="changePasswordCheckbox" class="form-label mt-2">Change Password</label>
                </div>

                <!-- Password Fields (Initially Hidden) -->
                <div id="passwordFields" class="hidden">
                    <!-- New Password -->
                    <div class="mb-4">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" id="newPassword" name="new_password" class="text-form" disabled>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" id="confirmPassword" name="new_password_confirmation" class="text-form"
                            disabled>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="large-button primary-button">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Register Modal -->
<div id="registerModal"
    class="fixed hidden inset-0 z-50 p-4 bg-gray-800 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg w-full max-w-xs md:max-w-md">
        <h3 class="text-xl font-semibold text-center mb-4">Register New User</h3>
        <!-- Modal Content -->
        <form action="{{ route('admin.register') }}" method="POST">
            @csrf
            <!-- User registration form fields here -->
            <div class="mb-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="text-form" required>
            </div>
            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="text-form" required>
            </div>
            <div class="mb-4">
                <label for="role" class="form-label">Role</label>
                <select id="role" name="role" class="select-form" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="text-form" required />
            </div>
            <div class="flex gap-6">
                <button type="submit" class="large-button primary-button">Register</button>
                <button type="button" id="closeModal" class="large-button secondary-button">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete User Modal -->
<div id="deleteUserModal"
    class="fixed hidden inset-0 z-50 p-4 bg-gray-800 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg w-full max-w-xs md:max-w-md">
        <h3 class="text-xl font-semibold text-center mb-4">Delete User</h3>
        <p class="text-center mb-4" id="deleteConfirmation"></p>
        <form id="deleteForm" method="POST" action="{{ route('admin.delete.user') }}">
            @csrf
            @method('DELETE')
            <input type="hidden" name="userId" id="deleteUserId">
            <div class="flex w-full items-center justify-center gap-4">
                <button type="submit" class="large-button danger-button">Confirm</button>
                <button type="button" id="closeDeleteModal" class="large-button secondary-button">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed hidden inset-0 z-50 p-4 bg-gray-800 bg-opacity-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg w-full max-w-xs md:max-w-md">
        <h3 class="text-xl font-semibold text-center mb-4">Edit User</h3>
        <form id="editForm" method="POST" action="{{ route('admin.update.user') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="userId" id="editUserId">
            <div class="mb-4">
                <label for="editUsername" class="form-label">Username</label>
                <input type="text" id="editUsername" name="username" class="text-form" required>
            </div>
            <div class="mb-4">
                <label for="editEmail" class="form-label">Email</label>
                <input type="email" id="editEmail" name="email" class="text-form" required>
            </div>
            <div class="mb-4">
                <label for="editRole" class="form-label">Role</label>
                <select id="editRole" name="role" class="select-form" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="flex gap-4">
                <button type="submit" class="large-button primary-button">Save</button>
                <button type="button" id="closeEditModal" class="large-button secondary-button">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
const registerModal = document.getElementById('registerModal');
const openRegisterModalButton = document.getElementById('openRegisterModal');
const closeRegisterModalButton = document.getElementById('closeModal');

openRegisterModalButton.addEventListener('click', function(e) {
    e.preventDefault(); // Prevent page reload
    registerModal.classList.remove('hidden');
});

closeRegisterModalButton.addEventListener('click', function() {
    registerModal.classList.add('hidden');
});

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const tableRows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', (event) => {
        const query = event.target.value.toLowerCase();

        tableRows.forEach((row) => {
            const usernameCell = row.querySelector(
                'th .text-base.font-semibold');
            const username = usernameCell.textContent
                .toLowerCase();

            if (username.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    const roleFilter = document.getElementById('roleFilter');

    roleFilter.addEventListener('change', (event) => {
        const selectedRole = event.target.value;
        tableRows.forEach((row) => {
            const roleCell = row.querySelector('td:nth-child(2)');
            const role = roleCell.textContent.trim().toLowerCase();
            if (selectedRole == '' || role == selectedRole) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});



const closeDeleteModalButton = document.getElementById('closeDeleteModal');
const deleteModal = document.getElementById('deleteUserModal')

closeDeleteModalButton.addEventListener('click', function() {
    deleteModal.classList.add('hidden');
});

function openDeleteModal(userId, username) {
    document.getElementById('deleteConfirmation').textContent =
        `Are you sure you want to delete the user with username: ${username} ?`;
    document.getElementById('deleteUserId').value = userId;

    deleteModal.classList.remove('hidden');
}

const editModal = document.getElementById('editModal');
const closeEditModal = document.getElementById('closeEditModal');

function openEditModal(userId, username, email, role) {
    document.getElementById('editUserId').value = userId;
    document.getElementById('editUsername').value = username;
    document.getElementById('editEmail').value = email;
    document.getElementById('editRole').value = role;

    editModal.classList.remove('hidden');
}

closeEditModal.addEventListener('click', () => {
    editModal.classList.add('hidden');
});


function togglePasswordFields() {
    const checkbox = document.getElementById('changePasswordCheckbox');
    const passwordFields = document.getElementById('passwordFields');
    const newPassword = document.getElementById('newPassword');
    const confirmPassword = document.getElementById('confirmPassword');

    if (checkbox.checked) {
        // Show password fields and enable them
        passwordFields.classList.remove('hidden');
        newPassword.disabled = false;
        confirmPassword.disabled = false;
        newPassword.required = true;
        confirmPassword.required = true;
    } else {
        // Hide password fields and disable them
        passwordFields.classList.add('hidden');
        newPassword.disabled = true;
        confirmPassword.disabled = true;
        newPassword.required = false;
        confirmPassword.required = false;
    }
}
</script>
@endsection