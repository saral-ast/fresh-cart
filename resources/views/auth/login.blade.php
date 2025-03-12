<x-layout>
    <section class="bg-white min-h-screen flex items-center justify-center antialiased">
        <div class="w-full max-w-xl bg-white rounded-xl shadow-lg dark:border border-black/10 px-10 py-12">
            <h1 class="text-3xl font-bold text-gray-900 text-center mb-6">
                Sign in to Your Account
            </h1>

            <x-forms.form method="POST" action="/login" id="login-form">
                <div class="space-y-5">
                    <div>
                        <x-forms.input label="Email" name="email" type="email" placeholder="Enter your Email" />
                    </div>
                    <div>
                        <x-forms.input label="Password" name="password" type="password" placeholder="Enter your Password" />
                    </div>
                </div>

                <x-forms.button class="mt-6 w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg text-center font-semibold">
                    Sign In
                </x-forms.button>
 
                <p class="text-sm text-gray-600 mt-4 text-center">
                    Don't have an account? 
                    <a href="/register" class="text-green-600 hover:underline">Create an Account</a>
                </p>
            </x-forms.form>
        </div>
    </section>
</x-layout>
