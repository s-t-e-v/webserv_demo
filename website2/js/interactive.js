document.addEventListener('DOMContentLoaded', function() {
    // Theme toggle functionality
    function initThemeToggle() {
        const body = document.body;
        const container = document.querySelector('.container');
        
        // Create theme toggle button
        const themeToggle = document.createElement('button');
        themeToggle.id = 'theme-toggle';
        themeToggle.innerHTML = '🌙';
        themeToggle.setAttribute('aria-label', 'Toggle dark mode');
        
        // Style the toggle button
        Object.assign(themeToggle.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            width: '50px',
            height: '50px',
            borderRadius: '50%',
            border: 'none',
            background: 'linear-gradient(135deg, #667eea, #764ba2)',
            color: 'white',
            fontSize: '20px',
            cursor: 'pointer',
            boxShadow: '0 4px 15px rgba(0, 0, 0, 0.2)',
            transition: 'all 0.3s ease',
            zIndex: '1000'
        });
        
        // Add hover effect
        themeToggle.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 6px 20px rgba(0, 0, 0, 0.3)';
        });
        
        themeToggle.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.2)';
        });
        
        // Check for saved theme preference
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            body.classList.add('dark-theme');
            themeToggle.innerHTML = '☀️';
        }
        
        // Toggle theme function
        themeToggle.addEventListener('click', function() {
            body.classList.toggle('dark-theme');
            const isDark = body.classList.contains('dark-theme');
            
            // Update button icon
            themeToggle.innerHTML = isDark ? '☀️' : '🌙';
            
            // Save preference
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            
            // Add animation
            themeToggle.style.transform = 'rotate(360deg) scale(1.2)';
            setTimeout(() => {
                themeToggle.style.transform = 'scale(1)';
            }, 300);
        });
        
        body.appendChild(themeToggle);
    }
    
    // Image gallery with lightbox
    function initImageGallery() {
        const images = document.querySelectorAll('img');
        
        // Create lightbox overlay
        const lightbox = document.createElement('div');
        lightbox.id = 'lightbox';
        Object.assign(lightbox.style, {
            position: 'fixed',
            top: '0',
            left: '0',
            width: '100%',
            height: '100%',
            backgroundColor: 'rgba(0, 0, 0, 0.9)',
            display: 'none',
            justifyContent: 'center',
            alignItems: 'center',
            zIndex: '2000',
            cursor: 'pointer'
        });
        
        const lightboxImg = document.createElement('img');
        Object.assign(lightboxImg.style, {
            maxWidth: '90%',
            maxHeight: '90%',
            objectFit: 'contain',
            borderRadius: '10px',
            boxShadow: '0 10px 30px rgba(0, 0, 0, 0.5)'
        });
        
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '✕';
        Object.assign(closeBtn.style, {
            position: 'absolute',
            top: '20px',
            right: '20px',
            width: '40px',
            height: '40px',
            border: 'none',
            borderRadius: '50%',
            background: 'rgba(255, 255, 255, 0.9)',
            fontSize: '18px',
            cursor: 'pointer',
            transition: 'all 0.2s ease'
        });
        
        lightbox.appendChild(lightboxImg);
        lightbox.appendChild(closeBtn);
        document.body.appendChild(lightbox);
        
        // Add click handlers to images
        images.forEach((img, index) => {
            img.style.cursor = 'pointer';
            img.style.transition = 'transform 0.3s ease';
            
            // Add hover effect
            img.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });
            
            img.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
            
            // Click to open lightbox
            img.addEventListener('click', function() {
                lightboxImg.src = this.src;
                lightboxImg.alt = this.alt;
                lightbox.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });
        
        // Close lightbox handlers
        function closeLightbox() {
            lightbox.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                closeLightbox();
            }
        });
        
        closeBtn.addEventListener('click', closeLightbox);
        
        // Close with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && lightbox.style.display === 'flex') {
                closeLightbox();
            }
        });
    }
    
    // Fun floating elements
    function initFloatingElements() {
        const emojis = ['🐱', '🦜', '⭐', '🌟', '✨', '🎈'];
        
        function createFloatingEmoji() {
            const emoji = document.createElement('div');
            emoji.textContent = emojis[Math.floor(Math.random() * emojis.length)];
            
            Object.assign(emoji.style, {
                position: 'fixed',
                fontSize: '20px',
                pointerEvents: 'none',
                zIndex: '500',
                left: Math.random() * window.innerWidth + 'px',
                top: window.innerHeight + 'px',
                transition: 'all 3s ease-out'
            });
            
            document.body.appendChild(emoji);
            
            // Animate upward
            setTimeout(() => {
                emoji.style.top = '-50px';
                emoji.style.transform = 'rotate(360deg)';
                emoji.style.opacity = '0';
            }, 100);
            
            // Remove after animation
            setTimeout(() => {
                if (emoji.parentNode) {
                    emoji.parentNode.removeChild(emoji);
                }
            }, 3100);
        }
        
        // Create floating emoji every 3 seconds
        setInterval(createFloatingEmoji, 3000);
    }
    
    // Initialize all features
    initThemeToggle();
    initImageGallery();
    initFloatingElements();
    
    // Add welcome animation
    const container = document.querySelector('.container');
    if (container) {
        container.style.opacity = '0';
        container.style.transform = 'translateY(20px)';
        container.style.transition = 'all 0.6s ease';
        
        setTimeout(() => {
            container.style.opacity = '1';
            container.style.transform = 'translateY(0)';
        }, 100);
    }
});