@extends('layouts.main')

@section('main-container')
<br>
<section class="sliders">
  <div id="carouselExampleCaptions1" class="carousel slide" data-bs-ride="carousel">
    <div class="container">
      <div class="carousel-inner">
        <div class="row">
          @foreach ($Bannerpojition as $position)
              <div class="col-4 col-md-4">
                  <img src="{{ asset($position->image) }}" class="d-block w-100" alt="{{ $position->name }}">
              </div>
          @endforeach
      </div>
      </div>
      <br>
      <section class="informations">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="heading">
                <h2>Swachh Schools Swachh Sheher</h2>
                <p>Akshar Foundation has partnered with Swachh Bharat Abhiyan and Guwahati Municipal Corporation to launch the Swachh Schools Campaign. Students in government and private schools are segregating plastic waste and bringing it to their school for recycling.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="carousel-inner">
        @foreach($banners as $slider)
        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
          <img src="{{ asset($slider->image) }}" class="d-block w-100" alt="{{ $slider->name }}">
          <div class="carousel-caption d-md-block">
            <h5></h5>
            <p></p>
          </div>
        </div>
        @endforeach
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions1" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions1" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>
</section>
@endsection