<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">Contact Grocify</h1>
            <p class="mt-4 text-lg text-slate-500">Have questions or feedback? We would love to hear from you!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-12">
            <!-- Contact Form -->
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                <h3 class="text-xl font-bold text-slate-900 mb-6">Send a Message</h3>
                <form action="#" method="POST" class="space-y-4" @submit.prevent="alert('Thank you! Your message has been sent.')">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Name</label>
                        <input type="text" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="John Doe">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                        <input type="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="john@example.com">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Message</label>
                        <textarea rows="4" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-emerald-500 focus:border-emerald-500 text-sm" placeholder="Your message here..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-premium text-white font-bold py-3.5 px-4 rounded-xl text-sm transition-all shadow-sm hover:opacity-90">
                        Submit Message
                    </button>
                </form>
            </div>

            <!-- Contact info -->
            <div class="space-y-8">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Our Head Office</h3>
                    <p class="text-slate-600 leading-relaxed">
                        100 Fresh Avenue, Suite 300<br/>
                        New York, NY 10001<br/>
                        United States
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Direct Support</h3>
                    <ul class="space-y-2 text-slate-600">
                        <li class="flex items-center space-x-2">
                            <i class="fa-solid fa-phone text-emerald-500"></i>
                            <span>+1 (800) 123-4567</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fa-solid fa-envelope text-emerald-500"></i>
                            <span>support@grocify.com</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
