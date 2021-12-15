@include('inc.header')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   
<body>
    

    <header class="menu-bar">
        <div class="container header-container">
          <div class="logo-holder">
            <div class="logo">
              <a href="{{ Route('website.home') }}">
              <img loading="lazy"src="{{asset('storage/img/assets/logo.png')}}" alt="logo" class="logo-img" />
              </a>
            </div>
          </div>
          <button class="mobile-menu-toggle" aria-controls="primary-navigation" aria-hidden="true" aria-expanded="false">
            <span class="sr-only">
            </span>
          </button>
          <nav>
            <ul class="primary-navigation" data-visible="false"> 
              <li class="nav-link">
                <a href="#about" id="nav-item"> {{ __('models/translator.about_us') }}</a>
              </li>
              <li class="nav-link">
                <a href="#services" id="nav-item">{{ __('models/translator.services') }}</a>
              </li>
              <li class="nav-link">
                <a href="#features" id="nav-item">  {{ __('models/translator.Features') }}    </a>
              </li>
              <li class="nav-link">
                <a href="{{ Route('website.login') }}" id="nav-item">   {{ __('models/translator.Sign_in') }}    </a>
              </li>
              <li class="nav-link">
                @if(Session::get('locale') == 'en' || Session::get('locale') == null)
                <a href="{{url('setlocale/ar')}}"id="nav-item">العربية </a>
                @else 
                <a href="{{url('setlocale/en')}}" id="nav-item">English </a>
                @endif
              </li>
            </ul>
          </nav>
        </div>
      </header>
 
    
  
            @yield('content')

          
      

    @include('inc.footer_web')
    @yield('page_scripts')


</body>
</html>
