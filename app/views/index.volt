<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{metadata['title']}}</title>
    <meta name="description" content="{{metadata['desc']}}" /> 
    
    {% if metadata['keywords'] is defined %}
        <meta name="keywords" content="{{metadata['keywords']}}" /> 
    {% endif %}

    <meta name="author" content="OddsLog.com" />
    <meta name="copyright" content="(c) OddsLog.com 2020 - 2024" />
    <meta name="generator" content="phalcon.io"> 

    {% if metadata['canonical'] is defined %}
        <link rel="canonical" href="https://oddslog.com{{metadata['canonical']}}" />
    {% endif %}



    <link rel="shortcut icon" href="/favicon.ico">
    <link href="/static/bootstrap-5.3.3/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/static/css/main.css" />
    <link rel="stylesheet" type="text/css" href="/static/css/icons.css" /> 
   
    {% if assets.exists('header') %}
        {{ assets.outputJs('header') }} 
    {% endif %}
    
</head>


<body class="bg-main" >

    <header class="bg-header">
        <nav class="navbar navbar-expand-md p-2">

            <div class="container">


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>

                <a class="navbar-brand fw-bold" href="/">
                    <img src="/static/img/logo.png" alt="OddsLog.com"> ODDSLOG
                </a>

    
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto ms-md-3 mb-md-0">
                        <li class="nav-item">

                            <a class="btn bg-900 mx-2 rounded " href="/">
                                <svg viewBox="0 0 16 16" id="soccer" style="width: 18px;vertical-align: sub;"><g fill="none" fill-rule="evenodd"><path d="M0 0h16v16H0z"></path><path fill="#fff" d="M8 .78a7.22 7.22 0 100 14.44A7.22 7.22 0 008 .78zm1.049 9.002H6.855a.26.26 0 01-.247-.183l-.62-2.005a.26.26 0 01.094-.284l1.762-1.306a.259.259 0 01.309 0l1.756 1.301a.26.26 0 01.09.294l-.706 2.01a.259.259 0 01-.244.173zM1.755 7.705a6.213 6.213 0 01.982-3.081l1.417.255a.26.26 0 01.21.264l-.06 1.585a.26.26 0 01-.052.146L3.3 8.144a.26.26 0 01-.306.084zm9.981-2.813l1.538-.25c.576.902.925 1.959.972 3.094l-1.351.505a.259.259 0 01-.305-.085l-.954-1.27a.26.26 0 01-.051-.146l-.06-1.584a.259.259 0 01.211-.264zm-2.05-2.914l.093 1.286a.259.259 0 01-.17.267l-1.488.532a.26.26 0 01-.157.006L6.45 3.643a.259.259 0 01-.187-.28l.118-1.403A6.228 6.228 0 018 1.74c.585 0 1.149.087 1.686.238zM3.02 11.775l.695-1.075a.259.259 0 01.299-.114l1.511.473c.051.015.095.046.128.088l1.046 1.35a.12.12 0 01-.009.155l-1.103 1.122a6.287 6.287 0 01-2.567-2zm7.28 2.042L9.283 12.74a.259.259 0 01-.018-.339l.972-1.255a.259.259 0 01.127-.088l1.48-.471a.259.259 0 01.3.11l.782 1.152a6.282 6.282 0 01-2.627 1.968z"></path></g></svg>                                Football</a>
                        </li>

                        <li class="nav-item">
                            <a class="btn bg-900  mx-2 rounded" href="/live">
                            🔥 Live <span class="badge bg-danger ms-1">{{TotalLive}}</span></a>
                        </li>

                    </ul>

                    <div class="d-flex search-container">
                        <div class="" data-bs-theme="dark">
                            <input autocomplete="false" class="form-control border-1  is-valid" id="search" placeholder="Search match..." aria-label="Search">
                            <ul id="autocomplate" class="list-group small shadow"></ul>
                        </div>
                    </div>

                    {# <div class="">
                        <a href="https://www.producthunt.com/posts/oddslogs?utm_source=badge-featured&utm_medium=badge&utm_souce=badge-oddslogs" rel="nofollow" target="_blank"><img src="https://api.producthunt.com/widgets/embed-image/v1/featured.svg?post_id=316072&theme=light" alt="OddsLogs - Detailed statistics and odds by minute for soccer matches | Product Hunt" style="zoom:.75;opacity:.7" width="250"
                                height="54" /></a>
                    </div> #}
                </div>
            </div>
        </nav>
    </header>


    <main id="main" class="container mt-3 ">

        {{ content() }}

    </main>


    <div class="prefooter">
        <div class="container pt-3 mb-3 small">
        </div>
    </div>


    <footer class="bg-900">
        <div class="container  pt-3 mb-3">
            <div class="row row-gap-3">
                <div class="col-md-3">
                    © 2024 · OddsLog.com <sup>v1.0924</sup>
                </div>
                <div class="col-md-6">
                    <div class=""> 
                        
                        <img width="18" height="18" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAMAAAC6V+0/AAAAUVBMVEVHcEyrq6urq6urq6uvr6+rq6usrKysrKysrKyrq6urq6uqqqqrq6urq6urq6uqqqqrq6urq6usrKyqqqqvr6+rq6urq6usrKyrq6usrKysrKxc/ncKAAAAGnRSTlMAkNDwIEBQYKCA4LCfz8Aw319/cBCP77+vbwspLR4AAACuSURBVBgZBcEHgoMwEAQwATZrQ3pybf7/0JMAdbkm18sTAPsj56yaZx47wJLRgDbyBSxbAVDbAnsKACo7jgEAjAeVBgC0lHHi/lGvBrgN69S+0t/b+f3RO+ZVSpvp7+vf9jEnKlJI79ttlSS8Y51IH7/3dHNirsaJ2/2+bgu94zZUGgDQUhwDABgH9hQAVHZYvguAygIsuTSgXbIA7Ed+Xs/n6yfHDoAaa7KOHfgH90EIjLBjfqwAAAAASUVORK5CYII="
                            class="me-1">
                        <span class="text-muted small">All Rights Reserved. Odds promotions are 18+. Read more on BeGambleAware.org</span></div>


                </div>


                <div class="col-md-3 text-md-end">
                    <div class="mt-2 mt-md-0">
                        <a class="me-4 fw-bolder" target=_blank href="https://t.me/nukexl">❤️ Contact</a>
                    </div>
                </div>

            </div>
        </div>
    </footer>


    <div class="splash"></div>
    <div id="up"><span class="ico-scroll share-ico"></span></div>

    {{ assets.outputJs('footer') }}






    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-NZRWKS05T4"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-NZRWKS05T4');
    </script>

    <img id="licntDEA4" style="border:0; display:none" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAEALAAAAAABAAEAAAIBTAA7" />
    <script>
        (function(d, s) {
            d.getElementById("licntDEA4").src = "https://counter.yadro.ru/hit?t50.6;r" + escape(d.referrer) + ((typeof(s) == "undefined") ? "" : ";s" + s.width + "*" + s.height + "*" + (s.colorDepth ? s.colorDepth : s.pixelDepth)) + ";u" + escape(d.URL) + ";h" + escape(d.title.substring(0, 150)) + ";" + Math.random()
        })(document, screen)
    </script>


    <div class="popover p-3"></div>

    <script id="stat-popover" type="template">
        <div class="mb-2">
            <div class="d-flex flex-wrap justify-content-center">
                <div class="small">##title##</div>
            </div>
            <div class="progress progress-sm">

                <div class="progress-bar bg-primary" role="progressbar" style="width: ##percent0##%" data-bs-toggle="tooltip" title="##percent0##">##val0##</div>

                <div class="progress-bar " role="progressbar" style="width: 1%;"></div>

                <div class="progress-bar bg-success " role="progressbar" style="width: ##percent1##%" data-bs-toggle="tooltip" title="##percent1##">##val1##</div>
            </div>
        </div>
    </script>

</body>

</html>