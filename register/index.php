<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evacuation Face Recognition</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <div class="container max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg bg-opacity-90">
        <h1 class="text-2xl font-bold text-center mb-6">Evacuation Registration</h1>

        <form id="registrationForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium">Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500">
            </div>

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

            <div>
                <label for="confirmPassword" class="block text-sm font-medium">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label for="birthday" class="block text-sm font-medium">Date of Birth:</label>
                <input type="date" id="birthday" name="birthday_at" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label for="gender" class="block text-sm font-medium">Gender:</label>
                <select id="gender" name="gender" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500">
                    <option value="">Select gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium">Address:</label>
                <input type="text" id="address" name="address" placeholder="Enter your address" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium">Phone:</label>
                <input type="text" id="phone" name="phone" placeholder="Enter phone" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label for="photo" class="block text-sm font-medium">Upload Photo:</label>
                <div class="flex items-center space-x-2">
                    <input type="file" id="photo" name="photo[]" accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-purple-500" required multiple>
                    <button
                        onClick="onCamera()"
                        type="button" id="openCameraBtn" class="bg-purple-500 text-white px-3 py-2 rounded-md">Open Camera</button>
                </div>
            </div>

            <div class="mt-4">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms" class="text-sm font-medium">I agree to the <a href="#" class="text-purple-500 underline">Terms and Conditions</a></label>
            </div>

            <video id="video" width="320" height="240" autoplay style="display:none;" class="mt-4"></video>
            <button onclick="onCapture()" type="button" id="captureBtn" style="display:none;" class="bg-purple-500 text-white px-3 py-2 rounded-md mt-4">Capture Image</button>
            <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>

            <button type="submit" class="w-full bg-purple-500 text-white py-2 rounded-md">Register</button>
        </form>

        <div id="responseMessage" class="mt-4"></div>
    </div>

    <script src="../js/env.js"></script>
    <script src="../js/main.js"></script>
    <script src="../js/test.js"></script>
</body>

</html>