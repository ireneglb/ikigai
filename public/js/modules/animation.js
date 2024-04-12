document.addEventListener("DOMContentLoaded", function() {
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    });

    document.querySelectorAll('.home-text p, .home-img img, .home-equipe p').forEach(function(element) {
        element.classList.add('animate-text');
        observer.observe(element);
    });
});