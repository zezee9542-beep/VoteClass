{{-- ===== MODERN PAGE TRANSITION OVERLAY ===== --}}
<style>
    #pageTransitionOverlay {
        transition: transform 0.5s cubic-bezier(0.85, 0, 0.15, 1), opacity 0.5s ease;
        transform: translateY(0);
        opacity: 1;
    }
    
    #pageTransitionOverlay.page-loaded {
        transform: translateY(-100%);
        opacity: 0.9;
        pointer-events: none;
    }

    #pageTransitionOverlay.page-loading {
        transform: translateY(0);
        opacity: 1;
        pointer-events: auto;
    }

    @keyframes transitionLogoPulse {
        0%, 100% { transform: scale(1); opacity: 0.95; }
        50% { transform: scale(1.08); opacity: 1; }
    }

    .transition-logo-animate {
        animation: transitionLogoPulse 1.8s ease-in-out infinite;
    }
</style>

<div id="pageTransitionOverlay" 
     class="fixed inset-0 z-[9999] bg-[#fdf9ef] flex flex-col items-center justify-center">
    <div class="flex flex-col items-center gap-4 select-none">
        
        {{-- Soft Wavy Background Glow behind logo --}}
        <div class="absolute w-64 h-64 bg-[#f2ebd4] rounded-full opacity-60 blur-2xl -z-10"></div>
        
        {{-- Logo Box --}}
        <div class="relative w-16 h-16 border-[3px] border-[#8c9c72] rounded-2xl flex justify-center items-center bg-white shadow-md transition-logo-animate">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 13L9 17L19 5" stroke="#d5b263" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>

        {{-- Branding text --}}
        <span class="font-bold text-[18px] tracking-tight mt-2 text-[#405834]">
            Vote<span class="text-[#d5b263]">Class</span>
        </span>
    </div>
</div>

<script>
    (function() {
        const overlay = document.getElementById('pageTransitionOverlay');
        
        // Step 1: Hide overlay when page completes loading
        window.addEventListener('load', function() {
            setTimeout(() => {
                overlay.classList.add('page-loaded');
            }, 100);
        });

        // Fail-safe: if window load is slow, hide overlay anyway after 1.5 seconds
        setTimeout(() => {
            if (!overlay.classList.contains('page-loaded')) {
                overlay.classList.add('page-loaded');
            }
        }, 1500);

        // Step 2: Handle back/forward cache restore
        window.addEventListener('pageshow', function(event) {
            overlay.classList.add('page-loaded');
            overlay.classList.remove('page-loading');
        });

        // Step 3: Intercept link clicks to animate transitions out
        document.addEventListener('click', function(e) {
            // Find closest anchor tag
            let anchor = e.target.closest('a');
            
            if (!anchor) return;
            
            const href = anchor.getAttribute('href');
            
            // Ignore special links
            if (!href || 
                href.startsWith('#') || 
                href.startsWith('javascript:') || 
                href.startsWith('mailto:') || 
                href.startsWith('tel:') ||
                anchor.getAttribute('target') === '_blank' || 
                e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || 
                e.button !== 0) {
                return;
            }

            // Verify if same origin (internal links only)
            const targetUrl = new URL(anchor.href, window.location.href);
            if (targetUrl.origin !== window.location.origin) {
                return;
            }

            // Exclude logout link to prevent stuck sessions during lag
            if (href.includes('/logout')) {
                return;
            }

            // Trigger slide down transition and navigate
            e.preventDefault();
            overlay.classList.remove('page-loaded');
            overlay.classList.add('page-loading');

            setTimeout(() => {
                window.location.href = anchor.href;
            }, 350); // Match timing of navigation transition
        });
    })();
</script>
