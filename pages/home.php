<?php
include_once('../header.php')
?>
<link rel="stylesheet" href="styles/homePageStyle.css">
<main>
<section class="hero">
      <div class="container-lg">
        <div class="row align-items-center">
          <div class="col-lg-6 hero-content">
            <h1>
              Transform Your Body,
              <span class="highlight">Transform Your Life</span>
            </h1>
            <p>
              Join thousands of members achieving their fitness goals with our
              state-of-the-art facilities and expert trainers.
            </p>
            <div>
              <button class="btn-primary-custom">Get Started Today</button>
              <button class="btn-secondary-custom">Learn More</button>
            </div>
          </div>
          <div class="col-lg-6 text-center">
            <div style="font-size: 5rem; color: var(--neon-yellow)">
              <i class="fas fa-person-hiking"></i>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
      <div class="container-lg">
        <h2 class="section-title">
          Why Choose <span class="highlight">FitCore</span>
        </h2>
        <div class="row g-4">
          <div class="col-md-6 col-lg-4">
            <div class="feature-card">
              <i class="fas fa-dumbbell"></i>
              <h3>Modern Equipment</h3>
              <p>
                State-of-the-art fitness equipment with regular maintenance and
                upgrades to ensure your best performance.
              </p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="feature-card">
              <i class="fas fa-person-running"></i>
              <h3>Expert Trainers</h3>
              <p>
                Certified fitness professionals ready to guide you through
                personalized workout plans and nutrition advice.
              </p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="feature-card">
              <i class="fas fa-users"></i>
              <h3>Community Focus</h3>
              <p>
                Join a supportive community of fitness enthusiasts motivating
                each other to reach new heights.
              </p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="feature-card">
              <i class="fas fa-clock"></i>
              <h3>24/7 Access</h3>
              <p>
                Work out on your schedule with round-the-clock facility access
                and flexible membership options.
              </p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="feature-card">
              <i class="fas fa-heart"></i>
              <h3>Health Tracking</h3>
              <p>
                Advanced fitness tracking and analytics to monitor your progress
                and celebrate your achievements.
              </p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="feature-card">
              <i class="fas fa-spa"></i>
              <h3>Recovery Zone</h3>
              <p>
                Premium amenities including sauna, steam room, and recovery
                facilities for optimal results.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Classes Section -->
    <section class="classes" id="classes">
      <div class="container-lg">
        <h2 class="section-title">
          Popular <span class="highlight">Classes</span>
        </h2>
        <div class="row g-4">
          <div class="col-md-6 col-lg-4">
            <div class="class-card">
              <div class="class-image"><img src="/images/cross_fit_image.jpg"></div>
              <div class="class-info">
                <h4>CrossFit</h4>
                <p>
                  High-intensity functional fitness combining weightlifting,
                  gymnastics, and cardio.
                </p>
                <span class="class-badge">Beginner</span>
                <span class="class-badge">Advanced</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="class-card">
              <div class="class-image"><img src="/images/youga_image.jpg" alt=""></div>
              <div class="class-info">
                <h4>Yoga & Pilates</h4>
                <p>
                  Improve flexibility, strength, and mental clarity with our
                  mindful movement classes.
                </p>
                <span class="class-badge">All Levels</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="class-card">
              <div class="class-image"><img src="/images/spin_cycle_images.jpg" alt=""></div>
              <div class="class-info">
                <h4>Spin Cycle</h4>
                <p>
                  Heart-pounding indoor cycling classes with motivating music
                  and experienced instructors.
                </p>
                <span class="class-badge">High Intensity</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
      <div class="container-lg">
        <h2 class="section-title">
          What Our <span class="highlight">Members</span> Say
        </h2>
        <div class="row g-4">
          <div class="col-md-6 col-lg-4">
            <div class="testimonial-card">
              <div class="testimonial-text">
                "FitCore changed my life! The trainers are incredibly supportive
                and the facilities are amazing. I've achieved my fitness goals
                faster than I ever thought possible."
              </div>
              <div class="testimonial-author">
                <div class="author-avatar">JM</div>
                <div class="author-info">
                  <h5>James Miller</h5>
                  <p>Member since 2023</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="testimonial-card">
              <div class="testimonial-text">
                "The community here is incredible! Everyone is welcoming and the
                classes keep me motivated. Best investment in my health ever!"
              </div>
              <div class="testimonial-author">
                <div class="author-avatar">SJ</div>
                <div class="author-info">
                  <h5>Sarah Johnson</h5>
                  <p>Member since 2022</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="testimonial-card">
              <div class="testimonial-text">
                "Professional trainers, modern equipment, and a motivating
                atmosphere. FitCore is the complete package for anyone serious
                about fitness."
              </div>
              <div class="testimonial-author">
                <div class="author-avatar">MC</div>
                <div class="author-info">
                  <h5>Michael Chen</h5>
                  <p>Member since 2023</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</main>
    <?php
include_once('../footer.php')
?>
