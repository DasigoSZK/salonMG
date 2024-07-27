const d = document;
const $inputs = d.querySelectorAll("#signupform .custom--input");


//#region FRONTEND validations
//Agrega un span por cada input/textarea y lo oculta
$inputs.forEach(input => {
  let $span = d.createElement("span");
  $span.id = input.name;
  $span.textContent = input.title;
  $span.classList.add("signup_error", "none")
  input.insertAdjacentElement("afterend", $span);
})

//If the regex doesn't validate, add "is-active" to the <span> element
d.addEventListener("keyup", e => {

  // TARGET == Passwords <input>
  if (e.target.matches("#passinput") || e.target.matches("#pass2input")) {

    let $pass1 = d.getElementById("passinput");
    let $pass2 = d.getElementById("pass2input");
    $pass2.pattern = $pass1.value;
    let regex1 = $pass1.pattern;
    regex1 = new RegExp(regex1);
    let regex2 = $pass2.pattern;
    regex2 = new RegExp(regex2);

    if (!regex1.exec($pass1.value)) {
      d.getElementById($pass1.name).classList.add("is-active");
      d.getElementById($pass1.name + "input").classList.add("is-active");
    } else if (regex1.exec($pass1.value)) {
      d.getElementById($pass1.name).classList.remove("is-active")
      d.getElementById($pass1.name + "input").classList.remove("is-active");
    }
    if (!regex2.exec($pass2.value)) {
      d.getElementById($pass2.name).classList.add("is-active");
      d.getElementById($pass2.name + "input").classList.add("is-active");
    } else if (regex2.exec($pass2.value)) {
      d.getElementById($pass2.name).classList.remove("is-active")
      d.getElementById($pass2.name + "input").classList.remove("is-active");
    }

    // TARGET == Every form <input>
  } else if (e.target.matches("#signupform .custom--input")) {
    let $input = e.target;
    let pattern = $input.pattern || false;

    //If the inputs isn't empty or the input is password
    if (pattern && $input.value !== "") {

      let regex = new RegExp(pattern);

      if (!regex.exec($input.value)) {
        d.getElementById($input.name).classList.add("is-active");
        d.getElementById($input.name + "input").classList.add("is-active");
      } else if (regex.exec($input.value)) {
        d.getElementById($input.name).classList.remove("is-active")
        d.getElementById($input.name + "input").classList.remove("is-active");
      }

    }
  }
})
//#endregion


//#region REGISTER USER
// Sends signupform
d.addEventListener("submit", e => {

  e.preventDefault();

  // ---------- Frontend validations ----------
  let validation = true;
  let errors = d.querySelectorAll(".signup_error");
  let $inputs = d.querySelectorAll("custom--input");

  // If there is an <input> with an active error <span>
  errors.forEach(error => {
    if (error.classList.contains("is-active")) {
      validation = false;
    }
  })

  // If there is an empty <input>
  $inputs.forEach($input => {
    if ($input.value === "") {
      validation = false;
    }
  })



  // ---------- Sends form ----------
  if (validation == true) {

    const $form = e.target;
    const formData = new FormData($form);

    registerUser(formData);

  } else {

    //Starts "red border" animation
    errors.forEach(error => {
      let $invalidInput = error.previousElementSibling;
      $invalidInput.classList.add("form-incomplete");
      setTimeout(() => {
        $invalidInput.classList.remove("form-incomplete");
      }, 1000)
    })

  }
})


async function registerUser(formData) {

  let res = await fetch(`${ROOT}/user/newUser`, {
    method: 'POST',
    body: formData
  });
  let json = await res.json();

  console.log(json)

  if (json.success == true) {

    // Hides error
    let $reserror = d.getElementById("reserror");
    $reserror.classList.add("d-none");
    // Hides form
    let $formContainer = d.querySelector(".signup_container");
    $formContainer.classList.add("d-none");
    let $loginLink = d.getElementById("loginLink");
    $loginLink.classList.add("d-none");

    // Shows a "SUCCESS DIV"
    let $successdiv = d.querySelector(".ressuccess");
    let $successdiv_p = d.querySelector(".ressuccess_p");
    $successdiv_p.innerHTML = `
      <b>¡Registro exitoso!</b><br>
      ${json.message}
    `;
    $successdiv.classList.remove("d-none");

  } else {
    // Shows error
    let $reserror = d.getElementById("reserror");
    let $reserror_p = d.querySelector(".reserror_p");

    $reserror_p.textContent = json.message;
    $reserror.classList.remove("d-none");
  }

}

//#endregion
