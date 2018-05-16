@extends('layouts.app')
@section('content')
    <header class="v-header container">
        <div class="fullscreen-video-wrap">
          <img src="/storage/video_jif.gif" alt="" autoplay>
        </div>
        <div class="header-overlay"></div>
        <div class="header-content text-md-center text-center">
            <h1>{{$title}}</h1>
            <p>- University of Moratuwa -</p>
            <p><small>This is an online Inventory Management System</small></p> 
            <a class="btn searchbtn" href="/inventories">Search for an Inventory</a>
        </div>
    </header>
    
      <section class="section section-a">
        <div class="container">
          <h2><strong>Vision</strong></h2>
          <h3>Lead to the efficient and robust Inventory Management System by empowering technology</h3>
          
        </div>
      </section>
    
      <section class="section section-b">
        <div class="container">
          <h2><strong>Mission</strong></h2>
          <p>Provide a web based solution for Inventory Management system of Embeded Lab in University of Moratuwa in order to cater the needs of rapidly changing wants of users.</p>
        </div>
      </section>    
@endsection