<?php
include_once('../header.php');
?>
<link rel="stylesheet" href="styles/userSub.css">
    <!-- Pricing Section -->
    <section class="pricing" id="pricing">
      <div class="container-lg">
        <h2 class="section-title">
          Affordable <span class="highlight">Pricing</span> Plans
        </h2>
        <div class="row g-4">
          <div class="col-md-6 col-lg-4">
            <div class="pricing-card">
              <h3>Starter</h3>
              <div class="price">$29</div>
              <div class="price-period">per month</div>
              <ul class="list-unstyled features-list">
                <li>Gym access during business hours</li>
                <li>Basic equipment access</li>
                <li>Mobile app included</li>
                <li>1 fitness assessment</li>
              </ul>
              <button class="btn-primary-custom w-100">Choose Plan</button>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="pricing-card featured">
              <span class="pricing-badge">Most Popular</span>
              <h3>Premium</h3>
              <div class="price">$59</div>
              <div class="price-period">per month</div>
              <ul class="list-unstyled features-list">
                <li>24/7 gym access</li>
                <li>All classes included</li>
                <li>Personal trainer sessions</li>
                <li>Nutrition guidance</li>
                <li>Priority support</li>
              </ul>
              <button class="btn-primary-custom w-100">Choose Plan</button>
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="pricing-card">
              <h3>Elite</h3>
              <div class="price">$99</div>
              <div class="price-period">per month</div>
              <ul class="list-unstyled features-list">
                <li>Everything in Premium</li>
                <li>Dedicated personal trainer</li>
                <li>Custom meal planning</li>
                <li>Recovery services</li>
                <li>VIP lounge access</li>
              </ul>
              <button class="btn-primary-custom w-100">Choose Plan</button>
            </div>
          </div>
        </div>
      </div>
    </section>
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
                            <td><strong>Gym Access</strong></td>
                            <td>Business Hours</td>
                            <td>24/7 Access</td>
                            <td>24/7 Access</td>
                        </tr>

                        <tr>
                            <td><strong>Equipment Access</strong></td>
                            <td><span class="check-icon">✓</span> Basic</td>
                            <td><span class="check-icon">✓</span> Full Access</td>
                            <td><span class="check-icon">✓</span> Full Access</td>
                        </tr>

                        <tr>
                            <td><strong>Mobile App</strong></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>

                        <tr>
                            <td><strong>Fitness Assessment</strong></td>
                            <td>1 Assessment</td>
                            <td>Regular Assessments</td>
                            <td>Advanced Assessments</td>
                        </tr>

                        <tr>
                            <td><strong>Group Classes</strong></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="check-icon">✓</span> All Classes</td>
                            <td><span class="check-icon">✓</span> All Classes</td>
                        </tr>

                        <tr>
                            <td><strong>Personal Trainer</strong></td>
                            <td><span class="close-icon">✗</span></td>
                            <td>Trainer Sessions</td>
                            <td>Dedicated Trainer</td>
                        </tr>

                        <tr>
                            <td><strong>Nutrition Guidance</strong></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="check-icon">✓</span></td>
                            <td><span class="check-icon">✓</span> Custom Plan</td>
                        </tr>

                        <tr>
                            <td><strong>Custom Meal Planning</strong></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>

                        <tr>
                            <td><strong>Recovery Services</strong></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>

                        <tr>
                            <td><strong>VIP Lounge Access</strong></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="close-icon">✗</span></td>
                            <td><span class="check-icon">✓</span></td>
                        </tr>

                        <tr>
                            <td><strong>Customer Support</strong></td>
                            <td>Standard</td>
                            <td>Priority Support</td>
                            <td>VIP Support</td>
                        </tr>

                        <tr>
                            <td><strong>Monthly Price</strong></td>
                            <td>$29 / month</td>
                            <td>$59 / month</td>
                            <td>$99 / month</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

<?php 
include_once ('../footer.php');
?>