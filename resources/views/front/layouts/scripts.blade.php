 <!-- jquery -->
 <script src="{{ asset('front/coreui/js/jquery.min.js') }}"></script>
 <script src="{{ asset('front/coreui/js/jquery.countdown.min.js') }}"></script>

 <script src="{{ asset('front/coreui/js/popper.js') }}"></script>
  <!-- bootstrap -->
  <script src="{{ asset('front/coreui/js/bootstrap.min.js') }}"></script>
  <!-- slick -->
  <script src="{{ asset('front/coreui/js/slick.min.js') }}"></script>
  <!-- parallax js -->
 <script src="{{ asset('front/coreui/js/parallax.min.js') }}"></script>
  <!-- javaScript -->
  <script src="{{ asset('front/coreui/js/main.js') }}"></script>

<script src="{{asset('front/toastr/toastr.min.js')}}"></script>
<script src="{{asset('front/coreui/js/scripts.js')}}"></script>

<script src="{{asset('front/coreui/js/owl-carousel.js')}}"></script>

<script>
  $('#owl-about').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    autoplay: true,
    //  autoplayTimeout: 3000
    responsive:{
    0:{
    items:1,
    nav:false
    },
    600:{
    items:2,
    nav:false
    },
    1000:{
    items:3,
    nav:false,

    }
    }
    })
</script>

<script>
  $('#owl-speakers').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    autoplay: true,
    //  autoplayTimeout: 3000
    responsive:{
    0:{
    items:1,
    nav:false
    },
    600:{
    items:2,
    nav:false
    },
    1000:{
    items:3,
    nav:false,

    }
    }
    })
</script>
<script>
  $('#owl-speakers-main').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    autoplay: true,
    //  autoplayTimeout: 3000
    responsive:{
    0:{
    items:1,
    nav:false
    },
    600:{
    items:2,
    nav:false
    },
    1000:{
    items:3,
    nav:false,

    }
    }
    })
</script>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.collapse');
    cards.forEach(card => {
      card.addEventListener('show.bs.collapse', function () {
        toggleContent(card, true);
      });

      card.addEventListener('hide.bs.collapse', function () {
        toggleContent(card, false);
      });
    });

    function toggleContent(card, isShow) {
      const toggleButton = card.previousElementSibling.querySelector('a');
      if (isShow) {
        toggleButton.textContent = 'See Less';
      } else {
        toggleButton.textContent = 'See More';
      }
    }
  });
</script>