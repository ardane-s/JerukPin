<!-- Toast Container - Fixed position at top-right -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2 pointer-events-none">
    <!-- Toasts will be inserted here dynamically -->
</div>

<style>
/* Toast Base Styles */
.toast {
    pointer-events: auto;
    min-width: 280px;
    max-width: 400px;
    padding: 16px 20px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15), 0 4px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 12px;
    animation: slideInRight 0.3s ease-out, fadeOut 0.3s ease-in 4.7s;
    animation-fill-mode: forwards;
}

/* Toast Types */
.toast-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.toast-error {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.toast-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.toast-info {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

/* Toast Icon */
.toast-icon {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

/* Toast Message */
.toast-message {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
    line-height: 1.4;
}

/* Toast Close Button */
.toast-close {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    border: none;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
    font-size: 16px;
    line-height: 1;
}

.toast-close:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Animations */
@keyframes slideInRight {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
        transform: translateX(400px);
    }
}

/* Mobile Responsive */
@media (max-width: 640px) {
    #toast-container {
        right: 16px;
        left: 16px;
        top: 16px;
    }
    
    .toast {
        min-width: auto;
        max-width: 100%;
    }
}
</style>

<script>
/**
 * Toast Notification System
 * Usage: showToast('Message here', 'success')
 */

const Toast = {
    container: null,
    
    init() {
        this.container = document.getElementById('toast-container');
        if (!this.container) {
            console.error('Toast container not found');
        }
    },
    
    show(message, type = 'info', duration = 5000) {
        if (!this.container) this.init();
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        
        // Icon based on type
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };
        
        toast.innerHTML = `
            <div class="toast-icon">${icons[type] || icons.info}</div>
            <div class="toast-message">${message}</div>
            <button class="toast-close" onclick="Toast.close(this.parentElement)">×</button>
        `;
        
        // Add to container
        this.container.appendChild(toast);
        
        // Auto-remove after duration
        setTimeout(() => {
            this.close(toast);
        }, duration);
    },
    
    close(toastElement) {
        if (toastElement && toastElement.parentElement) {
            toastElement.style.animation = 'fadeOut 0.3s ease-in forwards';
            setTimeout(() => {
                toastElement.remove();
            }, 300);
        }
    },
    
    success(message, duration) {
        this.show(message, 'success', duration);
    },
    
    error(message, duration) {
        this.show(message, 'error', duration);
    },
    
    warning(message, duration) {
        this.show(message, 'warning', duration);
    },
    
    info(message, duration) {
        this.show(message, 'info', duration);
    }
};

// Global function for easy access
function showToast(message, type = 'info', duration = 5000) {
    Toast.show(message, type, duration);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    Toast.init();
    
    // Check for Laravel session messages and show as toast
    @if(session('success'))
        Toast.success('{{ session('success') }}');
    @endif
    
    @if(session('error'))
        Toast.error('{{ session('error') }}');
    @endif
    
    @if(session('warning'))
        Toast.warning('{{ session('warning') }}');
    @endif
    
    @if(session('info'))
        Toast.info('{{ session('info') }}');
    @endif
    
    @if($errors->any())
        @foreach($errors->all() as $error)
            Toast.error('{{ $error }}');
        @endforeach
    @endif
});
</script>
