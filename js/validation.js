function validateRegister() {
   
    let name = document.getElementById('name').value;
    let email = document.getElementById('email').value;
    let pass = document.getElementById('password').value;
    let confPass = document.getElementById('confirmpassword').value;

    if (name == "" || email == "" || pass == "" || confPass == "") {
        alert("Please fill in all the fields!");
        return false; 
    }

    if (pass.length < 6) {
        alert("The password must be at least 6 characters long!");
        return false;
    }

    return true; 
}