{{-- ===== REUSABLE CLIENT-SIDE FORM VALIDATION ===== --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const validateInput = function(input) {
            // Ignore hidden and button inputs
            if (input.type === 'hidden' || input.type === 'submit' || input.type === 'button' || input.type === 'file') {
                return null;
            }

            let fieldName = '';
            // Look for a label in the same form-group/container
            const container = input.closest('div');
            const label = container?.querySelector('label');
            if (label) {
                // Get clean label text without asterisk or parentheses
                fieldName = label.textContent.split('*')[0].trim().split('(')[0].trim();
            } else {
                fieldName = input.placeholder || input.name || 'Kolom';
            }
            
            const isRequired = input.hasAttribute('required');
            const value = input.value.trim();
            
            if (isRequired && !value) {
                return `${fieldName} wajib diisi.`;
            }
            
            if (value) {
                if (input.type === 'email') {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        return `Format ${fieldName} tidak valid.`;
                    }
                }
                
                if (input.type === 'password' && value.length < 6) {
                    return `${fieldName} harus minimal 6 karakter.`;
                }
            }
            
            return null;
        };

        const showInputError = function(input, message) {
            let container = input.parentNode;
            // Handle wrapper layers (like eye icon absolute-position wrappers)
            if (container.classList.contains('relative')) {
                container = container.parentNode;
            }
            
            let errorEl = container.querySelector('.input-error-msg');
            if (!errorEl) {
                errorEl = document.createElement('p');
                errorEl.className = 'input-error-msg text-xs text-[#8c524f] font-semibold mt-1.5 transition-all';
                container.appendChild(errorEl);
            }
            errorEl.textContent = message;
            
            // Style input border as invalid (soft reddish tones)
            input.classList.remove('border-[#e8e0c8]', 'border-[#e5e7eb]', 'border-gray-300', 'focus:border-[#8c9c72]', 'focus:ring-[#8c9c72]');
            input.classList.add('border-[#eedad8]', 'focus:border-[#8c524f]', 'focus:ring-[#eedad8]');
        };

        const clearInputError = function(input) {
            let container = input.parentNode;
            if (container.classList.contains('relative')) {
                container = container.parentNode;
            }
            
            const errorEl = container.querySelector('.input-error-msg');
            if (errorEl) {
                errorEl.remove();
            }
            
            // Restore default input border style
            input.classList.remove('border-[#eedad8]', 'focus:border-[#8c524f]', 'focus:ring-[#eedad8]');
            input.classList.add('border-[#e8e0c8]', 'focus:border-[#8c9c72]', 'focus:ring-[#8c9c72]');
        };

        // Attach listeners for dynamic validations on blur
        document.addEventListener('focusout', function(e) {
            const input = e.target;
            if (input.tagName === 'INPUT' || input.tagName === 'SELECT' || input.tagName === 'TEXTAREA') {
                const errorMsg = validateInput(input);
                if (errorMsg) {
                    showInputError(input, errorMsg);
                } else {
                    clearInputError(input);
                }
            }
        }, true);

        // Clear error immediately when typing/correcting
        document.addEventListener('input', function(e) {
            const input = e.target;
            if (input.tagName === 'INPUT' || input.tagName === 'TEXTAREA') {
                const errorMsg = validateInput(input);
                if (!errorMsg) {
                    clearInputError(input);
                }
            }
        });

        // Intercept form submission
        document.addEventListener('submit', function(e) {
            const form = e.target;
            
            // Skip validation if the form explicitly requests to be ignored
            if (form.classList.contains('no-validation')) {
                return;
            }

            let isValid = true;
            const inputs = form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                const errorMsg = validateInput(input);
                if (errorMsg) {
                    showInputError(input, errorMsg);
                    isValid = false;
                } else {
                    clearInputError(input);
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                e.stopPropagation();
                
                // Scroll the first invalid element into view
                const firstInvalid = form.querySelector('.border-[#eedad8]');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalid.focus();
                }
            }
        });
    });
</script>
