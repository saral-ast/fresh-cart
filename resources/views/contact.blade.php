<x-layout>
    <section class="min-h-screen py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white text-gray-900 py-12 px-6 flex flex-col md:flex-row items-center justify-between shadow-lg rounded-lg border border-gray-100">
                <div class="max-w-lg">
                <h1 class="text-4xl font-bold mb-3 text-gray-800">Get in Touch</h1>
                    <p class="text-lg text-gray-600">We'd love to hear from you. Here's how you can reach us.</p>
                </div>
                <div class="hidden md:block">
                    <img src="https://img.freepik.com/free-vector/customer-support-illustration_23-2148899266.jpg" 
                         alt="Customer Support" class="rounded-lg w-60 md:w-72 h-auto shadow-md">
                </div>
            </div>

            <!-- Contact Form & Info Section -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <div class="bg-white shadow-lg rounded-lg p-8 border border-gray-100">
                    <h2 class="text-2xl font-bold mb-6 text-gray-800">Send us a Message</h2>
                    <form class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition duration-200">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition duration-200">
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                            <input type="text" name="subject" id="subject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition duration-200">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea name="message" id="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 transition duration-200"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 font-medium">Send Message</button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-8">
                    <!-- Social Media Links -->
                    <div class="bg-white shadow-lg rounded-lg p-8 border border-gray-100">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800">Connect With Us</h2>
                        <div class="flex justify-center space-x-8">
                            <a href="https://www.facebook.com/yourprofile" target="_blank" class="text-blue-600 text-3xl hover:text-blue-800 transition duration-200">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="https://www.instagram.com/yourprofile" target="_blank" class="text-pink-500 text-3xl hover:text-pink-700 transition duration-200">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/yourprofile" target="_blank" class="text-blue-700 text-3xl hover:text-blue-900 transition duration-200">
                                <i class="fab fa-linkedin"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Office Location -->
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-100">
                        <div class="w-full h-64">
                            <iframe class="w-full h-full"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.83543450961!2d-122.41941518468191!3d37.77492977975937!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085808c8b20b8d7%3A0x7b8a68d4b7c0f6cf!2sGoogle!5e0!3m2!1sen!2us!4v1616704317766!5m2!1sen!2us" 
                                allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                        <div class="p-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Global Headquarters</h3>
                            <div class="space-y-3 text-gray-600">
                                <p class="flex items-center">
                                    <i class="fas fa-map-marker-alt w-5 text-green-600"></i>
                                    <span class="ml-2">123 Organic Street, Green City, Earth - 56789</span>
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-phone w-5 text-green-600"></i>
                                    <span class="ml-2">+1 888 482 7768</span>
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-fax w-5 text-green-600"></i>
                                    <span class="ml-2">+1 617 812 5820</span>
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-envelope w-5 text-green-600"></i>
                                    <span class="ml-2">support@freshcart.com</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
