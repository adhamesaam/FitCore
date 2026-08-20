<?php 
include_once('../header.php')
?>
<link rel="stylesheet" href="styles/subscription.css">    

    <!-- ===== HERO SECTION ===== -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h1>Manage <span>multiple gyms</span> from one dashboard</h1>
                <p>Centralize operations, automate workflows, and scale your gym empire with intelligent management tools designed for modern fitness chains.</p>
            </div>
        </div>
    </section>

    <!-- ===== PRICING SECTION ===== -->
    <section class="pricing-section" id="pricing">
        <div class="container">
            <div class="pricing-header">
                <h2>Simple, Transparent Pricing</h2>
                <p>Choose the perfect plan for your gym's growth stage. Upgrade or downgrade anytime.</p>
            </div>

            <div class="pricing-cards">
                <!-- STARTER PLAN -->
                <div class="pricing-card">
                    <div class="card-plan-name">Starter</div>
                    <div class="card-plan-desc">Single-location gyms</div>
                    <div class="card-price">$29</div>
                    <div class="card-price-period">/month • $261/year (save 25%)</div>
                    <button class="btn btn-primary card-button" name="subscribeBtn">Subscribe Now</button>
                    <ul class="card-features">
                        <li>Up to 100 members</li>
                        <li>1 branch location</li>
                        <li>QR check-in</li>
                        <li>Payment tracking</li>
                        <li>1 admin account</li>
                        <li>Email support</li>
                    </ul>
                </div>

                <!-- PROFESSIONAL PLAN (FEATURED) -->
                <div class="pricing-card featured">
                    <div class="card-plan-name">Professional</div>
                    <div class="card-plan-desc">Growing chains & franchises</div>
                    <div class="card-price">$59</div>
                    <div class="card-price-period">/month • $711/year (save 25%)</div>
                    <button class="btn btn-primary card-button" name="subscribeBtn">Subscribe Now</button>
                    <ul class="card-features">
                        <li>Up to 500 members</li>
                        <li>Up to 3 branches</li>
                        <li>Custom staff roles</li>
                        <li>Class scheduling</li>
                        <li>Multi-branch analytics</li>
                        <li>Automated invoices</li>
                        <li>Priority support</li>
                    </ul>
                </div>

                <!-- ENTERPRISE PLAN -->
                <div class="pricing-card">
                    <div class="card-plan-name">Enterprise</div>
                    <div class="card-plan-desc">Large-scale operations</div>
                    <div class="card-price">$99</div>
                    <div class="card-price-period">/month + $30/branch</div>
                    <button class="btn btn-primary card-button" name="subscribeBtn">Subscribe Now</button>
                    <ul class="card-features">
                        <li>Unlimited members</li>
                        <li>Unlimited branches</li>
                        <li>Granular permissions</li>
                        <li>Advanced analytics</li>
                        <li>API access</li>
                        <li>White-label portal</li>
                        <li>Dedicated manager</li>
                        <li>Phone + Email support</li>
                    </ul>
                </div>
            </div>

            <!-- SOCIAL PROOF -->
            <div class="social-proof">
                <div class="social-proof-title">Trusted by fitness professionals worldwide</div>
                <div class="social-proof-stats">
                    <div class="stat">
                        <div class="stat-value">2,000+</div>
                        <div class="stat-label">Active Gyms</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value">500K+</div>
                        <div class="stat-label">Members Managed</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value">4.8★</div>
                        <div class="stat-label">Average Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FEATURES SECTION ===== -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="features-header">
                <h2>Why Gym Managers Choose FitCore</h2>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h4>Centralized Control</h4>
                    <p>Manage all branches, staff, and members from a single login</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h4>Time-Saving Automations</h4>
                    <p>Stop chasing payments; automated reminders handle collections</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📈</div>
                    <h4>Real-Time Insights</h4>
                    <p>See revenue, attendance, and trends instantly across all gyms</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h4>Zero Training Curve</h4>
                    <p>Intuitive interface that your staff learns in minutes, not days</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h4>Bank-Level Security</h4>
                    <p>Member data is encrypted, compliant, and always protected</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🚀</div>
                    <h4>Built for Scale</h4>
                    <p>Grow from 1 gym to 100+ without changing your management tools</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== COMPARISON TABLE ===== -->
    <section class="comparison-section">
        <div class="container">
            <div class="comparison-header">
                <h2>Feature Comparison</h2>
            </div>

            <div class="comparison-table-wrapper ">
                <table class="comparison-table table">
                    <thead>
                        <tr>
                            <th>Feature</th>
                            <th>Starter</th>
                            <th>Professional</th>
                            <th>Enterprise</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Active Members</strong></td>
                            <td>100</td>
                            <td>500</td>
                            <td>Unlimited</td>
                        </tr>
                        <tr>
                            <td><strong>Branch Locations</strong></td>
                            <td>1</td>
                            <td>3</td>
                            <td>Unlimited</td>
                        </tr>
                        <tr>
                            <td><strong>Staff Accounts</strong></td>
                            <td>1</td>
                            <td>5</td>
                            <td>Unlimited</td>
                        </tr>
                        <tr>
                            <td><strong>Custom Staff Roles</strong></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td><strong>Member Profiles</strong></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td><strong>Attendance Tracking</strong></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td><strong>QR Check-in</strong></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td><strong>Class Scheduling</strong></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td><strong>Multi-Branch Analytics</strong></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td><strong>Payment Management</strong></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td><strong>Automated Invoices</strong></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td><strong>API Access</strong></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td><strong>White-Label Portal</strong></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>
                        <tr>
                            <td><strong>Support Tier</strong></td>
                            <td>Email</td>
                            <td>Priority Email</td>
                            <td>Phone + Email</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="faq-section" id="faq">
        <div class="container">
            <div class="faq-header">
                <h2>Frequently Asked Questions</h2>
            </div>

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Can I upgrade or downgrade anytime?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes. You can change your plan at any time. Upgrades take effect immediately, and downgrades apply at your next billing cycle.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    What happens if I exceed my member limit?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    You'll get a heads-up when you're approaching your limit. We'll recommend upgrading, but you can always contact our team to discuss custom arrangements.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Is there a free trial on paid plans?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Absolutely. All paid plans come with a 14-day free trial. No credit card required—get full access to explore everything.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Do you offer discounts for annual billing?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes. Pay annually and save 25% on all plans. That's like getting 3 months free.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    Can FitCore integrate with my payment processor?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes. Professional and Enterprise plans support integrations with popular payment processors. Talk to our sales team for custom setup.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php 
include_once('../footer.php')
?>