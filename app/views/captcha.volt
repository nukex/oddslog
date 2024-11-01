<div class="d-flex justify-content-center ">

    <main class="form-signin  my-5  text-center ">
        <form method="post" action="/captcha" id="captcha-form">


            <h5 class="mb-3 fw-normal text-mute">Сaptcha Сheck</h5>

            <!-- <img src="/scripts/captcha.jpg" height="80" alt="captcha" class="my-3" />

            <div class="form-floating">
                <input name="captcha" type="text" class="form-control" id="floatingInput" maxlength="4">
                <label for="floatingInput">captcha</label>
            </div> -->


            <div class="g-recaptcha" data-sitekey="6Ld60D0gAAAAANSltdupWe0IVAgn-FN4pL7J2axz"></div>
            <br>
            <button class="w-50 btn  btn-primary " type="submit">Submit</button>


        </form>
    </main>

</div>

<script src="https://www.google.com/recaptcha/api.js"></script>