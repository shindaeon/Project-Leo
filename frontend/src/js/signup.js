document.getElementById("btn_signup").addEventListener("click", async (e) => {
  e.preventDefault();

  const fullname = document.getElementById("fullname").value.trim();
  const username = document.getElementById("username").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const repassword = document.getElementById("repassword").value.trim();

  if (!fullname || !username || !email || !password || !repassword) {
    alert("Please fill in all fields");
    return;
  }

  if (password !== repassword) {
    alert("Passwords do not match");
    return;
  }

  try {
    const response = await fetch("../controllers/signup_handler.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        fullname: fullname,
        username: username,
        email: email,
        password: password,
      }),
    });

    const data = await response.text();
    if (data != "Signed Up Successfully, Try logging your account in.") {
      alert(data);
    }

    if (data === "Signed Up Successfully, Try logging your account in.") {
      alert(data);
      window.location.href = "login.php";
    }
  } catch (error) {
    console.error("Error:", error);
  }
});
