function login() {
    let strJson = document.getElementById("uemail").value + ',' + document.getElementById("upassword").value;
    fetch('http://104.248.68.28:8082/api/user/login.php', {
        method: 'POST',
        body: strJson,
        headers: {
            'Content-type': 'application/json; charset=UTF-8'
        }
    }).then(function(response) {
        if (response.ok) {
            return response.json();
        }
        return Promise.reject(response);
    }).then(function(data) {
        if (data.code == 200) {
            document.cookie = 'user=' + document.getElementById("uemail").value;
            closeModal();
            getBalance();
            changeStatus();

        } else {
            let err = document.getElementById('errMessage');
            err.textContent = data.message;
            document.getElementById("logout").style.display = "none";
            return;

        }

    }).catch(function(error) {
        console.warn('Something went wrong.', error);
    });

}

function closeModal() {
    document.querySelector(".modal").style.display = "none";
}