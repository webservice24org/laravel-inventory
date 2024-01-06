<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br/>
                    <label>New Password</label>
                    <input id="password" placeholder="New Password" class="form-control" type="password"/>
                    <br/>
                    <label>Confirm Password</label>
                    <input id="cpassword" placeholder="Confirm Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="ResetPass()" class="btn w-100 bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function ResetPass() {
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('cpassword').value;

        if (password !== confirmPassword) {
            errorToast("Password and Confirm Password do not match");
            return;
        }

        let passBody = {
            "password": password
        };

        showLoader();
        try {
            let res = await axios.post("/reset-password", passBody, HeaderToken());
            hideLoader();

            if (res.status === 200 && res.data['status'] === 'success') {
                successToast('Password Reset Success!')
                window.location.href = "/logout";
            } else {
                errorToast(res.data['message']);
            }
        } catch (error) {
            console.error("Error during password reset:", error);
            hideLoader();
            errorToast("An error occurred during password reset");
        }
    }

</script>