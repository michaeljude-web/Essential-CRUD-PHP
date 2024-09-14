// (ALL) LOADING INT
setTimeout(function () {
  document.getElementById("loadingIntro").style.display = "none";
  document.getElementById("mainPage").style.display = "flex";
}, 400);

/*--------------------------------------------------------------
  #  Create
--------------------------------------------------------------*/

// VALIDATE FORM SUBMISSION
document.getElementById("addRecordForm").addEventListener("submit", function(event) {
  let isValid = true;

  document.getElementById("firstnameError").innerText = "";
  document.getElementById("lastnameError").innerText = "";
  document.getElementById("emailError").innerText = "";

  // VALIDATE FIRSTNAME
  const firstname = document.getElementById("firstname").value;
  if (!/^[a-zA-Z\s]+$/.test(firstname)) {
      document.getElementById("firstnameError").innerText = "Please enter valid firstname.";
      isValid = false;
  }

  // VALIDATE LASTNAME
  const lastname = document.getElementById("lastname").value;
  if (!/^[a-zA-Z\s]+$/.test(lastname)) {
      document.getElementById("lastnameError").innerText = "Please enter valid laststname.";
      isValid = false;
  }

  // VALIDATE EMAIL
  const email = document.getElementById("email").value;
  const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  if (!emailPattern.test(email)) {
      document.getElementById("emailError").innerText = "Please enter valid email address.";
      isValid = false;
  }

  if (!isValid) {
      event.preventDefault();
  }
});

/*--------------------------------------------------------------
  #  Update
--------------------------------------------------------------*/

document.addEventListener("DOMContentLoaded", function() {
  const modal = document.getElementById("updateModal");
  const span = document.getElementsByClassName("close")[0];
  const updateIcons = document.getElementsByClassName("update-icon");
  const errorMessage = document.getElementById("errorMessage");

  Array.from(updateIcons).forEach(icon => {
      icon.addEventListener("click", function() {
          const id = this.getAttribute("data-id");
          const firstname = this.getAttribute("data-firstname");
          const lastname = this.getAttribute("data-lastname");
          const email = this.getAttribute("data-email");

          document.getElementById("modal-id").value = id;
          document.getElementById("modal-firstname").value = firstname;
          document.getElementById("modal-lastname").value = lastname;
          document.getElementById("modal-email").value = email;

          modal.style.display = "block";
      });
  });

  span.onclick = function() {
      modal.style.display = "none";
  };

  window.onclick = function(event) {
      if (event.target == modal) {
          modal.style.display = "none";
      }
  };

  document.getElementById("updateForm").addEventListener("submit", function(event) {
      const firstname = document.getElementById("modal-firstname").value;
      const lastname = document.getElementById("modal-lastname").value;
      const email = document.getElementById("modal-email").value;

      const namePattern = /^[a-zA-Z]+$/;
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!namePattern.test(firstname) || !namePattern.test(lastname)) {
          errorMessage.textContent = "First name and Last name should only contain letters.";
          event.preventDefault();
      } else if (!emailPattern.test(email)) {
          errorMessage.textContent = "Please enter a valid email address.";
          event.preventDefault();
      } else {
          errorMessage.textContent = "";
      }
  });
});