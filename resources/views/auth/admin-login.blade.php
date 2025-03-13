<x-admin-layout>
<section class="bg-white min-h-screen flex items-center justify-center antialiased">
    <div class="w-full max-w-xl bg-white rounded-xl shadow-lg dark:border border-black/10 px-10 py-12">
        <h1 class="text-3xl font-bold text-gray-900 text-center mb-6">
            Admin Login
        </h1>
        <p class="text-sm text-gray-600 text-center mb-6">
            Please enter your credentials to access the admin panel
        </p>

        <x-forms.form method="POST" action="/admin/login" id="admin-login-form">
            <div class="space-y-5">
                <div>
                    <x-forms.input label="Email Address" name="email" type="email" placeholder="Enter your email" />
                </div>

                <div>
                    <x-forms.input label="Password" name="password" type="password" placeholder="Enter your password" />
                </div>
                <x-forms.button>
                    Login to Admin Panel
                </x-forms.button>
            </div>
        </x-forms.form>
    </div>
</section>
</x-admin-layout>