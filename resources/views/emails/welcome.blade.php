<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Fresh Cart</title>
    <style>
        /* Embedded styles for email compatibility */
        body {
            background-color: #f7fafc; /* bg-gray-100 */
            font-family: sans-serif;
            padding: 32px; /* p-8 */
        }
        .container {
            max-width: 672px; /* max-w-2xl */
            margin: 0 auto;
            padding: 32px; /* p-8 */
            background-color: #ffffff; /* bg-white */
            border-radius: 20px; /* rounded-xl */
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1); /* shadow-lg */
        }
        .header {
            text-align: center;
            margin-bottom: 32px; /* mb-8 */
            padding-bottom: 24px; /* pb-6 */
            border-bottom: 1px solid #e2e8f0; /* border-gray-200 */
        }
        .header a {
            font-size: 24px; /* text-2xl */
            font-weight: bold;
            color: #16a34a; /* text-green-600 */
            text-decoration: none;
        }
        .header a:hover {
            color: #15803d; /* hover:text-green-700 */
        }
        .title {
            font-size: 24px; /* text-2xl */
            font-weight: bold;
            color: #2d3748; /* text-gray-800 */
            margin-bottom: 16px; /* mb-4 */
            text-align: center;
        }
        .image {
            width: 100%;
            max-width: 448px; /* max-w-lg */
            height: auto;
            margin: 24px auto; /* my-6 */
            border-radius: 8px; /* rounded-lg */
            display: block;
        }
        .text {
            color: #4a5568; /* text-gray-600 */
            margin-bottom: 20px; /* mb-5 */
            line-height: 1.625; /* leading-relaxed */
        }
        .highlight {
            font-weight: 600; /* font-semibold */
            color: #16a34a; /* text-green-600 */
        }
        .list {
            color: #4a5568; /* text-gray-600 */
            margin-bottom: 24px; /* mb-6 */
            padding-left: 24px; /* pl-6 */
            list-style-type: disc;
        }
        .list li {
            margin-bottom: 8px; /* space-y-2 */
        }
        .button-container {
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 12px 32px; /* px-8 py-3 */
            background-color: #16a34a; /* bg-green-600 */
            color: #ffffff; /* text-white */
            font-weight: 600; /* font-semibold */
            border-radius: 8px; /* rounded-lg */
            text-decoration: none;
        }
        .button:hover {
            background-color: #15803d; /* hover:bg-green-700 */
        }
        .footer {
            margin-top: 32px; /* mt-8 */
            padding-top: 24px; /* pt-6 */
            border-top: 1px solid #e2e8f0; /* border-gray-200 */
            text-align: center;
            color: #6b7280; /* text-gray-500 */
            font-size: 12px; /* text-sm */
        }
        .footer p {
            margin-bottom: 8px; /* mb-2 */
        }
        @media (max-width: 640px) {
            body {
                padding: 16px; /* sm:p-4 */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ route('home') }}">Fresh Cart</a>
        </div>
        
        <h1 class="title">Welcome to Fresh Cart, {{ $user->name }}! 🎉</h1>
        
        <img src="{{ asset('images/grocery-banner.png') }}" alt="Welcome to Fresh Cart" class="image">
        
        <p class="text">
            We're thrilled to have you join our community of smart shoppers! Your account has been successfully created with the email: 
            <span class="highlight">{{ $user->email }}</span>
        </p>
        
        <p class="text">With Fresh Cart, you'll enjoy:</p>
        <ul class="list">
            <li>Wide selection of fresh groceries</li>
            <li>Fast and reliable delivery</li>
            <li>Exclusive deals and offers</li>
            <li>24/7 customer support</li>
        </ul>
        
        <div class="button-container">
            <a href="{{ route('home') }}" class="button">Start Shopping Now</a>
        </div>
        
        <div class="footer">
            <p>If you have any questions, feel free to contact our support team.</p>
            <p>© {{ date('Y') }} Fresh Cart. All rights reserved.</p>
        </div>
    </div>
</body>
</html>