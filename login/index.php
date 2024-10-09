<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Evacuation Face Recognition</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 50%, #ffecd2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

    <div class="container max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg bg-opacity-90">
        <h1 class="text-2xl font-bold text-center mb-6">Login</h1>

        <form id="loginForm" class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500">
            </div>

            <button type="submit" class="w-full bg-purple-500 text-white py-2 rounded-md">Login</button>

            <p class="text-sm text-center mt-4">
                Don't have an account? <a href="register.html" class="text-purple-500 underline">Register here</a>.
            </p>
        </form>

        <div id="loginMessage" class="mt-4"></div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const storedUser = JSON.parse(localStorage.getItem('registeredUser'));
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (storedUser && storedUser.email === email && storedUser.password === password) {
                document.getElementById('loginMessage').innerHTML = '<p class="text-green-500">Login successful!</p>';
                // Redirect or perform post-login actions here
            } else {
                document.getElementById('loginMessage').innerHTML = '<p class="text-red-500">Invalid email or password.</p>';
            }
        });
    </script>
</body>
</html>
