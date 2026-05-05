 <style>
    span.error p {
        color: #fff;
        background: red;
        text-align: justify;
    }
    .success-message {
        background: green;
        padding: 10px;
        color: #fff;
        font-weight: 600;
    }
 </style>
 <!----Contact---->
 <section class="location">

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3674.85474209423!2d88.45192560104988!3d22.91872799059877!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f8953f5687cc93%3A0x9eddd2be9a5122ed!2sGyanjyoti%20Public%20School!5e0!3m2!1sen!2sin!4v1730960595705!5m2!1sen!2sin"width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </section>

    <section class="contact-us">
        <h2>Contact Us</h2>
        <p>If you have any questions or need further information about our school, feel free to reach out to us.</p>
        <div class="row">
            <div class="contact-col">
                <div>
                    <i class="fas fa-map-marker-alt"></i>
                    <span>
                        <h3>Address</h3>
                        <p>Vill - Chandua, P.O. - Kanchrapara, Beside Kalyani-Barrackpore Expressway, North 24 Parganas,PIN - 743145, West Bengal</p>
                    </span>
                </div>

                <div>
                    <i class="fas fa-phone"></i>
                    <span>
                        <h3>Phone</h3>
                        <p>9073112222</p>
                    </span>
                </div>

                <div>
                    <i class="fas fa-envelope"></i>
                    <span>
                        <h3>Email</h3>
                        <p>gpskanchrapara@gmail.com</p>
                    </span>
                </div>
            </div>

            <div class="contact-col">

              <!-- contact_form.php -->

<div class="contact-box">
<?php if ($this->session->flashdata('success')): ?>
    <div class="success-message">
        <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>
    <h3>Leave us a message</h3>
    <?= form_open('page/submit_message', ['class' => 'contact-form']); ?>
        <input type="text" name="name" placeholder="Enter Your Name" value="<?= set_value('name'); ?>">
        <span class="error"><?= form_error('name'); ?></span>

        <input type="email" name="email" placeholder="Enter Your Email" value="<?= set_value('email'); ?>">
        <span class="error"><?= form_error('email'); ?></span>

        <textarea rows="5" name="message" placeholder="Write a message..."><?= set_value('message'); ?></textarea>
        <span class="error"><?= form_error('message'); ?></span>

        <button type="submit" class="hero-btn-red">SUBMIT</button>
    <?= form_close(); ?>
</div>


            </div>
        </div>
    </section>
