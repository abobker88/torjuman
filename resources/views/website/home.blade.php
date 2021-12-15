

@extends('layouts.website')

@section('content')
<main class="">
    <section class="hero container">
      <div class="hero-image">
        <img loading="lazy"src="{{asset('storage/img/assets/hero.png')}}" alt="hero" class="hero-image" />
      </div>
      <div class="hero-text-content">
        <h1 class="hero-title">Many Solution with</h1>
        <p class="hero-para">
          Upload anything, monitor real‑time Get it translated
        </p>
        <div class="hero-btn-holder">
          <a href="#" class="hero-btn">Get a free Quote</a>
        </div>
      </div>
    </section>
    <section class="about" id="about">
      <div class="container">
        <h2 class="about-title">About Us</h2>

        <div class="about-div">
          <div class="about-image-holder">
            <img loading="lazy"src="{{asset('storage/img/assets/about.png')}}" alt="about" class="about-image" />
          </div>
          <div class="about-title-para">
            <h3 class="about-heading">WHAT IS TURJOMAN?</h3>
            <p class="about-para">
              Turjoman is the worldʼs fastest, lowest cost, cloud-based,
              collaborative business translation platform
            </p>
            <h3 class="about-heading">HOW DOES TURJOMAN WORK?</h3>
            <p class="about-para">
              Turjoman combines the efforts of talented human translators
              through the use of a cloud based translation platform. Our
              translators are able to login simultaneously into projects that
              fit their language combination and provide translation service
              collaboratively - while also seeing the whole content for
              contextual purposes. This ability to simultaneously utilize
              multiple translators makes Turjoman exceptionally fast and
              highly accurate.
            </p>
          </div>
        </div>
        <div class="second-about-div">
          <div class="about-title-para">
            <h3 class="about-heading">WHAT IS UNIQUE ABOUT TURJOMAN?</h3>
            <p class="about-para">
              A new and powerful approach known as collaborative translation:
              multiple translators with varying tasks collaborate
              simultaneously through a shared workspace and resources via
              cloud computing. Collaborative translation reduces the total
              time of the translation lifecycle, improves communications
              (particularly between translator and non-translator
              participants), and eliminates many management tasks.
            </p>
          </div>

          <div class="about-title-para">
            <h3 class="about-heading">WHO IS BEHIND TURJOMAN?</h3>
            <p class="about-para">
              A leading translation agency with 17 years of experience, expert
              developers and passionate designers brought Turjoman to life.
              Turjoman is a simple, seamless and reliable source for
              translation service. Our aim is to delight our clients, who
              order, inspect, and access high-quality and budget friendly
              human translation services worldwide using the collaboration of
              multiple expert translators.
            </p>
            <p class="spaced-text about-para">
              Turjoman is designed and developed at our corporate office,
              located in Kingdom of Saudi Arabia.
            </p>
          </div>
        </div>
      </div>
    </section>
    <section class="services container" id="services">
      <div class="section-title">
        <h2 class="section-heading">Services</h2>
      </div>
      <div class="service-boxes">
        <div class="service-box">
          <img loading="lazy"src="{{asset('storage/img/assets/services1.svg')}}" alt="" class="service-svg" />
          <h4 class="service-title">one sheet</h4>
        </div>
        <div class="service-box">
          <img loading="lazy"src="{{asset('storage/img/assets/services2.svg')}}" alt="" class="service-svg" />
          <h4 class="service-title">10 sheets or less</h4>
        </div>
        <div class="service-box">
          <img loading="lazy"src="{{asset('storage/img/assets/services3.svg')}}" alt="" class="service-svg" />
          <h4 class="service-title">Simultaneous translation</h4>
        </div>
        <div class="service-box">
          <img loading="lazy"src="{{asset('storage/img/assets/services4.svg')}}" alt="" class="service-svg" />
          <h4 class="service-title">research and books</h4>
        </div>
      
        <div class="service-box">
          <img loading="lazy"src="{{asset('storage/img/assets/services5.svg')}}" alt="" class="service-svg" />
          <h4 class="service-title">Request an interpreter</h4>
        </div>
        <div class="service-box">
          <img loading="lazy"src="{{asset('storage/img/assets/services6.svg')}}" alt="" class="service-svg" />
          <h4 class="service-title">Companies and Institutions</h4>
        </div>
        <div class="service-box">
          <img loading="lazy"src="{{asset('storage/img/assets/services7.svg')}}" alt="" class="service-svg" />
          <h4 class="service-title">Drafting letters</h4>
        </div>
        <div class="service-box">
          <img loading="lazy"src="{{asset('storage/img/assets/services8.svg')}}" alt="" class="service-svg" />
          <h4 class="service-title">Free trial</h4>
        </div>
      </div>
    </section>

    <section class="features" id="features">
      <div class="container feature-container">
        <div class="features-content">
          <div class="para-cta">
            <h2 class="feature-title">Features</h2>
            <p class="features-para">
              At Turjoman we are hard at work in building the world’s fastest,
              professional translation platform. In doing so we use, invent,
              and better technologies. You may browse through all our features
              and how we make Turjoman the best translation solution in the
              market.
            </p>

            <div class="feature-cta">
              <a href="#" class="feature-btn"> Get a free Quote </a>
            </div>
          </div>
          <div class="feature-img">
            <img
              src="{{asset('storage/img/assets/features.png')}}"
              alt="features"
              class="feature-img"
            />
          </div>
        </div>
      </div>
    </section>

    <section class="everything-included container">
      <div class="everything-section-title">
        <h2>Everything Included</h2>
      </div>
      <div class="included-box included-box-first">
        <div class="included-text-content">
          <h4 class="included-title">
            File Formats
          </h4>
          <p class="included-para">
            Turjoman supports many file formats and makes the integration and the use of your translated content easier, saving you valuable time and resources.</p>          
        </div>
        <div class="included-image-holder">
          <img loading="lazy"src=" {{asset('storage/img/assets/file-formats.png')}}" alt="file formats" class="included-image" />
        </div>
      </div>

      <div class="included-box included-box-center">
        <div class="included-image-holder">
          <img loading="lazy"src=" {{asset('storage/img/assets/certified-translation.png')}}" alt="Certified Translation" class="included-image" />
        </div>
        <div class="included-text-content">
          <h4 class="included-title">
            Certified Translation
          </h4>
          <p class="included-para">
            We are one of the leading translation providers and can deliver your certified translations within hours, rather than days.</p>          
        </div>
        
      </div>

      <div class="included-box included-box-last">
        <div class="included-text-content">
          <h4 class="included-title">
            Companies and Institutions
          </h4>
          <p class="included-para">
            We are one of the leading translation providers and can deliver your certified translations within hours, rather than days.</p>          
        </div>
        <div class="included-image-holder">
          <img loading="lazy"src="{{asset('storage/img/assets/companies-institutions.png')}}"
      </div>

      </div>
    </section>
  </main>
  @endsection