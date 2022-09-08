function registration(){
    let name = document.getElementById('name');
    let email = document.getElementById('email');
    let uname = document.getElementById('uname');
    let password = document.getElementById('pass');
   
    if(name.value!="" && email.value!="" && uname.value!="" && password.value!="")
    {
        const json = {
            'name': name.value,
            'uname' : uname.value,
            'email' : email.value,
            'password' : password.value,
        };
        const data = JSON.stringify(json);
        const http = new XMLHttpRequest();
        http.open('POST', `registration_controller.php`, true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send(`mydata=${data}`);
     
        http.onreadystatechange = function(){
    
            if(this.readyState == 4 && this.status == 200){
               
                
                    alert(this.responseText);
         
               
            }
        }
    }
    else{
        alert("something went wrong");
    }
}