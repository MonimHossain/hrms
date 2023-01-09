<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <link href="{{ asset('assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    button,
input {
    font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
}

a {
    color: #f96332;
}

a:hover,
a:focus {
    color: #f96332;
}

p {
    line-height: 1.61em;
    font-weight: 300;
    font-size: 1.2em;
}

.category {
    text-transform: capitalize;
    font-weight: 700;
    color: #9A9A9A;
}

body {
    color: #2c2c2c;
    font-size: 14px;
    font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
    overflow-x: hidden;
    -moz-osx-font-smoothing: grayscale;
    -webkit-font-smoothing: antialiased;
    /* background-color: purple; */
}

.nav-item .nav-link,
.nav-tabs .nav-link {
    -webkit-transition: all 300ms ease 0s;
    -moz-transition: all 300ms ease 0s;
    -o-transition: all 300ms ease 0s;
    -ms-transition: all 300ms ease 0s;
    transition: all 300ms ease 0s;
}

.card a {
    -webkit-transition: all 150ms ease 0s;
    -moz-transition: all 150ms ease 0s;
    -o-transition: all 150ms ease 0s;
    -ms-transition: all 150ms ease 0s;
    transition: all 150ms ease 0s;
}

[data-toggle="collapse"][data-parent="#accordion"] i {
    -webkit-transition: transform 150ms ease 0s;
    -moz-transition: transform 150ms ease 0s;
    -o-transition: transform 150ms ease 0s;
    -ms-transition: all 150ms ease 0s;
    transition: transform 150ms ease 0s;
}

[data-toggle="collapse"][data-parent="#accordion"][aria-expanded="true"] i {
    filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
    -webkit-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    transform: rotate(180deg);
}


.now-ui-icons {
    display: inline-block;
    font: normal normal normal 14px/1 'Nucleo Outline';
    font-size: inherit;
    speak: none;
    text-transform: none;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

@-webkit-keyframes nc-icon-spin {
    0% {
        -webkit-transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
    }
}

@-moz-keyframes nc-icon-spin {
    0% {
        -moz-transform: rotate(0deg);
    }

    100% {
        -moz-transform: rotate(360deg);
    }
}

@keyframes nc-icon-spin {
    0% {
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    }

    100% {
        -webkit-transform: rotate(360deg);
        -moz-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        -o-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

.now-ui-icons.objects_umbrella-13:before {
    content: "\ea5f";
}

.now-ui-icons.shopping_cart-simple:before {
    content: "\ea1d";
}

.now-ui-icons.shopping_shop:before {
    content: "\ea50";
}

.now-ui-icons.ui-2_settings-90:before {
    content: "\ea4b";
}

.nav-tabs {
    border: 0;
    padding: 15px 0.7rem;
}

.nav-tabs:not(.nav-tabs-neutral)>.nav-item>.nav-link.active {
    box-shadow: 0px 5px 35px 0px rgba(0, 0, 0, 0.3);
}

.card .nav-tabs {
    border-top-right-radius: 0.1875rem;
    border-top-left-radius: 0.1875rem;
}

.nav-tabs>.nav-item>.nav-link {
    color: #3f51b5;
    margin: 0;
    margin-right: 5px;
    background-color: transparent;
    border: 1px solid transparent;
    border-radius: 30px;
    font-size: 14px;
    padding: 11px 23px;
    line-height: 1.5;
}

.nav-tabs>.nav-item>.nav-link:hover {
    background-color: transparent;
}

.nav-tabs>.nav-item>.nav-link.active {
    background-color: #3f51b5;
    border-radius: 30px;
    color: #FFFFFF;
}

.nav-tabs>.nav-item>.nav-link i.now-ui-icons {
    font-size: 14px;
    position: relative;
    top: 1px;
    margin-right: 3px;
}

.nav-tabs.nav-tabs-neutral>.nav-item>.nav-link {
    color: #FFFFFF;
}

.nav-tabs.nav-tabs-neutral>.nav-item>.nav-link.active {
    background-color: rgba(255, 255, 255, 0.2);
    color: #FFFFFF;
}

.card {
    border: 0;
    border-radius: 0.1875rem;
    display: inline-block;
    position: relative;
    width: 100%;
    margin-bottom: 30px;
    box-shadow: 0px 5px 25px 0px rgba(0, 0, 0, 0.2);
}

.card .card-header {
    background-color: transparent;
    border-bottom: 0;
    background-color: transparent;
    border-radius: 0;
    padding: 0;
}

.card[data-background-color="orange"] {
    background-color: #f96332;
}

.card[data-background-color="red"] {
    background-color: #FF3636;
}

.card[data-background-color="yellow"] {
    background-color: #FFB236;
}

.card[data-background-color="blue"] {
    background-color: #2CA8FF;
}

.card[data-background-color="green"] {
    background-color: #15b60d;
}

[data-background-color="orange"] {
    background-color: #e95e38;
}

[data-background-color="black"] {
    background-color: #2c2c2c;
}

[data-background-color]:not([data-background-color="gray"]) {
    color: #FFFFFF;
}

[data-background-color]:not([data-background-color="gray"]) p {
    color: #FFFFFF;
}

[data-background-color]:not([data-background-color="gray"]) a:not(.btn):not(.dropdown-item) {
    color: #FFFFFF;
}

[data-background-color]:not([data-background-color="gray"]) .nav-tabs>.nav-item>.nav-link i.now-ui-icons {
    color: #FFFFFF;
}


@font-face {
  font-family: 'Nucleo Outline';
  src: url("https://github.com/creativetimofficial/now-ui-kit/blob/master/assets/fonts/nucleo-outline.eot");
  src: url("https://github.com/creativetimofficial/now-ui-kit/blob/master/assets/fonts/nucleo-outline.eot") format("embedded-opentype");
  src: url("https://raw.githack.com/creativetimofficial/now-ui-kit/master/assets/fonts/nucleo-outline.woff2");
  font-weight: normal;
  font-style: normal;
        
}

.now-ui-icons {
  display: inline-block;
  font: normal normal normal 14px/1 'Nucleo Outline';
  font-size: inherit;
  speak: none;
  text-transform: none;
  /* Better Font Rendering */
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}


footer{
    margin-top:50px;
    color: #555;
    background: #fff;
    padding: 25px;
    font-weight: 300;
    background: #f7f7f7;
    position: absolute;
    bottom: 0;
    width: 100%;
    
}
.footer p{
    margin-bottom: 0;
}
footer p a{
    color: #555;
    font-weight: 400;
}

footer p a:hover{
    color: #e86c42;
}

@media screen and (max-width: 768px) {

    .nav-tabs {
        display: inline-block;
        width: 100%;
        padding-left: 100px;
        padding-right: 100px;
        text-align: center;
    }

    .nav-tabs .nav-item>.nav-link {
        margin-bottom: 5px;
    }
}

.back {
    margin-bottom: 30px
}

</style>


<div class="container mt-5">
  <div class="row">
    <div class="col-md-12 ml-auto col-xl-12 mr-auto">
        <p class="back">
            <a href="{{ url('login') }}"> <i class="fas fa-chevron-left"></i> Back</a>
        </p>
        <a href="{{ url('login') }}"><img alt="Logo" src="{{ asset('assets/media/company-logos/logo-2.png') }}"/></a>
        <p class="category">
          GENEX HUMAN RESOURCE MANAGEMENT SYSTEM          
        </p>
      <!-- Nav tabs -->
      <div class="card">
        <div class="card-header">
          <ul class="nav nav-tabs justify-content-center" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#android" role="tab">
                <i class="fab fa-android"></i> Android
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#ios" role="tab">
                <i class="fab fa-apple"></i> iOS
              </a>
            </li>            
          </ul>
        </div>
        <div class="card-body">
          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active" id="android" role="tabpanel">
              <p>
                <table class="table">
                    <tr>
                        <td>App name</td> 
                        <td>My Genex</td>
                    </tr>
                    <tr>
                        <td>App version</td> 
                        <td>1.0.8</td>
                    </tr>
                    <tr>
                        <td>Last modified</td> 
                        <td>23 Aug 2021</td>
                    </tr>
                    <tr>
                        <td>Change log</td>
                        <td>
                            <p>
                                <ul>
                                    <li>
                                        UI improvements
                                    </li>
                                    <li>
                                        Performance improvements
                                    </li>
                                    <li>
                                        Permission module updates
                                    </li>
                                </ul>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Download
                        </td>
                        <td>
                            <a href="{{ url('mygenex/version_1_0_8.apk') }}" class="btn btn-sm btn-outline-primary"> <i class="fas fa-download"></i> Download now</a>
                        </td>
                    </tr>
                </table>
              </p>
            </div>
            <div class="tab-pane" id="ios" role="tabpanel">
              <p class=""> 
                Currently, we are working on publishing our iOS version in App Store. Meanwhile, you can use the PWA version for your iOS app.                
                  <br>
                  Benefits of PWA:
                    <li>Short loading time</li>
                    <li>Good performance in poor network conditions</li>
                    <li>Small size</li>
                    <li>App-like features (add to home screen, offline mode, push notifications)</li>
                    <li> Avoid app aggregators (Google Play, App Store, etc.)</li>
                    <li>Instant updates</li>                    
                </p>
                <hr>
                <h5>
                    How to install a Progressive Web App
                </h5>
                <p>
                    <b>Visit this <a href="https://mygenex-f7834.web.app/">url (https://mygenex-f7834.web.app/)</a> and follow the following steps:</b> <br>
                    <p>
                        <table class="table">
                            <tr>
                                <td>App name</td> 
                                <td>My Genex</td>
                            </tr>
                            <tr>
                                <td>App version</td> 
                                <td>1.0.6</td>
                            </tr>
                            <tr>
                                <td>Last modified</td> 
                                <td>08 July 2021</td>
                            </tr>
                            <tr>
                                <td>Change log</td>
                                <td>
        
                                </td>
                            </tr>                            
                        </table>
                    </p>
                    Installing a PWA on iOS is also quite simple, but can be rather limited. <b> The process unfortunately only works from the Safari browser</b>. <br>
                    <b>Step 1:</b> Navigate to the website you want to add as a PWA in Safari. <br>
                    <b>Step 2:</b> Then tap the ‘Share’ button, scroll down and tap ‘Add to Home Screen.’ Enter the name for the app then tap add. <br>
                    <b>Step 3:</b> The PWA will show up on your home screen like a native iOS app. <br>
                    <br>
                    <img style="width: 100%" class="img-responsive" src="https://cdn.mobilesyrup.com/wp-content/uploads/2020/05/install-pwa-ios-1536x1088.png" alt=""> <br><br>
                    <small>Read more <a href="https://mobilesyrup.com/2020/05/24/how-install-progressive-web-app-pwa-android-ios-pc-mac">at MobileSyrup.com: How to install a Progressive Web App on your phone and computer</a> </small>
                </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row" class="support-section">      
      <div class="col-md-12 text-center">
        <hr>
        <img style="width: 150px;" src="{{ url('mygenex/QRCode for My Genex App Support.png') }}" alt=""> <br><br>
        for support plase scan this code or visit this <a href="https://forms.office.com/r/vjbg57HkaM">support form</a> <br><br>
      </div>
  </div>
</div>


{{-- <footer class="footer text-center ">
    &copy; Genex Infosys Limited
</footer> --}}

</body>
</html>