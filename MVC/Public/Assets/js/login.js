const d = document;

//#region Automatic login (remember user by token)
d.addEventListener("DOMContentLoaded", e => {

  let token = getCookie("token");

  if (token != null) {
    let formData = new FormData();
    formData.append("mail", "");
    formData.append("pass", "");
    formData.append("session", false);

    autenticateUser(formData);
  }
})


function getCookie(name) {
  let cookieArr = document.cookie.split(';');
  let nameEQ = name + "=";

  for (let i = 0; i < cookieArr.length; i++) {
    let cookie = cookieArr[i].trim();

    if (cookie.indexOf(nameEQ) === 0) {
      return decodeURIComponent(cookie.substring(nameEQ.length, cookie.length));
    }
  }

  // Si la cookie no existe, retornar NULL
  return null;
}
//#endregion

//#region Manual login
d.addEventListener('submit', e => {

  if (e.target.matches("#loginform")) {

    e.preventDefault();

    let formData = new FormData(e.target);

    autenticateUser(formData);
  }

})

async function autenticateUser(formData) {

  let res = await fetch(`${ROOT}/user/autenticate`, {
    method: 'POST',
    body: formData
  });
  let json = await res.json();

  if (json.success) {

    let userType = json.result;
    if (userType == 1) window.location.href = `${ROOT}/user/home`; //user
    if (userType == 2) window.location.href = `${ROOT}/admin/home`; //admin

  } else {

    let $errorDiv = d.getElementById("loginerror");
    let $errorP = d.querySelector(".loginerror_p");

    $errorDiv.classList.remove("d-none");
    $errorP.textContent = json.message;

  }
}

//#endregion
