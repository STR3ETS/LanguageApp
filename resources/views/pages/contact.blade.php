@extends('layouts.app')

@section('title', 'Contact - Fluence')

@section('content')

<x-page-hero
    title="Get in"
    highlight="touch."
    subtitle="Have a question, found a bug, or just want to say hi? We'd love to hear from you. Our team typically responds within 24 hours."
    badge="Contact"
    badge-icon="fa-solid fa-paper-plane"
    badge-color="sky"
/>

{{-- ===== CONTACT FORM + INFO ===== --}}
<section class="py-16 border-t border-border/30 relative overflow-hidden">
    <div class="absolute top-[20%] right-[10%] w-[400px] h-[400px] bg-indigo/3 rounded-full blur-[150px]"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid lg:grid-cols-5 gap-12 max-w-5xl mx-auto">

            {{-- Form --}}
            <div class="lg:col-span-3">
                <h2 class="font-display text-2xl font-bold text-bright mb-6">Send us a message</h2>
                <form class="space-y-5">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-soft uppercase tracking-widest mb-2">Name</label>
                            <input type="text" placeholder="Your name" class="w-full px-4 py-3 bg-elevated border border-border/50 rounded-xl text-sm text-text placeholder-muted focus:outline-none focus:border-indigo/40 transition-colors duration-200">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-soft uppercase tracking-widest mb-2">Email</label>
                            <input type="email" placeholder="you@example.com" class="w-full px-4 py-3 bg-elevated border border-border/50 rounded-xl text-sm text-text placeholder-muted focus:outline-none focus:border-indigo/40 transition-colors duration-200">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-soft uppercase tracking-widest mb-2">Subject</label>
                        <select class="w-full px-4 py-3 bg-elevated border border-border/50 rounded-xl text-sm text-muted focus:outline-none focus:border-indigo/40 transition-colors duration-200">
                            <option>General question</option>
                            <option>Bug report</option>
                            <option>Feature request</option>
                            <option>Billing & subscription</option>
                            <option>Partnership</option>
                            <option>Press inquiry</option>
                            <option>Careers</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-soft uppercase tracking-widest mb-2">Message</label>
                        <textarea rows="6" placeholder="Tell us what's on your mind..." class="w-full px-4 py-3 bg-elevated border border-border/50 rounded-xl text-sm text-text placeholder-muted focus:outline-none focus:border-indigo/40 transition-colors duration-200 resize-none"></textarea>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 px-8 py-3.5 bg-indigo hover:bg-indigo-light text-white font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_30px_var(--color-indigo-glow)]">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        Send message
                    </button>
                </form>
            </div>

            {{-- Info sidebar --}}
            <div class="lg:col-span-2 space-y-5">
                <h2 class="font-display text-2xl font-bold text-bright mb-2">Other ways to reach us</h2>

                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-indigo/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-envelope text-indigo-light text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-bright">Email</h3>
                            <p class="text-xs text-muted">For general inquiries</p>
                        </div>
                    </div>
                    <a href="mailto:hello@fluence.com" class="text-sm text-indigo-light hover:text-indigo transition-colors duration-200">hello@fluence.com</a>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-sky/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-phone text-sky-light text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-bright">Phone</h3>
                            <p class="text-xs text-muted">Mon-Fri, 9:00-17:00 CET</p>
                        </div>
                    </div>
                    <a href="tel:+31612345678" class="text-sm text-sky-light hover:text-sky transition-colors duration-200">+31 6 1234 5678</a>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-mint/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-location-dot text-mint-light text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-bright">Office</h3>
                            <p class="text-xs text-muted">No walk-ins, remote-first team</p>
                        </div>
                    </div>
                    <p class="text-sm text-soft">Amsterdam, Netherlands</p>
                    <div class="flex items-center gap-2 mt-2">
                        <img src="https://flagcdn.com/w20/nl.png" alt="NL" class="w-4 h-3 rounded-sm opacity-60">
                        <span class="text-xs text-muted">Based in the Netherlands</span>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 bg-sun/10 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-clock text-sun-light text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-bright">Response time</h3>
                            <p class="text-xs text-muted">We're pretty fast</p>
                        </div>
                    </div>
                    <p class="text-sm text-soft">Typically within 24 hours on business days. Premium users get priority support and faster responses.</p>
                </div>

                <div class="pt-2">
                    <p class="text-xs text-muted uppercase tracking-widest mb-3">Follow us</p>
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-9 h-9 rounded-full bg-elevated flex items-center justify-center text-muted hover:text-indigo-light hover:bg-indigo/10 transition-all duration-200"><i class="fa-brands fa-instagram text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-elevated flex items-center justify-center text-muted hover:text-indigo-light hover:bg-indigo/10 transition-all duration-200"><i class="fa-brands fa-x-twitter text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-elevated flex items-center justify-center text-muted hover:text-indigo-light hover:bg-indigo/10 transition-all duration-200"><i class="fa-brands fa-linkedin text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-elevated flex items-center justify-center text-muted hover:text-indigo-light hover:bg-indigo/10 transition-all duration-200"><i class="fa-brands fa-tiktok text-sm"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-elevated flex items-center justify-center text-muted hover:text-indigo-light hover:bg-indigo/10 transition-all duration-200"><i class="fa-brands fa-youtube text-sm"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== FAQ ===== --}}
<section class="py-24 lg:py-32 border-t border-border/30">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <h2 class="font-display text-3xl sm:text-4xl font-bold text-bright tracking-tight">Before you ask — <span class="text-gradient italic">check here.</span></h2>
            <p class="text-soft mt-4">These are the questions we get most often. You might find your answer without waiting.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-5 max-w-5xl mx-auto">
            @foreach([
                ['q' => 'How do I cancel my subscription?', 'a' => 'Go to your profile settings and click "Cancel subscription". It takes effect at the end of your billing period. No questions asked, no hoops to jump through.'],
                ['q' => 'I forgot my password. What do I do?', 'a' => 'Click "Forgot password?" on the login page and enter your email. We\'ll send you a reset link within seconds.'],
                ['q' => 'I found a bug. How do I report it?', 'a' => 'Use the contact form above with "Bug report" as the subject, or email us directly at hello@fluence.com. Include what device you\'re using and what happened.'],
                ['q' => 'Can I request a new language?', 'a' => 'Absolutely! We\'re always expanding. Send us a message and we\'ll add it to our roadmap. The most requested languages get priority.'],
                ['q' => 'Do you offer refunds?', 'a' => 'Yes. If you\'re not happy with Premium, contact us within 7 days of purchase for a full refund. We don\'t want your money if you\'re not satisfied.'],
                ['q' => 'I\'m a teacher. Do you offer school plans?', 'a' => 'Not yet, but it\'s on our roadmap. Reach out via the contact form with "Partnership" as the subject and we\'ll keep you updated.'],
                ['q' => 'How do I change my email address?', 'a' => 'Go to your profile settings and update your email. You\'ll need to verify the new email address before the change takes effect.'],
                ['q' => 'Is my data safe?', 'a' => 'Yes. We use industry-standard encryption, never sell your data, and don\'t track more than we need. Read our privacy policy for the full details.'],
            ] as $faq)
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="font-bold text-bright text-sm mb-2">{{ $faq['q'] }}</h3>
                    <p class="text-sm text-muted leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== MAP / LOCATION ===== --}}
<section class="py-16 border-t border-border/30 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-indigo/5 via-transparent to-indigo/5"></div>
    <div class="relative max-w-4xl mx-auto px-6 lg:px-8">
        <div class="glass-card rounded-3xl p-8 lg:p-12 flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
            <div class="w-16 h-16 bg-indigo/10 rounded-2xl flex items-center justify-center shrink-0">
                <img src="https://flagcdn.com/w40/nl.png" alt="NL" class="w-8 h-6 rounded-sm">
            </div>
            <div class="flex-1">
                <h3 class="font-display text-xl font-bold text-bright mb-2">Amsterdam, Netherlands</h3>
                <p class="text-soft text-sm leading-relaxed">We're a remote-first team based in Amsterdam. While we don't have a physical office for visitors, we're always available online and respond quickly to every message.</p>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <div class="w-2 h-2 bg-mint rounded-full animate-pulse"></div>
                <span class="text-xs text-mint-light font-semibold">Online now</span>
            </div>
        </div>
    </div>
</section>
@endsection
