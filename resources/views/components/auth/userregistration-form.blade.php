<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Sign Up</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input id="email" placeholder="User Email" class="form-control" type="email"/>
                                </div>
                            </div>
                            <div class="col-md-4 p-2">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input id="firstName" placeholder="First Name" class="form-control" type="text"/>
                                </div>
                            </div>
                            <div class="col-md-4 p-2">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input id="lastName" placeholder="Last Name" class="form-control" type="text"/>
                                </div>
                            </div>
                            <div class="col-md-4 p-2">
                                <div class="form-group">
                                    <label>Mobile Number</label>
                                    <input id="mobile" placeholder="Mobile" class="form-control" type="mobile"/>
                                </div>
                            </div>
                            <div class="col-md-4 p-2">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input id="password" placeholder="User Password" class="form-control" type="password"/>
                                </div>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onRegistration()" class="btn mt-3 w-100  bg-gradient-primary">Complete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function onRegistration(){
        let profileBody = {
            "email": document.getElementById('email').value,
            "firstName": document.getElementById('firstName').value,
            "lastName": document.getElementById('lastName').value,
            "mobile": document.getElementById('mobile').value,
            "password": document.getElementById('password').value

        }
        showLoader();
        let res=await axios.post("/register",profileBody,HeaderToken());
        hideLoader();
        if (res.status===200 && res.data['status']==='success') {
            window.location.href='/login';
            successToast(res.data['message']);
            
        } else {
            errorToast(res.data['status']==='message');
        }
    }




</script>