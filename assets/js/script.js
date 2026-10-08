// ============================================
// 🎵 INVENTARIS ALAT MUSIK - INTERACTIVE JS
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    // === MOBILE MENU TOGGLE ===
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    
    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            menuToggle.textContent = navLinks.classList.contains('active') ? '✕' : '☰';
        });
        
        // Close menu when clicking a link
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                menuToggle.textContent = '☰';
            });
        });
    }
    
    // === AUTO-HIDE ALERTS WITH SMOOTH ANIMATION ===
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert, index) {
        setTimeout(function() {
            alert.style.transition = 'all 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateX(100px)';
            setTimeout(function() {
                alert.remove();
            }, 500);
        }, 4000 + (index * 500));
    });
    
    // === TABLE ROW ANIMATION ON SCROLL ===
    const tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        row.style.transition = 'all 0.4s ease';
        
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 100 * index);
    });
    
    // === STAT CARDS COUNTER ANIMATION ===
    const statValues = document.querySelectorAll('.stat-value');
    statValues.forEach(stat => {
        const target = parseInt(stat.textContent.replace(/\D/g, ''));
        if (!isNaN(target)) {
            animateCounter(stat, target);
        }
    });
    
    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString('id-ID');
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString('id-ID');
            }
        }, 30);
    }
    
    // === SEARCH INPUT ANIMATION ===
    const searchInput = document.querySelector('.search-form input');
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.transition = 'transform 0.3s ease';
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    }
    
    // === BUTTON RIPPLE EFFECT ===
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
            `;
            
            this.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });
    
    // Add ripple keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
    
    // === FORM INPUT ANIMATIONS ===
    const formInputs = document.querySelectorAll('.form-group input, .form-group select, .form-group textarea');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateX(5px)';
            this.parentElement.style.transition = 'transform 0.3s ease';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateX(0)';
        });
    });
    
    // === CONFIRM DELETE MODAL (Enhanced) ===
    const deleteLinks = document.querySelectorAll('a[href*="delete.php"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            const productName = this.closest('tr')?.querySelector('td:nth-child(2)')?.textContent || 'produk ini';
            
            showConfirmModal(
                '🗑️ Hapus Produk?',
                `Apakah kamu yakin ingin menghapus "${productName}"? Tindakan ini tidak dapat dibatalkan.`,
                url
            );
        });
    });
    
    function showConfirmModal(title, message, confirmUrl) {
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay';
        overlay.innerHTML = `
            <div class="modal">
                <h3>${title}</h3>
                <p>${message}</p>
                <div class="modal-actions">
                    <button class="btn btn-secondary" id="cancelBtn">Batal</button>
                    <a href="${confirmUrl}" class="btn btn-danger">Ya, Hapus</a>
                </div>
            </div>
        `;
        
        document.body.appendChild(overlay);
        
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                overlay.remove();
            }
        });
        
        document.getElementById('cancelBtn').addEventListener('click', () => overlay.remove());
    }
    
    // === PRICE FORMAT HELPER ===
    const priceInputs = document.querySelectorAll('input[name="harga"]');
    priceInputs.forEach(input => {
        input.addEventListener('input', function() {
            let value = this.value.replace(/[^0-9]/g, '');
            if (value) {
                this.value = parseInt(value).toLocaleString('id-ID');
            }
        });
        
        input.addEventListener('blur', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
    
    // === SMOOTH SCROLL TO TOP ===
    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
    
    // Add scroll-to-top button if page is long
    if (document.body.scrollHeight > window.innerHeight * 2) {
        const scrollBtn = document.createElement('button');
        scrollBtn.innerHTML = '↑';
        scrollBtn.style.cssText = `
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.4);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 99;
        `;
        
        document.body.appendChild(scrollBtn);
        
        window.addEventListener('scroll', () => {
            scrollBtn.style.opacity = window.scrollY > 300 ? '1' : '0';
        });
        
        scrollBtn.addEventListener('click', scrollToTop);
    }
    
    console.log('🎵 Inventaris Alat Musik - UI Loaded Successfully!');
});