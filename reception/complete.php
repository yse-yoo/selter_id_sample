<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evacuation Face Recognition - Home</title>
    <meta name="description" content="Streamlined check-in system for evacuees using face recognition technology.">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="p-4 shadow-md fixed w-full top-0 z-10 bg-white" aria-label="Main Navigation">
        <div class="container mx-auto flex justify-between items-center px-4">
            <a href="index.php" aria-label="Home">
                <h1 class="text-xl font-bold text-purple-600">SHELTER ID</h1>
            </a>
            <ul class="flex space-x-4">
                <li><a href="../" class="text-purple-500 hover:text-purple-700" aria-label="Reception">Reception</a></li>
                <li><a href="../../php/register.php" class="text-purple-500 hover:text-purple-700" aria-label="Register">Register</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <header id="home" class="text-center py-20 mt-16 fade-in">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold mb-8">Shelter Reception</h2>

            <!-- Success Message with Icon -->
            <div class="flex justify-center items-center space-x-4">
                <span class="text-green-500 text-lg font-semibold">受付を完了しました。</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
    </header>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 fade-in">
        <div class="container mx-auto text-center px-4">
            <p>&copy; 2024 Yokohama System Engineering College. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>
