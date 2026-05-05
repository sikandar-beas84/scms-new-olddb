<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Satish Chandra Memorial School | Where Legacy Inspires Future</title>
    <link rel="icon" href="<?= base_url('/public/admin/assets/images/site.png') ?>" type="image/png" sizes="16x16">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: 'Poppins', 'Segoe UI', 'Roboto', system-ui, -apple-system, sans-serif;
        }

        /* Main container */
        .hero {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            background: #0a1a2a;
        }

        /* Animated Image Layer - Smooth Ken Burns Effect */
        .hero__image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("<?= base_url('/public/img/banner-bg.jpg') ?>");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transform: scale(1);
            animation: kenBurnsZoom 20s ease-in-out infinite alternate;
            will-change: transform;
        }

        /* Premium Gradient Overlay - Creates Depth & Text Readability */
        .hero__overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                        rgba(10, 26, 42, 0.4) 0%,
                        rgba(5, 15, 25, 0.6) 50%,
                        rgba(0, 0, 0, 0.45) 100%);
            z-index: 2;
        }

        /* Animated Light Beam - Dynamic Cinematic Effect */
        .hero__light {
            position: absolute;
            top: 0;
            left: -100%;
            width: 80%;
            height: 100%;
            background: linear-gradient(90deg, 
                        transparent 0%,
                        rgba(255, 245, 200, 0.25) 30%,
                        rgba(255, 250, 210, 0.4) 50%,
                        rgba(255, 245, 200, 0.25) 70%,
                        transparent 100%);
            transform: skewX(-15deg);
            filter: blur(8px);
            animation: lightBeam 12s ease-in-out infinite;
            z-index: 3;
            pointer-events: none;
        }

        /* Floating Particles Effect - Adds Magical Atmosphere */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 3;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: radial-gradient(circle, rgba(255, 215, 140, 0.6) 0%, rgba(255, 180, 80, 0) 80%);
            border-radius: 50%;
            animation: floatParticle var(--duration, 12s) ease-in-out infinite;
            will-change: transform, opacity;
        }

        /* Main Content - Elegant Centered Typography */
        .hero__content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 10;
            width: 90%;
            max-width: 800px;
            animation: contentFadeUp 1.2s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .school__badge {
            display: inline-block;
            font-size: 0.85rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #f5d78c;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            padding: 6px 18px;
            border-radius: 40px;
            margin-bottom: 24px;
            font-weight: 500;
            border: 1px solid rgba(245, 215, 140, 0.3);
            animation: badgePulse 2s ease-in-out infinite;
        }

        .school__name {
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 700;
            color: #ffffff;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            letter-spacing: -0.02em;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .school__name span {
            color: #f5d78c;
            display: inline-block;
            animation: textGlow 3s ease-in-out infinite;
        }

        .school__tagline {
            font-size: clamp(1rem, 3vw, 1.3rem);
            color: rgba(255, 255, 255, 0.9);
            font-weight: 400;
            letter-spacing: 1px;
            margin-bottom: 32px;
            backdrop-filter: blur(4px);
        }

        .divider {
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #f5d78c, #e0a84c, #f5d78c);
            margin: 0 auto 24px auto;
            border-radius: 4px;
            animation: dividerWidth 1.5s ease-out;
        }

        .btn__explore {
            display: inline-block;
            padding: 14px 36px;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 1px;
            color: #0a1a2a;
            background: linear-gradient(135deg, #f5d78c, #e6c280);
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-transform: uppercase;
            font-family: inherit;
            animation: btnPulse 2s ease-in-out infinite;
        }

        .btn__explore:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #ffe4a3, #f5d78c);
        }

        /* Bottom Credit - Elegant & Minimal */
        .school__credit {
            position: fixed;
            bottom: 24px;
            right: 28px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            background: rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(8px);
            padding: 8px 18px;
            border-radius: 40px;
            z-index: 10;
            font-weight: 500;
            letter-spacing: 0.5px;
            border-left: 3px solid #f5d78c;
            transition: all 0.3s ease;
            pointer-events: auto;
        }

        .school__credit:hover {
            background: rgba(0, 0, 0, 0.55);
            color: #f5d78c;
            transform: translateX(-4px);
        }

        .school__credit::before {
            content: "🏛️ ";
            margin-right: 6px;
            font-size: 0.9rem;
        }

        /* Decorative Corner Elements */
        .corner-decoration {
            position: fixed;
            width: 120px;
            height: 120px;
            border: 2px solid rgba(245, 215, 140, 0.3);
            z-index: 5;
            pointer-events: none;
        }

        .corner-tl {
            top: 30px;
            left: 30px;
            border-right: none;
            border-bottom: none;
        }

        .corner-br {
            bottom: 30px;
            right: 30px;
            border-left: none;
            border-top: none;
        }

        /* Animations */
        @keyframes kenBurnsZoom {
            0% {
                transform: scale(1);
                filter: brightness(1);
            }
            50% {
                transform: scale(1.08);
                filter: brightness(1.02);
            }
            100% {
                transform: scale(1.12);
                filter: brightness(1.05);
            }
        }

        @keyframes lightBeam {
            0% {
                left: -100%;
                opacity: 0;
            }
            15% {
                opacity: 0.6;
            }
            30% {
                opacity: 1;
            }
            70% {
                opacity: 0.8;
            }
            85% {
                left: 120%;
                opacity: 0;
            }
            100% {
                left: 120%;
                opacity: 0;
            }
        }

        @keyframes floatParticle {
            0% {
                transform: translateY(100vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
            }
            50% {
                opacity: 0.4;
            }
            90% {
                opacity: 0.2;
            }
            100% {
                transform: translateY(-20vh) translateX(var(--drift, 50px)) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes contentFadeUp {
            0% {
                opacity: 0;
                transform: translate(-50%, -40%);
            }
            100% {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        @keyframes badgePulse {
            0%, 100% {
                opacity: 0.9;
                box-shadow: 0 0 0 0 rgba(245, 215, 140, 0.4);
            }
            50% {
                opacity: 1;
                box-shadow: 0 0 0 10px rgba(245, 215, 140, 0);
            }
        }

        @keyframes textGlow {
            0%, 100% {
                text-shadow: 0 0 5px rgba(245, 215, 140, 0.5);
            }
            50% {
                text-shadow: 0 0 20px rgba(245, 215, 140, 0.8);
            }
        }

        @keyframes dividerWidth {
            0% {
                width: 0;
                opacity: 0;
            }
            100% {
                width: 80px;
                opacity: 1;
            }
        }

        @keyframes btnPulse {
            0%, 100% {
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }
            50% {
                box-shadow: 0 6px 25px rgba(245, 215, 140, 0.4);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .school__badge {
                font-size: 0.7rem;
                padding: 4px 14px;
            }
            
            .btn__explore {
                padding: 12px 28px;
                font-size: 0.9rem;
            }
            
            .corner-decoration {
                width: 70px;
                height: 70px;
            }
            
            .corner-tl {
                top: 15px;
                left: 15px;
            }
            
            .corner-br {
                bottom: 15px;
                right: 15px;
            }
            
            .school__credit {
                bottom: 16px;
                right: 16px;
                font-size: 0.7rem;
                padding: 6px 14px;
            }
        }

        /* Optional: Add smooth transition for image load */
        .hero__image {
            transition: filter 0.5s ease;
        }

        /* Loading state */
        .hero {
            opacity: 0;
            animation: pageLoad 0.8s ease-out forwards;
        }

        @keyframes pageLoad {
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="hero">
        <!-- Animated Background Image -->
        <div class="hero__image" title="SCM Memorial School Campus"></div>
        
        <!-- Overlay Layers -->
        <div class="hero__overlay"></div>
        <div class="hero__light"></div>
        
        <!-- Floating Particles -->
        <div class="particles" id="particlesContainer"></div>
        
        <!-- Decorative Corners -->
        <div class="corner-decoration corner-tl"></div>
        <div class="corner-decoration corner-br"></div>
        
        <!-- Main Content -->
        <div class="hero__content">
            <div class="school__badge">Est. 2004 | Legacy of Excellence</div>
            <h1 class="school__name">
                Satish Chandra Memorial <span>School</span>
            </h1>
            <div class="divider"></div>
            <p class="school__tagline">
                Where tradition meets innovation • Nurturing minds, honoring heritage
            </p>
            <a href="<?= base_url('login') ?>" class="btn__explore" id="exploreBtn">
                Discover More
            </a>
        </div>
        
        <!-- Bottom Credit -->
        <div class="school__credit">
            SC Memorial School
        </div>
    </div>

    <script>
        (function() {
            // Ensure no scrolling
            document.documentElement.style.overflow = 'hidden';
            document.body.style.overflow = 'hidden';
            
            // ------------------------------------------------------------------
            // Dynamic Particle System - Enhanced with Organic Movement
            // ------------------------------------------------------------------
            const particlesContainer = document.getElementById('particlesContainer');
            if (particlesContainer) {
                const PARTICLE_COUNT = 60;
                
                for (let i = 0; i < PARTICLE_COUNT; i++) {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');
                    
                    // Random size between 2px and 8px
                    const size = 2 + Math.random() * 6;
                    particle.style.width = size + 'px';
                    particle.style.height = size + 'px';
                    
                    // Random starting position (horizontal)
                    const startX = Math.random() * 100;
                    particle.style.left = startX + '%';
                    particle.style.bottom = '0';
                    
                    // Custom properties for varied animation
                    const duration = 8 + Math.random() * 18;
                    const drift = -80 + Math.random() * 160; // -80px to 80px horizontal drift
                    
                    particle.style.setProperty('--duration', duration + 's');
                    particle.style.setProperty('--drift', drift + 'px');
                    
                    // Random animation delay
                    const delay = Math.random() * 15;
                    particle.style.animationDelay = delay + 's';
                    
                    // Vary opacity and color warmth
                    const opacity = 0.2 + Math.random() * 0.5;
                    particle.style.background = `radial-gradient(circle, rgba(245, 215, 140, ${opacity}) 0%, rgba(245, 180, 80, 0) 80%)`;
                    
                    particlesContainer.appendChild(particle);
                }
            }
            
            // ------------------------------------------------------------------
            // Interactive Mouse Parallax - Gentle Background Shift
            // ------------------------------------------------------------------
            const heroImage = document.querySelector('.hero__image');
            if (heroImage) {
                let targetX = 50;
                let targetY = 50;
                let currentX = 50;
                let currentY = 50;
                
                document.addEventListener('mousemove', (e) => {
                    const xPercent = e.clientX / window.innerWidth;
                    const yPercent = e.clientY / window.innerHeight;
                    
                    // Shift background position subtly between 45% and 55%
                    targetX = 45 + (xPercent * 10);
                    targetY = 45 + (yPercent * 10);
                });
                
                function smoothParallax() {
                    currentX += (targetX - currentX) * 0.08;
                    currentY += (targetY - currentY) * 0.08;
                    
                    heroImage.style.backgroundPosition = `${currentX}% ${currentY}%`;
                    requestAnimationFrame(smoothParallax);
                }
                
                smoothParallax();
            }
            
            // ------------------------------------------------------------------
            // Additional Dynamic Light Effect - Random Gleam Flashes
            // ------------------------------------------------------------------
            const lightBeam = document.querySelector('.hero__light');
            if (lightBeam) {
                // Occasionally add an extra strong gleam for dramatic effect
                setInterval(() => {
                    if (Math.random() > 0.7) {
                        lightBeam.style.animation = 'none';
                        lightBeam.style.left = '-100%';
                        lightBeam.style.opacity = '1';
                        setTimeout(() => {
                            lightBeam.style.animation = 'lightBeam 12s ease-in-out infinite';
                        }, 50);
                    }
                }, 18000);
            }
            
            // ------------------------------------------------------------------
            // Button Interaction with Smooth Ripple & Navigation Simulation
            // ------------------------------------------------------------------
            const exploreBtn = document.getElementById('exploreBtn');
            if (exploreBtn) {
                exploreBtn.addEventListener('click', function(e) {
                    // Create ripple effect
                    const ripple = document.createElement('span');
                    ripple.style.position = 'absolute';
                    ripple.style.borderRadius = '50%';
                    ripple.style.backgroundColor = 'rgba(255, 255, 255, 0.6';
                    ripple.style.width = '100px';
                    ripple.style.height = '100px';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'rippleEffect 0.6s ease-out';
                    ripple.style.pointerEvents = 'none';
                    
                    const rect = this.getBoundingClientRect();
                    ripple.style.left = (e.clientX - rect.left - 50) + 'px';
                    ripple.style.top = (e.clientY - rect.top - 50) + 'px';
                    ripple.style.position = 'absolute';
                    
                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);
                    
                    setTimeout(() => ripple.remove(), 600);
                    
                    // Add subtle feedback animation
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                    
                    // Optional: Show an alert or redirect (you can replace with actual navigation)
                    console.log('Explore SCM Memorial School - Legacy in Motion');
                    
                    // For demonstration - add a nice visual feedback
                    const content = document.querySelector('.hero__content');
                    content.style.animation = 'none';
                    setTimeout(() => {
                        content.style.animation = 'contentFadeUp 0.5s cubic-bezier(0.2, 0.9, 0.4, 1.1)';
                    }, 10);
                });
            }
            
            // Add ripple keyframe dynamically
            const styleSheet = document.createElement("style");
            styleSheet.textContent = `
                @keyframes rippleEffect {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(styleSheet);
            
            // ------------------------------------------------------------------
            // Smooth Background Image Preload Effect - Prevent Flicker
            // ------------------------------------------------------------------
            const img = new Image();
            img.src = "<?= base_url('/public/img/banner-bg.jpg') ?>";
            img.onload = () => {
                document.querySelector('.hero__image').style.opacity = '1';
            };
            
            // ------------------------------------------------------------------
            // Add dynamic gradient rotation on overlay for subtle atmosphere
            // ------------------------------------------------------------------
            const overlay = document.querySelector('.hero__overlay');
            if (overlay) {
                let angle = 135;
                setInterval(() => {
                    angle += 0.2;
                    if (angle > 225) angle = 135;
                    overlay.style.background = `linear-gradient(${angle}deg, 
                        rgba(10, 26, 42, 0.45) 0%,
                        rgba(5, 15, 25, 0.6) 50%,
                        rgba(0, 0, 0, 0.5) 100%)`;
                }, 8000);
            }
            
            // ------------------------------------------------------------------
            // Scroll Blocker & Touch Events (Prevent Pull-to-Refresh)
            // ------------------------------------------------------------------
            document.body.addEventListener('touchmove', function(e) {
                if (e.target === document.body || e.target === document.documentElement) {
                    e.preventDefault();
                }
            }, { passive: false });
            
            // ------------------------------------------------------------------
            // Additional Sparkle Effect on School Name (Micro-Interaction)
            // ------------------------------------------------------------------
            const schoolName = document.querySelector('.school__name span');
            if (schoolName) {
                setInterval(() => {
                    schoolName.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        schoolName.style.transform = 'scale(1)';
                    }, 300);
                }, 4000);
            }
            
            // ------------------------------------------------------------------
            // Window Resize Handler - Maintain Aspect Ratio & Particle Redistribution
            // ------------------------------------------------------------------
            window.addEventListener('resize', () => {
                // Re-adjust background coverage
                if (heroImage) {
                    heroImage.style.backgroundSize = 'cover';
                }
                
                // Optional: regenerate particles on extreme resize? Not necessary but graceful
                if (window.innerWidth < 768) {
                    // Ensure particles remain lightweight on mobile
                    const particles = document.querySelectorAll('.particle');
                    if (particles.length > 45) {
                        const extra = particles.length - 40;
                        for (let i = 0; i < extra && particles[i]; i++) {
                            if (particles[i]) particles[i].remove();
                        }
                    }
                }
            });
            
            // ------------------------------------------------------------------
            // Cursor Trail Effect - Delicate Sparkle (Premium Feel)
            // ------------------------------------------------------------------
            let trailTimeout;
            document.addEventListener('mousemove', (e) => {
                if (window.innerWidth > 768) {
                    const trail = document.createElement('div');
                    trail.style.position = 'fixed';
                    trail.style.width = '4px';
                    trail.style.height = '4px';
                    trail.style.background = 'radial-gradient(circle, #f5d78c, transparent)';
                    trail.style.borderRadius = '50%';
                    trail.style.pointerEvents = 'none';
                    trail.style.zIndex = '9999';
                    trail.style.left = e.clientX - 2 + 'px';
                    trail.style.top = e.clientY - 2 + 'px';
                    trail.style.opacity = '0.6';
                    trail.style.transition = 'opacity 0.4s ease';
                    document.body.appendChild(trail);
                    
                    setTimeout(() => {
                        trail.style.opacity = '0';
                        setTimeout(() => trail.remove(), 400);
                    }, 200);
                }
            });
            
            // ------------------------------------------------------------------
            // Simple Console Welcome (Developer Touch)
            // ------------------------------------------------------------------
            console.log('%c✨ SCM Memorial School | Honoring Legacy, Inspiring Minds ✨', 'color: #f5d78c; font-size: 14px; font-weight: bold;');
            console.log('%cExperience the animated heritage', 'color: #e6c280; font-size: 12px;');
            
            // ------------------------------------------------------------------
            // Lazy load fallback: ensure image is visible
            // ------------------------------------------------------------------
            setTimeout(() => {
                const heroImgDiv = document.querySelector('.hero__image');
                if (heroImgDiv && getComputedStyle(heroImgDiv).backgroundImage === 'none') {
                    heroImgDiv.style.backgroundImage = "url('<?= base_url('/public/img/banner-bg.jpg') ?>')";
                }
            }, 100);
        })();
    </script>
</body>
</html>