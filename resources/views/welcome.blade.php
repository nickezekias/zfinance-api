<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Zvany Finance API</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="app.css">

    <!-- Styles -->
    <style>
        body {
            font-family: figtree, Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #212020;
        }

        .container {
            display: flex;
            align-items: center;
            width: 100vw;
            height: 100vh;
        }

        header {
            background-color: transparent;
            color: #fff;
            font-size: medium;
            padding: 0.00099rem 1rem;
            text-align: center;
            font-weight: 400;
            width: 100%;
        }

        header h1 {
            font-weight: 400;
            font-family: 'figtree';
        }

        footer {
            color: lightgray;
            text-align: center;
            position: fixed;
            bottom: 0;
            font-weight: 100;
            width: 100%;
            border-top: 1px dashed lightgrey;
        }
    </style>
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="container">
        <header>
            <h1>Zvany Finance API</h1>
            <span>v1.0</span>
        </header>
        <footer>
            <p>&copy; 2024 Zvany. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>