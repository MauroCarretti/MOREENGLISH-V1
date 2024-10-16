# EduBlink Core Sample Plugin

This is a sample plugin to demonstrate how you can write extentions (plugins) to add custom functionality to [Elementor](https://github.com/pojome/elementor/)

Plugin Structure: 
```
assets/
      /js   Holds plugin JS Files
      /css  Holds plugin CSS Files
      /images  Holds plugin Image Files
      /lotties  Holds plugin Lottie Files
      
widgets/
      /animated-text.php
      /animation.php
      /button.php
      /contact-form-7.php
      /countdown.php
      /counter-up.php
      /course-categories-1.php
      /course-categories-2.php
      /course-categories-3.php
      /course-search.php
      /courses.php
      /events-1.php
      /events-2.php
      /events-3.php
      /featured-event.php
      /icon-box.php
      /image-carousel.php
      /image-icon-box-1.php
      /image-icon-box-2.php
      /ld-courses.php
      /login-register.php
      /lp-course-categories-1.php
      /lp-course-categories-2.php
      /lp-course-categories-3.php
      /lp-lms-statistics.php
      /lp-team-1.php
      /lp-team-2.php
      /lp-team-3.php
      /mailchimp.php
      /nav-menu.php
      /post-1.php
      /post-slider.php
      /pricing-table.php
      /scroll-to-top.php
      /search-form.php
      /section-title.php
      /services-1.php
      /services-2.php
      /services-3.php
      /services-4.php
      /site-logo.php
      /social-icons.php
      /tabs.php
      /team-1.php
      /team-2.php
      /team-3.php
      /testimonial-carousel-1.php
      /testimonial-carousel-2.php
      /testimonial-carousel-3.php
      /testimonial-carousel-4.php
      /timeline.php
      /tl-course-categories-1.php
      /tl-course-categories-2.php
      /tl-course-categories-3.php
      /tl-courses.php
      /tl-featured-course.php
      /tl-lms-statistics.php
      /tl-team-1.php
      /tl-team-2.php
      /tl-team-3.php
      /video-popup.php
      /woo-mini-cart.php
      /woo-products.php
      
index.php
edublink-core.php
plugin.php
```


* `assets` directory - holds plugin CSS, JavaScript, Images and Lottie assets
  * `/js` directory - Holds plugin Javascript Files
  * `/css` directory - Holds plugin CSS Files
* `widgets` directory - Holds Plugin widgets
  * `/section-title.php` - Section Title demo Widget class
  * `/inline-editing.php` - Inline Editing demo Widget class
* `index.php`	- Prevent direct access to directories
* `edublink-core.php`	- Main plugin file, used as a loader if plugin minimum requirements are met.
* `plugin.php` - The actual Plugin file/Class.

For more documentation please see [Elementor Developers Resource](https://developers.elementor.com/creating-an-extension-for-elementor/).
