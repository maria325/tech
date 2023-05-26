
  // Function to validate that input contains only letters
  function validateLettersOnly(input) {
    var letters = /^[A-Za-z]+$/;
    return letters.test(input);
  }
  // Function to handle form submission and perform additional validation
  function validateForm(event) {
    var firstNameInput = document.getElementById('FName');
    var lastNameInput = document.getElementById('LName');
  
    var firstName = firstNameInput.value;
    var lastName = lastNameInput.value;
    if (!validateLettersOnly(firstName)) {
      if (!sessionStorage.getItem('alertShown')) {
        var alertDiv = document.createElement('div');
        alertDiv.classList.add('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'position-fixed', 'top-0', 'start-50', 'translate-middle-x');
        alertDiv.style.backgroundColor = 'white';
        alertDiv.style.color = 'black';
        alertDiv.innerHTML = 'Error: Please enter only letters in the First Name field.';
        alertDiv.innerHTML += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        document.body.appendChild(alertDiv);
        setTimeout(function() {
          alertDiv.style.display = 'none';
        }, 2000);
        sessionStorage.setItem('alertShown', true); // Set the sessionStorage value to indicate that the alert has been shown
      }
      firstNameInput.focus();
      event.preventDefault(); // Prevent form submission
      return false;
    }
    if (!validateLettersOnly(lastName)) {
      if (!sessionStorage.getItem('alertShown')) {
        var alertDiv = document.createElement('div');
        alertDiv.classList.add('alert', 'alert-danger', 'alert-dismissible', 'fade', 'show', 'position-fixed', 'top-0', 'start-50', 'translate-middle-x');
        alertDiv.style.backgroundColor = 'white';
        alertDiv.style.color = 'black';
        alertDiv.innerHTML = 'Error: Please enter only letters in the Last Name field.';
        alertDiv.innerHTML += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        document.body.appendChild(alertDiv);
        setTimeout(function() {
          alertDiv.style.display = 'none';
        }, 2000);
        sessionStorage.setItem('alertShown', true); // Set the sessionStorage value to indicate that the alert has been shown
      }
      lastNameInput.focus();
      event.preventDefault(); // Prevent form submission
      return false;
    }
    // Form is valid, allow submission
    return true;
  }
  const container = document.querySelector(".container"),
  pwShowHide = document.querySelectorAll(".showHidePw"),
  pwFields = document.querySelectorAll(".password"),
  signUp = document.querySelector(".signup-link"),
  login = document.querySelector(".login-link");
//   js code to show/hide password and change icon
pwShowHide.forEach(eyeIcon =>{
    eyeIcon.addEventListener("click", ()=>{
        pwFields.forEach(pwField =>{
            if(pwField.type ==="password"){
                pwField.type = "text";
                pwShowHide.forEach(icon =>{
                    icon.classList.replace("uil-eye-slash", "uil-eye");
                })
            }else{
                pwField.type = "password";
                pwShowHide.forEach(icon =>{
                    icon.classList.replace("uil-eye", "uil-eye-slash");
                })
            }
        }) 
    })
})
// js code to appear signup and login form
signUp.addEventListener("click", ( )=>{
    container.classList.add("active");
});
login.addEventListener("click", ( )=>{
    container.classList.remove("active");
});





  
  
