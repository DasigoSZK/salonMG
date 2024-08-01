import { BsModal } from './modals.js';

const d = document;
const $inputs = d.querySelectorAll("#editform .custom--input");

//#region FRONTEND validations

// Agrega un span por cada input/textarea y lo oculta
$inputs.forEach(input => {
  let $span = d.createElement("span");
  $span.id = input.name;
  $span.textContent = input.title;
  $span.classList.add("signup_error", "none")
  input.insertAdjacentElement("afterend", $span);
})

// If the regex doesn't validate, add "is-active" to the <span> element
d.addEventListener("keyup", e => {

  if (e.target.matches("#editform .custom--input")) {
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

// EDIT PASSWORD
d.addEventListener("click", e => {

  if (e.target.matches(".editform_editbtn") || e.target.matches(".editform_editbtn img")) {

    let $passInput = d.getElementById("passinput");
    let $passParentDiv = $passInput.parentElement;
    let $editbtn = d.querySelector(".editform_editbtn");

    // Hides edit btn
    $editbtn.classList.add("d-none");

    // Puts the error <span> under the pass input
    $passParentDiv.classList.remove("d-flex");

    // Makes password input editable
    $passInput.disabled = false;
    $passInput.placeholder = "";
  }

});

//#endregion

//#region BACKEND REQUEST


// Confirm changes with PASSWORD
d.addEventListener("submit", e => {

  if (e.target.matches("#editform")) {

    e.preventDefault();

    const $formContainer = d.querySelector("editaccount_container");

    BsModal.promt({
      title: 'Confirma tu contraseña',                         //Title
      content: 'Debes ingresar tu contraseña para confirmar los cambios.',                       //Description
      type: 'primary',                   //Btn color
      inputType: 'password',                 //Input type
      confirm: 'true',                   //Show or not cancel btn
      okBtnText: 'Confirmar',            //Confirm btn text
      cancelBtnText: 'Cancelar',         //Cancel btn text
      onOk: () => {              //On ok btn
        const $editForm = d.getElementById("editform");
        const $editFormData = new FormData($editForm);
        const password = d.getElementById("modal_input").value;
        editUserData($editFormData, password);
      },
      onCancel: () => {           //On cancel btn
      }
    });

  }
})

async function editUserData(formData, pass) {

  let user_id = d.getElementById("editform").id_user.value;
  const formData1 = new FormData();

  formData1.append("id", user_id);
  formData1.append("pass", pass);

  // -------------------- 1 FETCH --------------------
  let res = await fetch(`${ROOT}/user/validateUser`, {
    method: 'POST',
    body: formData1
  });
  let json = await res.json();
  // ----------------------------------------------------

  const $resError = d.querySelector(".reserror");
  const $resError_p = d.querySelector(".reserror_p");
  const $resSuccess = d.querySelector(".ressuccess");
  const $resSuccess_p = d.querySelector(".ressuccess_p");

  // -------------------- 2 FETCH --------------------
  if (json.success) {


    let res2 = await fetch(`${ROOT}/user/editUser`, {
      method: 'POST',
      body: formData
    });
    let json = await res2.json();



    // ---------- PRINT response ----------
    if (json.success) {
      $resError.classList.add("d-none");
      $resSuccess.classList.remove("d-none");
      $resSuccess_p.textContent = json.message;
    } else {
      $resSuccess.classList.add("d-none");
      $resError.classList.remove("d-none");
      $resError_p.textContent = json.message;
    }

    // ------------------------------------------------

  } else {
    // ---------- PRINT response ----------
    $resSuccess.classList.add("d-none");
    $resError.classList.remove("d-none");
    $resError_p.textContent = json.message;
  }

}
//#endregion
