<div x-data="onboardingTour()" x-init="init()" x-show="active" x-cloak class="fixed inset-0 z-[100]">

    {{-- Backdrop with spotlight hole (SVG mask) --}}
    <div x-show="!showWelcome" class="fixed inset-0 transition-all duration-500" @click="next()">
        <svg class="absolute inset-0 w-full h-full" x-ref="overlaySvg">
            <defs>
                <mask id="tourMask">
                    <rect width="100%" height="100%" fill="white"/>
                    <rect :x="spot.x" :y="spot.y" :width="spot.w" :height="spot.h" rx="16" fill="black"/>
                </mask>
            </defs>
            <rect width="100%" height="100%" fill="rgba(0,0,0,0.5)" mask="url(#tourMask)"/>
        </svg>
        {{-- Spotlight border ring --}}
        <div class="absolute rounded-2xl transition-all duration-500 ring-2 ring-indigo/50 pointer-events-none"
             :style="spotlightStyle"></div>
    </div>

    {{-- Tooltip --}}
    <div x-show="!showWelcome" x-ref="tooltip" class="fixed z-[101] max-w-sm transition-all duration-500"
         :style="tooltipStyle">
        <div class="glass-card rounded-2xl p-6 shadow-2xl border-indigo/20 relative">
            {{-- Step indicator --}}
            <div class="flex items-center gap-1.5 mb-4">
                <template x-for="i in steps.length" :key="i">
                    <div class="h-1 rounded-full transition-all duration-300"
                         :class="i - 1 === currentStep ? 'w-6 bg-indigo' : (i - 1 < currentStep ? 'w-4 bg-indigo/40' : 'w-4 bg-elevated')"></div>
                </template>
            </div>

            {{-- Icon + content --}}
            <div class="flex items-start gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                     :class="'bg-' + steps[currentStep].color + '/10'">
                    <i class="text-sm" :class="steps[currentStep].icon + ' text-' + steps[currentStep].color + '-light'"></i>
                </div>
                <div>
                    <h3 class="font-display text-base font-bold text-bright mb-1" x-text="steps[currentStep].title"></h3>
                    <p class="text-sm text-soft leading-relaxed" x-text="steps[currentStep].description"></p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between">
                <button @click="skip()" class="text-xs text-muted hover:text-soft transition-colors cursor-pointer">
                    Skip tour
                </button>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] text-muted" x-text="(currentStep + 1) + ' of ' + steps.length"></span>
                    <button @click="next()"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-indigo hover:bg-indigo-light text-white text-sm font-semibold rounded-full transition-all duration-200 cursor-pointer hover:shadow-[0_0_20px_var(--color-indigo-glow)]">
                        <span x-text="currentStep === steps.length - 1 ? 'Get started!' : 'Next'"></span>
                        <i class="fa-solid fa-arrow-right text-[9px]"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Welcome overlay (step 0 special) --}}
    <div x-show="showWelcome" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[102] flex items-center justify-center px-6 bg-void/70">
        <div class="relative max-w-md w-full">
            <div class="relative rounded-3xl overflow-hidden glass-card border-indigo/15">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo/10 via-transparent to-indigo/5"></div>
                <div class="absolute top-0 right-0 w-[200px] h-[200px] bg-indigo/8 rounded-full blur-[80px]"></div>

                <div class="relative p-10 text-center">
                    <div class="text-5xl mb-5">🎉</div>
                    <h2 class="font-display text-2xl font-bold text-bright mb-3">Welcome to Fluence!</h2>
                    <p class="text-soft text-sm leading-relaxed mb-8">Your account is ready. Let us give you a quick tour so you know where everything is.</p>

                    <div class="flex flex-col gap-3">
                        <button @click="startTour()"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-indigo hover:bg-indigo-light text-white font-semibold rounded-full transition-all duration-300 hover:shadow-[0_0_30px_var(--color-indigo-glow)] cursor-pointer">
                            <i class="fa-solid fa-route text-xs"></i> Show me around
                        </button>
                        <button @click="skip()"
                            class="text-sm text-muted hover:text-soft transition-colors cursor-pointer py-2">
                            I'll explore on my own
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function onboardingTour() {
    return {
        active: false,
        showWelcome: true,
        currentStep: 0,
        spotlightStyle: '',
        tooltipStyle: '',
        spot: { x: 0, y: 0, w: 0, h: 0 },

        steps: [
            {
                target: '#tour-hero',
                title: 'Your daily overview',
                description: 'This is your home base. See your streak, get motivated, and jump right into your next lesson with one click.',
                icon: 'fa-solid fa-fire-flame-curved',
                color: 'sun',
                position: 'bottom',
            },
            {
                target: '#tour-missions',
                title: 'Rank, missions & word of the day',
                description: 'Complete daily missions to earn bonus XP. Level up your rank from Newcomer to Legend. And learn a beautiful new word every day.',
                icon: 'fa-solid fa-trophy',
                color: 'indigo',
                position: 'bottom',
            },
            {
                target: '#tour-languages',
                title: 'Your languages',
                description: 'Here you\'ll see all the languages you\'re learning. Track your progress per level and continue right where you left off.',
                icon: 'fa-solid fa-globe',
                color: 'sky',
                position: 'top',
            },
            {
                target: '#tour-progress',
                title: 'Activity & achievements',
                description: 'Track your learning activity over time and unlock achievements as you hit milestones. Keep that chart growing!',
                icon: 'fa-solid fa-chart-line',
                color: 'mint',
                position: 'top',
            },
            {
                target: '#tour-sidebar',
                title: 'Navigation',
                description: 'Use the sidebar to navigate between your Dashboard, Learn page, Languages, Profile, and more. Everything is one click away.',
                icon: 'fa-solid fa-compass',
                color: 'indigo',
                position: 'right',
            },
        ],

        init() {
            if ({{ auth()->user()->tour_completed ? 'true' : 'false' }}) {
                this.active = false;
                return;
            }
            this.active = true;
            document.body.style.overflow = 'hidden';
        },

        startTour() {
            // Pre-calculate position before showing
            this.positionSpotlight();
            setTimeout(() => { this.showWelcome = false; }, 50);
        },

        next() {
            if (this.showWelcome) return;
            if (this.currentStep < this.steps.length - 1) {
                this.currentStep++;
                this.positionSpotlight();
            } else {
                this.finish();
            }
        },

        skip() {
            this.finish();
        },

        finish() {
            fetch('{{ route("tour.complete") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            });
            this.active = false;
            document.body.style.overflow = '';
        },

        positionSpotlight() {
            const step = this.steps[this.currentStep];
            const el = document.querySelector(step.target);
            if (!el) { this.next(); return; }

            const pad = 12;
            const tooltipW = 380;

            const update = () => {
                const rect = el.getBoundingClientRect();
                const tooltipEl = this.$refs.tooltip;
                const tooltipH = tooltipEl ? tooltipEl.offsetHeight : 220;

                this.spot = {
                    x: rect.left - pad,
                    y: rect.top - pad,
                    w: rect.width + pad * 2,
                    h: rect.height + pad * 2,
                };

                this.spotlightStyle = `
                    top: ${this.spot.y}px;
                    left: ${this.spot.x}px;
                    width: ${this.spot.w}px;
                    height: ${this.spot.h}px;
                `;

                const tooltip = {};
                const safeLeft = Math.max(16, Math.min(rect.left, window.innerWidth - tooltipW - 16));

                if (step.position === 'bottom') {
                    tooltip.top = (rect.bottom + pad + 16) + 'px';
                    tooltip.left = safeLeft + 'px';
                } else if (step.position === 'top') {
                    tooltip.top = (rect.top - pad - tooltipH - 16) + 'px';
                    tooltip.left = safeLeft + 'px';
                } else if (step.position === 'right') {
                    tooltip.top = rect.top + 'px';
                    tooltip.left = (rect.right + pad + 16) + 'px';
                }
                this.tooltipStyle = `top: ${tooltip.top}; left: ${tooltip.left}; width: ${tooltipW}px;`;
            };

            // Position immediately first
            update();

            // Then scroll into view and reposition after scroll
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(update, 450);
        },
    }
}
</script>
