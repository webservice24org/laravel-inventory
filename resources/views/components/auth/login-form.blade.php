<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4 class="text-center">SIGN IN</h4>
                    <div class="form-group">
                        <input id="email" placeholder="User Email" class="form-control" type="email"/>
                    </div>
                    
                    <div class="form-group">
                        <input id="password" placeholder="User Password" class="form-control" type="password"/>
                    </div>
                    <button onclick="SubmitLogin()" class="btn w-100 bg-gradient-primary">{{__('Login')}}</button>
                    
                    <div class="float-end mt-3">
                        <span>
                            <a class="text-center ms-3 h6" href="{{route('register')}}">{{__('Sign Up')}} </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{route('otp')}}">{{__('Forget Password')}}</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function SubmitLogin() {
    try {
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;

        if (email.length === 0) {
            errorToast('Email is Required');
        } else if (password.length === 0) {
            errorToast('Password is Required');
        } else {
            showLoader();
            let res = await axios.post("/login", { email: email, password: password });
            hideLoader();

            if (res.status === 200 && res.data['status'] === 'success') {
                setToken(res.data['token']);
                window.location.href = "/userProfile";
            } else {
                errorToast(res.data['message']);
            }
        }
    } catch (error) {
        console.error("Error during login:", error);
        hideLoader();
        errorToast("An error occurred during login.");
    }
}





</script>