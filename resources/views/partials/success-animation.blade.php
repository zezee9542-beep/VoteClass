{{-- ===== GORGEOUS SUCCESS SPLASH OVERLAY ===== --}}
@php
    $successMessage = session('success') ?? session('profile_success');
@endphp

@if($successMessage)
<style>
    @keyframes successConfettiPop {
        0% {
            transform: translate3d(-50%, -50%, 0) scale(1) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translate3d(calc(-50% + var(--x)), calc(-50% + var(--y)), 0) scale(0) rotate(var(--r));
            opacity: 0;
        }
    }

    .success-confetti {
        position: absolute;
        width: var(--w);
        height: var(--h);
        background-color: var(--bg);
        border-radius: var(--br, 4px);
        opacity: 0;
        z-index: 1000;
        pointer-events: none;
        transform-origin: center;
    }
</style>

<div id="successSplashOverlay"
    class="fixed inset-0 z-[999] flex items-center justify-center bg-[#2f3d20]/25 backdrop-blur-[4px] transition-opacity duration-500">
    
    {{-- Card --}}
    <div id="successSplashCard"
        class="bg-white rounded-3xl p-8 max-w-sm w-full mx-4 border border-[#e8e0c8] shadow-2xl text-center transform scale-95 opacity-0 transition-all duration-500 relative overflow-hidden">
        
        {{-- Bouncy Checkmark Circle --}}
        <div class="mx-auto w-20 h-20 bg-[#f3f7ef] border-2 border-[#e4ecde] rounded-full flex items-center justify-center text-[#485c3f] mb-6 shadow-inner relative z-10">
            <svg class="w-10 h-10 transform scale-0 transition-transform duration-500 ease-out" 
                 id="successSplashCheck" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        {{-- Text --}}
        <h3 class="text-[#2f3d20] font-sans font-extrabold text-[22px] tracking-tight mb-2">Berhasil!</h3>
        <p class="text-[#6e7568] font-sans text-[14px] leading-relaxed font-semibold px-2">{{ $successMessage }}</p>

        {{-- Shrinking Progress Bar (Visual representation of auto-dismiss time) --}}
        <div class="w-full bg-[#fdf9ef] h-1.5 rounded-full mt-6 overflow-hidden border border-[#e8e0c8]/40">
            <div id="successSplashProgress" class="bg-[#485c3f] h-full w-full" style="transition: width 3000ms linear;"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('successSplashOverlay');
        const card = document.getElementById('successSplashCard');
        const check = document.getElementById('successSplashCheck');
        const progress = document.getElementById('successSplashProgress');

        // Step 1: Fade and scale in the popup card
        setTimeout(() => {
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        }, 100);

        // Step 2: Pop the bouncy checkmark
        setTimeout(() => {
            check.style.transform = 'scale(1)';
            // Launch custom confetti explosion
            launchSuccessConfetti();
        }, 300);

        // Step 3: Animate shrinking progress bar
        setTimeout(() => {
            progress.style.width = '0%';
        }, 150);

        // Step 4: Dismiss popup after 3.2 seconds
        setTimeout(() => {
            overlay.classList.add('opacity-0', 'pointer-events-none');
            card.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                overlay.remove();
            }, 500);
        }, 3200);

        // Confetti Generator Function
        function launchSuccessConfetti() {
            // Colors matching our soft brand theme (greens, golds, creams)
            const colors = ['#8c9c72', '#d5b263', '#485c3f', '#e2ebd9', '#f4ebd1'];
            const particleCount = 90;
            
            for (let i = 0; i < particleCount; i++) {
                const p = document.createElement('div');
                p.className = 'success-confetti';
                
                // Randomize particle sizes
                const w = Math.random() * 8 + 6;
                const h = Math.random() * 8 + 6;
                
                // Physics: angle & explosion radius
                const angle = Math.random() * Math.PI * 2;
                const distance = Math.random() * 200 + 80;
                const x = Math.cos(angle) * distance;
                const y = Math.sin(angle) * distance - 50; // slightly upward bias
                
                const rotation = Math.random() * 720 - 360;
                const bg = colors[Math.floor(Math.random() * colors.length)];
                const shape = Math.random() > 0.5 ? '50%' : '2px'; // round or square
                
                p.style.setProperty('--w', `${w}px`);
                p.style.setProperty('--h', `${h}px`);
                p.style.setProperty('--x', `${x}px`);
                p.style.setProperty('--y', `${y}px`);
                p.style.setProperty('--r', `${rotation}deg`);
                p.style.setProperty('--bg', bg);
                p.style.setProperty('--br', shape);
                
                // Random duration
                const duration = Math.random() * 0.8 + 0.9;
                p.style.animation = `successConfettiPop ${duration}s cubic-bezier(0.1, 0.8, 0.3, 1) forwards`;
                
                // Start from center of card
                p.style.left = '50%';
                p.style.top = '50%';
                
                overlay.appendChild(p);
                
                // Clean up particle
                setTimeout(() => p.remove(), duration * 1000);
            }
        }
    });
</script>
@endif
