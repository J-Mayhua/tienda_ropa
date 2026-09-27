<?php
// aplicacion/vistas/empresa/nosotros.php

require_once __DIR__ . '/../../../configuracion/config.php';
require_once __DIR__ . '/../plantillas/cabecera.php';
?>

<link rel="stylesheet" href="/Tienda_ropa/publico/recursos/css/nosotros.css">

<!-- Banner de Nosotros -->
<section class="about-banner">
    <div class="about-overlay"></div>
    <div class="about-content">
        <span class="banner-sub">StyleHub Co.</span>
        <h1>Nuestra historia</h1>
        <p>Confeccionando confianza, estilo y momentos inolvidables desde 2015.</p>
        <div class="banner-scroll">
            <span class="scroll-text">Descubrir</span>
            <div class="scroll-line"></div>
        </div>
    </div>
</section>

<!-- Historia y Misión -->
<section class="about-section mission-section">
    <div class="container">
        <div class="section-grid">
            <div class="content-col" data-aos="fade-right">
                <h2 class="section-title">Una pasión que comenzó con un sueño</h2>
                <p class="section-text">Nacimos con la visión de crear prendas que combinen diseño contemporáneo, materiales premium y sostenibilidad. Cada una de nuestras piezas cuenta una historia de respeto, esfuerzo y excelencia artesanal.</p>

                <div class="mission-values">
                    <div class="mission-card">
                        <div class="mission-icon"><i class="fas fa-bullseye"></i></div>
                        <h3>Misión</h3>
                        <p>Inspirar autenticidad a través de colecciones exclusivas, diseñadas éticamente.</p>
                    </div>
                    <div class="mission-card">
                        <div class="mission-icon"><i class="fas fa-eye"></i></div>
                        <h3>Visión</h3>
                        <p>Ser el referente de moda sostenible y de vanguardia en toda la región.</p>
                    </div>
                </div>
            </div>

            <div class="image-col" data-aos="fade-left">
                <div class="about-image-container">
                    <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=800&q=80" alt="Historia" class="about-image">
                    <div class="experience-badge">
                        <span class="years">10</span>
                        <span class="text">Años de<br>pasión</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Ribbon -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">15K+</div>
                <div class="stat-label">Clientes satisfechos</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50K+</div>
                <div class="stat-label">Prendas vendidas</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Sostenible</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">10+</div>
                <div class="stat-label">Tiendas físicas</div>
            </div>
        </div>
    </div>
</section>

<!-- Valores -->
<section class="about-section values-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">Nuestros valores</h2>
            <p class="section-subtitle">Los principios que guían cada decisión en StyleHub, de la tela al mostrador.</p>
        </div>

        <div class="values-grid">
            <div class="value-card" data-aos="fade-up" data-aos-delay="100">
                <div class="value-icon"><i class="fas fa-leaf"></i></div>
                <div>
                    <h3>Sostenibilidad</h3>
                    <p>Materiales ecológicos y procesos limpios que reducen nuestra huella ambiental.</p>
                </div>
            </div>
            <div class="value-card" data-aos="fade-up" data-aos-delay="150">
                <div class="value-icon"><i class="fas fa-heart"></i></div>
                <div>
                    <h3>Pasión</h3>
                    <p>Amamos lo que hacemos, buscando siempre superar las expectativas de nuestra comunidad.</p>
                </div>
            </div>
            <div class="value-card" data-aos="fade-up" data-aos-delay="200">
                <div class="value-icon"><i class="fas fa-gem"></i></div>
                <div>
                    <h3>Calidad</h3>
                    <p>Textiles premium de alta durabilidad para garantizar prendas que perduran.</p>
                </div>
            </div>
            <div class="value-card" data-aos="fade-up" data-aos-delay="250">
                <div class="value-icon"><i class="fas fa-handshake"></i></div>
                <div>
                    <h3>Integridad</h3>
                    <p>Trato justo, transparente e igualitario con colaboradores y clientes.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Equipo -->
<section class="about-section team-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">Nuestro equipo</h2>
            <p class="section-subtitle">Profesionales unidos por la innovación, el detalle y la excelencia textil.</p>
        </div>

        <div class="team-grid">
            <div class="team-card" data-aos="fade-up" data-aos-delay="100">
                <div class="team-image-container">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&h=600&q=80" alt="Carlos Mendoza" class="team-image">
                    <div class="team-social">
                        <a href="#" class="team-social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="team-social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="team-info">
                    <h3>Carlos Mendoza</h3>
                    <span>Director creativo</span>
                </div>
            </div>

            <div class="team-card" data-aos="fade-up" data-aos-delay="150">
                <div class="team-image-container">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=600&h=600&q=80" alt="María Sánchez" class="team-image">
                    <div class="team-social">
                        <a href="#" class="team-social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="team-social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="team-info">
                    <h3>María Sánchez</h3>
                    <span>Diseñadora principal</span>
                </div>
            </div>

            <div class="team-card" data-aos="fade-up" data-aos-delay="200">
                <div class="team-image-container">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&h=600&q=80" alt="Luis Torres" class="team-image">
                    <div class="team-social">
                        <a href="#" class="team-social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="team-social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="team-info">
                    <h3>Luis Torres</h3>
                    <span>Director de producción</span>
                </div>
            </div>

            <div class="team-card" data-aos="fade-up" data-aos-delay="250">
                <div class="team-image-container">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=600&h=600&q=80" alt="Ana Díaz" class="team-image">
                    <div class="team-social">
                        <a href="#" class="team-social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="team-social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="team-info">
                    <h3>Ana Díaz</h3>
                    <span>Directora de marketing</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nuestras Tiendas -->
<section class="about-section stores-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">Nuestras tiendas</h2>
            <p class="section-subtitle">Vive una experiencia de compra premium y asesoría personalizada en nuestros locales físicos.</p>
        </div>

        <div class="stores-grid">
            <div class="store-card" data-aos="fade-up" data-aos-delay="100">
                <div class="store-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=600&h=400&q=80" alt="Tienda Miraflores" class="store-image">
                    <span class="store-tag">Concept store</span>
                </div>
                <div class="store-details">
                    <h3>Miraflores Flagship</h3>
                    <ul class="store-info-list">
                        <li><i class="fas fa-map-marker-alt"></i> Av. Larco 456, Miraflores, Lima</li>
                        <li><i class="fas fa-clock"></i> Lun - Sáb: 10:00 AM - 9:00 PM</li>
                        <li><i class="fas fa-phone-alt"></i> (01) 445-8930</li>
                    </ul>
                    <a href="https://maps.google.com" target="_blank" class="store-btn">
                        <span>Ver en Google Maps</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="store-card" data-aos="fade-up" data-aos-delay="150">
                <div class="store-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=600&h=400&q=80" alt="Tienda San Isidro" class="store-image">
                    <span class="store-tag">Atelier premium</span>
                </div>
                <div class="store-details">
                    <h3>San Isidro Studio</h3>
                    <ul class="store-info-list">
                        <li><i class="fas fa-map-marker-alt"></i> Av. Camino Real 782, San Isidro</li>
                        <li><i class="fas fa-clock"></i> Lun - Sáb: 10:00 AM - 8:00 PM</li>
                        <li><i class="fas fa-phone-alt"></i> (01) 221-5044</li>
                    </ul>
                    <a href="https://maps.google.com" target="_blank" class="store-btn">
                        <span>Ver en Google Maps</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="store-card" data-aos="fade-up" data-aos-delay="200">
                <div class="store-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1582037919819-1a4a4000b0f0?auto=format&fit=crop&w=600&h=400&q=80" alt="Tienda Arequipa" class="store-image">
                    <span class="store-tag">Showroom</span>
                </div>
                <div class="store-details">
                    <h3>Arequipa Imperial</h3>
                    <ul class="store-info-list">
                        <li><i class="fas fa-map-marker-alt"></i> Calle Mercaderes 124, Arequipa</li>
                        <li><i class="fas fa-clock"></i> Lun - Dom: 11:00 AM - 8:30 PM</li>
                        <li><i class="fas fa-phone-alt"></i> (054) 283-910</li>
                    </ul>
                    <a href="https://maps.google.com" target="_blank" class="store-btn">
                        <span>Ver en Google Maps</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonios -->
<section class="about-section testimonials-section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">Lo que dicen de nosotros</h2>
            <p class="section-subtitle">Nuestros clientes son los verdaderos embajadores de la marca.</p>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"La calidad de la tela es espectacular y el calce es perfecto. Es mi tienda favorita por su diseño elegante y su enfoque ecológico."</p>
                <div class="testimonial-user">
                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=150&h=150&q=80" alt="Sofia R." class="testimonial-avatar">
                    <div class="testimonial-meta">
                        <h4>Sofía Rodríguez</h4>
                        <span>Cliente verificado <i class="fas fa-check-circle verified-icon"></i></span>
                    </div>
                </div>
            </div>

            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="150">
                <div class="testimonial-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"He comprado trajes y camisas casuales. Los acabados, la textura y los colores son incomparables. Destaco la atención personalizada en San Isidro."</p>
                <div class="testimonial-user">
                    <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=150&h=150&q=80" alt="Mateo G." class="testimonial-avatar">
                    <div class="testimonial-meta">
                        <h4>Mateo Guerrero</h4>
                        <span>Cliente verificado <i class="fas fa-check-circle verified-icon"></i></span>
                    </div>
                </div>
            </div>

            <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Prendas atemporales que combinan con todo y no se desgastan. Su compromiso real con prácticas éticas de confección me hace volver siempre."</p>
                <div class="testimonial-user">
                    <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=150&h=150&q=80" alt="Valeria P." class="testimonial-avatar">
                    <div class="testimonial-meta">
                        <h4>Valeria Pezo</h4>
                        <span>Cliente verificado <i class="fas fa-check-circle verified-icon"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="about-cta">
    <div class="cta-overlay"></div>
    <div class="container cta-content" data-aos="zoom-in">
        <h2>Viste con consciencia y estilo</h2>
        <p>Explora nuestras nuevas colecciones atemporales y descubre el calce perfecto para ti.</p>
        <a href="/Tienda_ropa/publico/index.php" class="cta-btn">
            <span>Ver catálogo</span>
            <i class="fas fa-shopping-bag"></i>
        </a>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 700,
                once: true,
                offset: 40
            });
        }
    });
</script>

<?php require_once __DIR__ . '/../plantillas/pie.php'; ?>
