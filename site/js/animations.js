/* JoomlaBuilder Frontend Template - GSAP/AOS Animations */

document.addEventListener("DOMContentLoaded", function () {
    console.log("JoomlaBuilder Animations Loaded");

    // Check if GSAP is available
    if (typeof gsap !== 'undefined') {
        gsap.from(".header", { duration: 1, opacity: 0, y: -50, ease: "power2.out" });
        gsap.from(".content", { duration: 1, opacity: 0, y: 50, ease: "power2.out", delay: 0.5 });
        gsap.from(".footer", { duration: 1, opacity: 0, y: 30, ease: "power2.out", delay: 1 });
    } else {
        console.warn("GSAP is not loaded.");
    }

    // Initialize AOS if available
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            easing: "ease-in-out",
            once: true
        });
    } else {
        console.warn("AOS is not loaded.");
    }

    // Fade-in effect for sections
    document.querySelectorAll(".fade-in").forEach(element => {
        element.style.opacity = 0;
        element.style.transition = "opacity 1s ease-in-out";
        setTimeout(() => {
            element.style.opacity = 1;
        }, 500);
    });

    // Scroll-triggered animations
    const elementsToAnimate = document.querySelectorAll(".scroll-animation");
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("animate");
            }
        });
    }, { threshold: 0.5 });
    
    elementsToAnimate.forEach(element => {
        observer.observe(element);
    });
});
 
