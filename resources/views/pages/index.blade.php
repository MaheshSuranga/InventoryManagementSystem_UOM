@extends('layouts.app')
@section('content')
    <header class="v-header container">
        <div class="fullscreen-video-wrap">
            <video src="/storage/video.mov" autoplay='true' loop='true'></video>
        </div>
        <div class="header-overlay"></div>
        <div class="header-content text-md-center text-center">
            <h1>{{$title}}</h1>
            <p>This is an online Inventory Management System</p> 
          <a class="btn" href="/inventories">Search for an Inventory</a>
        </div>
    </header>
    
      <section class="section section-a">
        <div class="container">
          <h2>Section A</h2>
          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde, impedit amet minima iste autem cumque et maiores blanditiis doloribus aut dolorum quaerat non est voluptatum, tempore ut dolorem voluptas quod quae accusantium, ex inventore ducimus. Beatae mollitia exercitationem, quam similique, consectetur ratione reprehenderit delectus neque eligendi facere soluta dolor ducimus!</p>
        </div>
      </section>
    
      <section class="section section-b">
        <div class="container">
          <h2>Section B</h2>
          <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde, impedit amet minima iste autem cumque et maiores blanditiis doloribus aut dolorum quaerat non est voluptatum, tempore ut dolorem voluptas quod quae accusantium, ex inventore ducimus. Beatae mollitia exercitationem, quam similique, consectetur ratione reprehenderit delectus neque eligendi facere soluta dolor ducimus!</p>
        </div>
      </section>    
@endsection