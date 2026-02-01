<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>IT Ticketing Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 flex items-center justify-center min-h-screen">

    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-8">

        <!-- Header -->
        <div class="text-center mb-6">
            <img src="https://ui-avatars.com/api/?name=IT+Admin&background=F97316&color=fff"
                alt="Logo" class="w-16 h-16 mx-auto rounded-full mb-3">
            <h1 class="text-2xl font-bold text-slate-700">Welcome Back</h1>
            <p class="text-sm text-slate-500">Login to your IT Ticketing account</p>
        </div>

        <!-- Error Message -->
        <?php if (!empty($error)) : ?>
            <div class="mb-4 text-red-700 bg-red-100 px-4 py-2 rounded-lg border border-red-300">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="login.php" method="POST" class="space-y-4">

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-slate-600">Username</label>
                <input type="text" name="username" id="username" required
                    class="mt-1 block w-full px-4 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none transition"
                    value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
            </div>

            <!-- Password -->
            <div class="relative">
                <label for="password" class="block text-sm font-medium text-slate-600">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full pr-16 sm:pr-14 px-4 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-orange-500 focus:outline-none transition">

                <!-- Show/Hide password -->
                <button type="button" id="togglePassword"
                    class="absolute top-1/2 right-4 transform  text-sm font-medium text-orange-500 hover:text-orange-600 px-2 py-1">
                    Show
                </button>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-xl font-semibold transition">
                Login
            </button>
        </form>

        <!-- Footer -->
        <p class="mt-6 text-center text-sm text-slate-500">
            &copy; 2026 IT Ticketing. All rights reserved.
        </p>
    </div>

    <!-- Show/Hide Password Script -->
    <script>
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
    </script>

</body>

</html>