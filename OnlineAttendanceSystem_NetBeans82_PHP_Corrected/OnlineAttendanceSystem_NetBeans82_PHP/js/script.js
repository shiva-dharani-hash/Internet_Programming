function changeUsernameLabel() {
    var role = document.getElementById("role");
    var label = document.getElementById("usernameLabel");
    var input = document.getElementById("username");

    if (!role || !label || !input) {
        return;
    }

    if (role.value === "faculty") {
        label.innerHTML = "Faculty Email";
        input.placeholder = "Enter faculty email";
    } else {
        label.innerHTML = "Register Number";
        input.placeholder = "Enter register number";
    }
}

function validateLogin() {
    var username = document.getElementById("username").value.replace(/^\s+|\s+$/g, "");
    var password = document.getElementById("password").value;

    if (username === "") {
        alert("Please enter username.");
        return false;
    }

    if (password === "") {
        alert("Please enter password.");
        return false;
    }

    return true;
}

function confirmLogout() {
    return confirm("Are you sure you want to logout?");
}
