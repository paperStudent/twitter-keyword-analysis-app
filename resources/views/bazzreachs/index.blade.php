<!DOCTYPE html>
<html lang="jp" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ツイッター感情分析ツール</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="Themesdesign" />

    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">

    <!--Material Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/materialdesignicons.min.css') }}" />

    <!-- Pe-icon-7 icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pe-icon-7-stroke.css') }}">

    <!-- Custom  Css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />

</head>

<body>
     <!-- START  NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-light" id="navbar">
        <div class="container">
					<div class="my-title-style">niwa dev</div>
        </div>
    </nav>
    <!-- END NAVBAR -->

    <!-- START HOME -->
    <section class="section bg-home home-five align-items-center d-flex" id="home">
        <div class="bg-overlay"></div>
        <div class="container slidero">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="text-center text-white">
                        <h1> 
                            <span href="" class="typewrite" data-period="2000" data-type="[ &quot;こちらはツイッター分析ツールです&quot;,&quot;検索したいワードを入れて下さい&quot;]"><span class="wrap"></span></span>
                        </h1>
                        <div class="home-border my-3 mt-4"></div>
                        <p class="home-subtitle pt-4 mx-auto">キーワードを入れるとランダムに関連するツイートを表示し、感情分析を行います。</p>
                        <div class="search-form mt-5">
                        <form name="search_form" method="POST" action="{{route('bazzreach.search')}}">
                            {{ csrf_field() }}
                            <input type="text" name="search_word" placeholder="キーワードを入力してください" value="{{ old('search_word') }}">
                            <button type="submit" class="btn btn-primary btn-round">検索</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            
            @isset ($totalTweets)
            <form name="create_form" method="POST" action="{{route('bazzreach.store')}}">
                <div class="row mt-5 pt-3">
                    <div class="col-lg-12">
                        <div class="service-box active mt-4">
                            <div class="services-icon">
                                <i class="pe-7s-display2"></i>
                            </div>
                            <div class="mt-3">
                                <h5 class="mb-3 f-17 mt-4">{{$searchWord}}</h5>
                                <p class="text-muted mb-0">{!! nl2br(e($tweetResult)) !!}</p>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary btn-round">検索ツイートを保存する</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                <input type="hidden" name="search_word" value="{{$searchWord}}">
                <input type="hidden" name="total_tweets" value="{{$totalTweets}}">
            </form>
            @endisset
        </div>
    </section>
    <!-- END HOME -->

    <!-- START ANALYSIS -->
    <section class="section  bg-light" id="analysis">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-7">
                    <div class="title-box">
                        <h5 class="sub-title text-primary text-uppercase">Analysis</h5>
                        <div class="search-form mt-5">
                        <form name="bazz_search_form" method="POST" action="{{route('bazzreach.bazzsearch')}}">
                            {{ csrf_field() }}
                            <input type="text" name="keyword" placeholder="キーワード検索で絞り込みができます" value="{{ old('keyword') }}">
                            <button type="submit" class="btn btn-primary btn-round">検索</button>
                        </form>
                        </div>
                        <h5 class="mt-3 fw-normal">
                        検索データ{{sizeof($bazzReachs)}}件が該当しました。
                        </h5>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                        <div class="carousel-inner">

                        @isset ($bazzReachs)
                        @foreach($bazzReachs as $bazzReach)
                            <div class="carousel-item @if($loop->first) active @endif">
                                <div class="client-box">
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="client-img mt-4">
                                                
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="mt-4">
                                                <div class="client-content">
                                                    <div class="client-icon mt-4 pt-2">
                                                        <h5 class="f-17 mt-3 mb-2 text-primary"><i class="mdi mdi-format-quote-close"></i>検索キーワード：{{ $bazzReach->search_word }}</h5>
                                                    </div>
                                                    
                                                    <p class="text-primary mb-0 f-14">{{ $bazzReach->created_at->diffForHumans() }}</p>

                                                    <div class="col-lg-12">
                                                        <div class="price-box mt-4">
                                                            <div class="pricing-badge">
                                                                <span class="badge">BazzReach</span>
                                                            </div>
                                                            <h5 class="f-19 fw-normal line-height_1_6">
                                                            {!! nl2br(e(Str::limit($bazzReach->total_tweets, 300))) !!}
                                                            </h5>
                                                            <div class="mt-5 text-center">
                                                            <form name="destroy_form" action="{{route('bazzreach.destroy',$bazzReach->id)}}" method="POST">
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                @if($loop->count > 1)
                                                                <a href="javascript:destroy_form[{{$loop->index}}].submit()" class="btn btn-primary w-100" onclick="if(confirm('削除してもよろしいですか?')) { return true } else {return false };">削除</a>
                                                                @else
                                                                <a href="javascript:destroy_form.submit()" class="btn btn-primary w-100" onclick="if(confirm('削除してもよろしいですか?')) { return true } else {return false };">削除</a>
                                                                @endif
                                                            </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="accordion faq-box mt-4" id="accordionExample">
                                                
                                                <div class="accordion-item mt-4">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" onclick="getAnalysis('{{ $bazzReach->id }}')">
                                                            <h5 class="mb-0 f-16">詳細分析</h5> <i class="mdi mdi-chevron-down f-20 ms-auto"></i>
                                                        </button>
                                                    </h2>

                                                    @isset ($bazzReach->sentiment)
                                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                        <div class="accordion-body">
                                                            <div class="form-group mt-2">
                                                                <h5>感情分析：{{$bazzReach->sentiment}}</h5>
                                                                
                                                                <div class="table-responsive-sm">
                                                                    <table class="table table-striped table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>感情</th>
                                                                                <th>スコア</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="sentiment-tbody">
                                                                        </tbody>
                                                                    </table>

                                                                    <table class="table table-striped table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>キーフレーズ</th>
                                                                                <th>スコア</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="keyPhrase-tbody">
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                        <div class="accordion-body">
                                                            <div class="form-group mt-2">
                                                            <form name="analysis_form" method="POST" action="{{route('bazzreach.analysis',$bazzReach->id)}}">
                                                                {{ csrf_field() }}
                                                                @if($loop->count > 1)
                                                                <a href="javascript:analysis_form[{{$loop->index}}].submit()" class="btn btn-primary w-100">詳細分析実行</a>
                                                                @else
                                                                <a href="javascript:analysis_form.submit()" class="btn btn-primary w-100">詳細分析実行</a>
                                                                @endif
                                                            </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endisset
                                                </div>

                                                <div class="accordion-item mt-4">
                                                    <h2 class="accordion-header" id="headingTwo">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                            <h5 class="mb-0 f-16">分析メモ入力</h5> <i class="mdi mdi-chevron-down f-20 ms-auto"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                                        <div class="accordion-body">
                                                            <div class="form-group mt-2">
                                                            <form name="edit_form" method="POST" action="{{route('bazzreach.update',$bazzReach->id)}}">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="_method" value="PUT">
                                                                <textarea name="comment" id="comment" rows="3" class="form-control"
                                                                    placeholder="分析結果メモを入力">{{$bazzReach->comment}}</textarea>
                                                                
                                                                @if($loop->count > 1)
                                                                <a href="javascript:edit_form[{{$loop->index}}].submit()" class="btn btn-primary w-100">分析をメモ</a>
                                                                @else
                                                                <a href="javascript:edit_form.submit()" class="btn btn-primary w-100">分析をメモ</a>
                                                                @endif
                                                            </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>



                                        </div>
                                        <div class="col-2">
                                            <div class="client-img mt-4">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @endisset

                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </a>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- END ANALYSIS -->

    <section class="bg-footer">
        <div class="container">


        </div>
    </section>

    <!-- bootstrap -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- JAVASCRIPTS -->
    <script src="{{ asset('js/smooth-scroll.polyfills.min.js') }}"></script>
    <script src="{{ asset('js/gumshoe.polyfills.min.js') }}"></script>
    <!--Partical js-->
    <script src="{{ asset('js/particles.js') }}"></script>
    <script src="{{ asset('js/particles.app.js') }}"></script>
    <!-- CUSTOM JS -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer="defer"></script>
</body>

</html>