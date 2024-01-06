<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>EMAIL ADDRESS</h4>
                    <br/>
                    <label>Your email address</label>
                    <input id="email" placeholder="User Email" class="form-control" type="email"/>
                    <br/>
                    <button onclick="SendOTP()"  class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function SendOTP(){
        let otpBody = {
            "email": document.getElementById('email').value
        }
        showLoader();
        let res=await axios.post("/send-otp",otpBody);
        hideLoader();
        if (res.status===200 && res.data['status']==='success') {
            //sessionStorage.setItem("email", document.getElementById('email').value);
            sessionStorage.setItem('email', otpBody.email);
            window.location.href='/verify-otp';
            successToast(res.data['message']);
            
        } else {
            errorToast(res.data['status']==='message');
        }
    }
</script>