tailwind.config = {
    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                },
                secondary: {
                    50: '#fefce8',
                    100: '#fef9c3',
                    200: '#fef08a',
                    300: '#fde047',
                    400: '#facc15',
                    500: '#eab308',
                    600: '#ca8a04',
                    700: '#a16207',
                    800: '#854d0e',
                    900: '#713f12',
                },
                accent: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                }
            }
        }
    }
}

// Barre de progression
window.onscroll = function () {
    const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    document.getElementById("progressBar").style.width = scrolled + "%";
};
document.addEventListener("DOMContentLoaded", () => {
    const desktop_input = document.getElementById("searchInput");
    const mobile_input = document.getElementById("mobile_searchInput");
    const desktop_suggestionsDiv = document.getElementById("suggestions");
    const mobile_suggestionsDiv = document.getElementById("suggestions_mobile");

    // Gestionnaire pour les suggestions sur desktop
    desktop_suggestionsDiv.addEventListener('click', (e) => {
        if (e.target.dataset.suggestion) {
            desktop_input.value = e.target.dataset.suggestion;
            desktop_suggestionsDiv.innerHTML = "";
        }
    });
    desktop_input.addEventListener("input", () => {
        const query = desktop_input.value.trim();
        desktop_suggestionsDiv.innerHTML = "";
        if (query.length < 1) return;
        fetch(`suggestions.php?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                desktop_suggestionsDiv.innerHTML = data.map(s =>
                    `<div class='cursor-pointer hover:bg-gray-200 p-1' 
                    data-suggestion="${s.replace(/"/g, '&quot;')}">
                 ${s}
               </div>`
                ).join("");
            })
            .catch(error => {
                console.error("Erreur de suggestions:", error);
            });
    });
    // Gestionnaire pour les suggestions sur mobile

    mobile_suggestionsDiv.addEventListener('click', (e) => {
        if (e.target.dataset.suggestion) {
            mobile_input.value = e.target.dataset.suggestion;
            mobile_suggestionsDiv.innerHTML = "";
        }
    });
    mobile_input.addEventListener("input", () => {
        const query = mobile_input.value.trim();
        mobile_suggestionsDiv.innerHTML = "";
        if (query.length < 1) return;
        fetch(`suggestions.php?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                mobile_suggestionsDiv.innerHTML = data.map(s =>
                    `<div class='cursor-pointer hover:bg-gray-200 p-1' 
                    data-suggestion="${s.replace(/"/g, '&quot;')}">
                 ${s}
               </div>`
                ).join("");
            })
            .catch(error => {
                console.error("Erreur de suggestions:", error);
            });
    });

    const menuToggle = document.getElementById('menu-toggle');
    const closeMenu = document.getElementById('close-menu');
    const mobileMenu = document.getElementById('mobile-menu');
    const searchToggle = document.getElementById('search-toggle');
    const mobileSearch = document.getElementById('mobile-search');

    // Toggle mobile menu
    menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('open');
        menuToggle.classList.toggle('open');
        document.body.style.overflow = 'hidden';
    });

    // Close mobile menu
    closeMenu.addEventListener('click', () => {
        mobileMenu.classList.remove('open');
        menuToggle.classList.remove('open');
        document.body.style.overflow = '';
    });

    // Toggle mobile search
    searchToggle.addEventListener('click', () => {
        mobileSearch.classList.toggle('hidden');
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!mobileMenu.contains(e.target) && !menuToggle.contains(e.target) && mobileMenu.classList.contains('open')) {
            mobileMenu.classList.remove('open');
            menuToggle.classList.remove('open');
            document.body.style.overflow = '';
        }
    });
});


// Bouton retour en haut
const backToTopButton = document.getElementsByClassName('backToTop');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        backToTopButton.classList.add('visible');
    } else {
        backToTopButton.classList.remove('visible');
    }
});

backToTopButton.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);

        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 20,
                behavior: 'smooth'
            });

            // Update active nav item
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active-nav-item');
            });
            this.classList.add('active-nav-item');
        }
    });
});
// Add shadow to header on scroll
window.addEventListener('scroll', function () {
    const header = document.querySelector('header');
    if (window.scrollY > 50) {
        header.classList.add('shadow-lg');
    } else {
        header.classList.remove('shadow-lg');
    }
});
