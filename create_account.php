<?php
// include "backend/user_create_account.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Account - IT Ticketing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 flex items-center justify-center min-h-screen">

    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-8">

        <!-- Header -->
        <div class="text-center mb-6">
            <img src="https://ui-avatars.com/api/?name=IT+Admin&background=F97316&color=fff"
                alt="Logo" class="w-16 h-16 mx-auto rounded-full mb-3">
            <h1 class="text-2xl font-bold text-slate-700">Create Account</h1>
            <p class="text-sm text-slate-500">Set up your IT Ticketing account</p>
        </div>

        <!-- Error Message -->
        <div id="errorMessage" class="hidden mb-4 text-red-700 bg-red-100 px-4 py-2 rounded-lg border border-red-300"></div>

        <!-- Create Account Form -->
        <form id="createAccountForm" class="space-y-4">

            <div>
                <label for="fullname" class="block text-sm font-medium text-slate-600">Full Name</label>
                <input type="text" name="fullname" id="fullname" required
                    class="mt-1 block w-full px-4 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none transition">
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-slate-600">Username</label>
                <input type="text" name="username" id="username" required
                    class="mt-1 block w-full px-4 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none transition">
            </div>

            <div class="relative">
                <label for="password" class="block text-sm font-medium text-slate-600">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full pr-16 px-4 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none transition">
                <button type="button" id="togglePassword"
                    class="absolute top-1/2 right-4 transform text-sm font-medium text-orange-500 hover:text-orange-600 px-2 py-1">
                    Show
                </button>
            </div>

            <div class="relative">
                <label for="confirm_password" class="block text-sm font-medium text-slate-600">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required
                    class="mt-1 block w-full pr-16 px-4 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none transition">
                <button type="button" id="toggleConfirmPassword"
                    class="absolute top-1/2 right-4 transform text-sm font-medium text-orange-500 hover:text-orange-600 px-2 py-1">
                    Show
                </button>
            </div>

            <p id="passwordMatch" class="text-sm text-red-600 hidden">Passwords do not match!</p>

            <div>
                <label for="role" class="block text-sm font-medium text-slate-600">Role</label>
                <select name="role" id="role" required
                    class="mt-1 block w-full px-4 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none transition">
                    <option value="">Select Role</option>
                    <option value="admin">Administrator</option>
                    <option value="it">IT Support</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div>
                <label for="department" class="block text-sm font-medium text-slate-600">Department</label>
                <input type="text" name="department" id="department"
                    class="mt-1 block w-full px-4 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none transition"
                    placeholder="Optional">
            </div>

            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-xl font-semibold transition">
                Create Account
            </button>
        </form>

    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
        <div class="bg-white max-w-sm w-full rounded-2xl shadow-xl p-6 text-center">
            <h2 class="text-xl font-semibold text-green-600 mb-2">Account Created!</h2>
            <p class="text-slate-600 mb-4">Your account has been successfully created.</p>
            <button id="closeModal"
                class="px-4 py-2 bg-orange-500 text-white rounded-xl hover:bg-orange-600 transition">
                OK
            </button>
        </div>
    </div>

    <script>
        // Show/Hide Password
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        togglePassword.addEventListener('click', () => {
            if (password.type === "password") {
                password.type = "text";
                togglePassword.textContent = "Hide";
            } else {
                password.type = "password";
                togglePassword.textContent = "Show";
            }
        });

        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPassword = document.getElementById('confirm_password');
        toggleConfirmPassword.addEventListener('click', () => {
            if (confirmPassword.type === "password") {
                confirmPassword.type = "text";
                toggleConfirmPassword.textContent = "Hide";
            } else {
                confirmPassword.type = "password";
                toggleConfirmPassword.textContent = "Show";
            }
        });

        // Real-time password match
        const passwordMatch = document.getElementById('passwordMatch');
        confirmPassword.addEventListener('input', () => {
            if (password.value !== confirmPassword.value) {
                passwordMatch.classList.remove('hidden');
            } else {
                passwordMatch.classList.add('hidden');
            }
        });

        // AJAX Form Submission to backend PHP
        const form = document.getElementById('createAccountForm');
        const errorMessage = document.getElementById('errorMessage');
        const successModal = document.getElementById('successModal');
        const closeModal = document.getElementById('closeModal');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (password.value !== confirmPassword.value) {
                errorMessage.textContent = "Passwords do not match!";
                errorMessage.classList.remove('hidden');
                return;
            } else {
                errorMessage.classList.add('hidden');
            }

            const formData = new FormData(form);

            fetch('backend/user_create_account.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        successModal.classList.remove('hidden');
                    } else {
                        errorMessage.textContent = data.error;
                        errorMessage.classList.remove('hidden');
                    }
                })
                .catch(err => {
                    errorMessage.textContent = "Server error!";
                    errorMessage.classList.remove('hidden');
                });
        });

        closeModal.addEventListener('click', () => {
            successModal.classList.add('hidden');
            form.reset();
        });
    </script>

</body>

</html>