let inputMailUsername = document.querySelector('#mailUsername');

inputMailUsername.addEventListener('blur', function () {
    let valueMailUsername = inputMailUsername.value;

    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let rowMessage = document.querySelector('#mailUsernameMessage');
            if (this.responseText != '') {              
                rowMessage.innerHTML = this.responseText;
            }else{
                rowMessage.innerHTML = '';
            }
        }
    }
    xhr.open('GET', '../controllers/connectionCtrl.php?formMailUsernameValue=' + valueMailUsername, true);
    xhr.send();
});

let testButton = document.querySelector('#testButton');
let inputPassword = document.querySelector('#password');
testButton.addEventListener('click', function(){
    inputMailUsername.value = 'carCrashTest';
    inputPassword.value = 'carCrashTestAccount';
})