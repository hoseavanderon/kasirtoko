<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home - SecureApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="text-center space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Welcome, you are logged in!</h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                Logout
            </button>
        </form>
    </div>

</body>

</html>
