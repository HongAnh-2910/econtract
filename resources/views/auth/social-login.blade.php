<div>
    <div class="row ml-2">
        <div class="col-2 border"></div>
        <div class="col-8 or-login-by">
            <p class="auth__text--fontfamily">Hoặc đăng nhập bằng</p>
        </div>
        <div class="col-2 border"></div>
    </div>
    <div class="row ml-2">
        <div class="col-2">

        </div>
        <div class="col-2 icon icon-google">
            <a href="{{ route('social-login', ['provider' => 'google']) }}"><img src={{ asset("images/google.png")}} alt="google"></a>
        </div>
        <div class="col-2 icon icon-sms">
            <a href="#"><img src={{ asset("images/Sms.png")}} alt="sms"></a>
        </div>
        <div class="col-2 icon icon-facebook">
            <a href="{{ route('social-login', ['provider' => 'facebook']) }}"><img src={{ asset("images/Fb.png")}} alt="facebook"></a>
        </div>
        <div class="col-2 icon icon-zalo">
            <a href="#"><img src="{{ asset("images/Zalo.png")}}" alt="zalo"></a>
        </div>
        <div class="col-2">

        </div>
    </div>
</div>
