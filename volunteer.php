<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="volunteer-designed/styles.css">

<hr class="top" id="top">

<section class="volunteer">
    <div class="img-container">
        <img src="volunteer-designed/volpic1.png" alt="Volunteer Img Banner">
    </div>

    <div class="volheader">
        <h1>Become a Volunteer!</h1>
        <p>
            We hope to create a sense of community to a more wide-reaching 
            bound by encouraging more individuals and organizations who share 
            the same passion with us to increase our capability to provide help 
            to more animals who are in need. Join us in making a difference in 
            the lives of animals who are in need.
        </p>
        <button onclick="window.location.href='volunteer_application.php'">Volunteer Application</button>
    </div>

    <div class="volpro">
        <h1>Volunteer Process</h1>
        <h2>Step-By-Step Foster Care Process</h2>
        <ol>1. Click the Volunteer Application Button above. You will be redirected to the form. </ol>
        <ol>2. Provide the required information needed by the volunteer application form. Your skillset will be asked in order for us to see if you are qualified to foster care.</ol>
        <ol>3. Once the admin of the page approves your application you will be able to view your Volunteer Dashboard.</ol>
        <ol>4. Enjoy the privileges of being a volunteer by having the chance to foster care our shelter animals.</ol>
    </div>

    <section class="volstories">
        <h2>Volunteer Stories</h2>
        <div class="slideshow">
            <img class="arrow arrowback" src="volunteer-designed/arrowback.png" alt="Previous" onclick="prevSlide()">
            <input type="radio" name="slide" id="slide1" checked>
            <div class="slide">
                <img src="volunteer-designed/volevent1.jpg" alt="Volunteer Testimony 1">
            </div>
            <input type="radio" name="slide" id="slide2">
            <div class="slide">
                <img src="volunteer-designed/volevent2.jpg" alt="Volunteer Testimony 2">
            </div>
            <input type="radio" name="slide" id="slide3">
            <div class="slide">
                <img src="volunteer-designed/volevent3.jpg" alt="Volunteer Testimony 3">
            </div>
            <img class="arrow arrownext" src="volunteer-designed/arrownext.png" alt="Next" onclick="nextSlide()">
            <div class="navigation">
                <label for="slide1"></label>
                <label for="slide2"></label>
                <label for="slide3"></label>
            </div>
        </div>
    </section>
</section>

<script src="volunteer-designed/slides.js"></script>

<hr class="bottom" id="bottom">

<?php include 'includes/footer.php'; ?>
