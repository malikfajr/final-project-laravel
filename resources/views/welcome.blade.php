@extends('layouts.hometemplate')

@section('content')

<header class="masthead" style="background-image: url('{{asset('img/home-bg.jpg')}}')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>Forum Indonesia</h1>
            <span class="subheading">Forum untuk membantu menyelesaikan masalahmu</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        @foreach($questions as $key => $question)
        <div class="post-preview">
        <a href="/question/{{$question->id}}">
            <h2 class="post-title">
            {{$question->title}}
            </h2>
            <h3 class="post-subtitle">
            {{$question->content}}
            </h3>
          </a>
          <p class="post-meta">ask by
          <a href="#">{{$question->user_id}}</a>
            on {{$question->created_at}}</p>
            <div class="tag">
                <?php
                  $links = array();
                  $parts = explode(',', $question->tag);
                 // var_dump($parts);
                  foreach ($parts as $tags)
                  {
                   $links[] = "<a href='/tags/$tags' class='btn btn-primary'>".$tags." </a>";
                  }
                  $tagged =  implode(" ", $links);
                  echo $tagged;
                ?>
               
            </div>
            <div class="px-4 pt-3">
                <a href="#" class="bg-primary btn btn-primary text-light">
                  <i class="far fa-thumbs-up"></i>
                </a>
                <span>192</span>
                <a href="#" class="bg-secondary btn btn-normal text-light">
                  <i class="far fa-thumbs-down"></i>
                </a>
              </div>
        </div>
        <hr>
      @endforeach
       
        <!-- Pager -->
        
      </div>
    </div>
  </div>
@endsection