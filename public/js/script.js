gsap.registerPlugin(ScrollTrigger);

const biomes=document.querySelectorAll(".bg");

biomes.forEach((biome, i)=> {

        // Fade IN
        gsap.to(biome, {

            opacity: 1,
            scrollTrigger: {
                trigger: `.zone:nth-of-type(${i + 1})`,
                start: "top center",
                end: "bottom center",
                scrub: true
            }
        });


// Initial fade-in animation for overlay text
gsap.from(".hero-overlay h1", {opacity:0, y:-50, duration:1});
gsap.from(".hero-overlay p", {opacity:0, y:30, duration:1, delay:0.5});
gsap.from(".hero-overlay .btn", {opacity:0, scale:0.8, duration:1, delay:1});


    // Fade OUT
    gsap.to(biome, {

        opacity: 0,
        scrollTrigger: {
            trigger: `.zone:nth-of-type(${i + 2})`,
            start: "top center",
            end: "bottom center",
            scrub: true
        }
    });

   
    document.addEventListener("DOMContentLoaded", () => {
        const cards = document.querySelectorAll(".animal-card, .habitat h2");

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                }
            });
        }, { threshold: 0.2 });

        cards.forEach(card => observer.observe(card));
    });
      
});