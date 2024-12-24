<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Message</title>
    <!-- Include Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <span class="font-bold text-red-600">Error</span>
        </div>
        <p class="text-gray-500">An error occurred during your operation.</p>
        <div class="mt-4">
            <a href="index.html" class="text-blue-600 hover:text-blue-800 visited:text-purple-600">Go to Homepage</a>
        </div>
    </div>
</body>

</html>