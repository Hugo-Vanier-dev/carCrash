let inputMail = document.querySelector('#mail');
let inputUsername = document.querySelector('#username');
let inputPassword = document.querySelector('#password');
let progressBarPassword = document.querySelector('#progressVerifPassword');
let formGroupPassword = document.querySelector('#formGroupPassword');
let messageErrorPassword = document.querySelector('#messageErrorPassword');


inputMail.addEventListener('blur', function () {
    let mailValue = inputMail.value;
    console.log(mailValue);
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let mailMessage = JSON.parse(this.responseText);
            let rowMessage = document.querySelector('#mailMessage');
            rowMessage.innerHTML = '';
            rowMessage.innerHTML = mailMessage.message;
            if (mailMessage.status == 'success') {
                rowMessage.classList.remove('text-danger');
                rowMessage.classList.add('text-success');
                inputMail.style = 'border: #009670 solid 2px';
            }else{
                rowMessage.classList.remove('text-success');
                rowMessage.classList.add('text-danger');
                inputMail.style = 'border: #E12E1C solid 2px';
            }
        }
    }
    xhr.open('GET', '../controllers/inscriptionCtrl.php?formMailValue=' + mailValue, true);

    xhr.send();
});
inputUsername.addEventListener('blur', function () {
    let usernameValue = inputUsername.value;
    console.log(usernameValue);
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let usernameMessage = JSON.parse(this.responseText);
            let rowMessage = document.querySelector('#usernameMessage');
            rowMessage.innerHTML = '';
            rowMessage.innerHTML = usernameMessage.message;
            if (usernameMessage.status == 'success') {
                rowMessage.classList.remove('text-danger');
                rowMessage.classList.add('text-success');
                inputUsername.style = 'border: #009670 solid 2px';
            }else{
                rowMessage.classList.remove('text-success');
                rowMessage.classList.add('text-danger');
                inputUsername.style = 'border: #E12E1C solid 2px';
            }

        }
    }

    xhr.open('GET', '../controllers/inscriptionCtrl.php?formUsernameValue=' + usernameValue, true);
    xhr.send();
});
inputPassword.addEventListener('keyup', function(){
   let inputPasswordLength = inputPassword.value.length;
   if(inputPasswordLength > 0 && inputPasswordLength < 12){   
       progressBarPassword.style = 'background: linear-gradient(to right, #E12E1C, orange); width: 160px';
       formGroupPassword.classList.remove('m-0');
       formGroupPassword.style = 'margin: 0px; margin-bottom: 3%';
       messageErrorPassword.innerHTML = '';       
   }else if(inputPasswordLength > 12 && inputPasswordLength < 20){      
       progressBarPassword.style = 'background: linear-gradient(to right, #E12E1C, orange, yellow); width: 320px';
       formGroupPassword.classList.remove('m-0');
       formGroupPassword.style = 'margin: 0px; margin-bottom: 3%';
   }else if(inputPasswordLength > 20){      
       progressBarPassword.style = 'background: linear-gradient(to right, #E12E1C, orange, yellow, green); width: 480px';
       formGroupPassword.classList.remove('m-0');
       formGroupPassword.style = 'margin: 0px; margin-bottom: 3%';
   }else{
       formGroupPassword.classList.add('m-0');
       progressBarPassword.style = 'width: 0px';
   }
});
