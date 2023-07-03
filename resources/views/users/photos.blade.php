@extends('layouts.userApp', ['class' => 'login-page', 'page' => __('Photo View Page'), 'contentClass' => 'login-page'])

@section('content')
<head>
    <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        .wrapper > ul#results li {
        margin-bottom: 2px;
        /* background: #e2e2e2; */
        padding: 20px;     
        list-style: none;
        }
        .ajax-loading{
        text-align: center;
        }
    </style>
</head>
<body>
    <div class="card-header">
        <h4 class="card-title">写真のパラダイス</h4>
    </div>
    <div style="padding-top:60px;">
        <div class="d-flex flex-row-reverse bd-highlight">
            <a class="btn btn-info mt-2" target="_blank" href="contactForm.php"><i class="fa fa-envelope" aria-hidden="true"></i> お問い合わせ</a>
        </div>
        <form method="GET" action="{{ route('users.search') }}">
        @csrf
            <div>
                <input type="text" name="searchitem" class="col-md-6" placeholder="タイトルで検索" value="{{ request('searchitem', '') }}">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fab fa-sistrix fa-lg"></i></button>
            </div>
        </form> 
    </div>
    <div class="container my-5">
        <div class="row row-cols-1 row-cols-md-2 g-4">
                <div id="results" class="row">
                    
                </div>
                <div class="ajax-loading col-md-12">
                    <img src="{{ asset('black') }}/img/Spinner-2.gif" />
                </div>
        </div>
    </div>
</body>
<script>
   var site_url = "{{ url('/') }}";   
   var page = 1;
   
   load_more(page);

   $(window).scroll(function() {
      if($(window).scrollTop() + $(window).height() >= $(document).height()) {
      page++;
      load_more(page);
      }
    });

    function load_more(page){
        $.ajax({
          url: site_url + "/?page=" + page,
          type: "get",
          datatype: "html",
          beforeSend: function()
          {
            $('.ajax-loading').show();
          }
        })
        .done(function(data)
        {          
          if(data.length == 0){
          $('.ajax-loading').html("これ以上のレコードはありません!");
          return;
        }
          $('.ajax-loading').hide();
          $("#results").append(data);
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
          alert('No response from server');
        });
    }
</script>

@endsection
@section('script')

@endsection