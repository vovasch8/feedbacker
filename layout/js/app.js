let btn_preview = document.querySelector(".btn-preview");

btn_preview.addEventListener("click", e => {

    let input_name = document.getElementsByName("name")[0];
    let input_email = document.getElementsByName("email")[0];
    let area_message = document.getElementsByName("message")[0];
    let preview = document.querySelector(".preview");
    let date = new Date();
    let date_time = formatDate(date);

    if(input_name.value != "" && input_email.value != "" && area_message.value != "") {
        preview.innerHTML = "<div class=\"response mb-3\">\n" +
            "                    <div class=\"row\">\n" +
            "                        <div class=\"col-3\">\n" +
            "                            <span>" + input_name.value + "</span><br>\n" +
            "                            <span class=\"text-secondary\">" + input_email.value + "</span><br>\n" +
            "                        </div>\n" +
            "                        <div class=\"col-9\">\n" +
            "                            <span>" + area_message.value + "</span><br>\n" +
            "                            <span class=\"text-secondary message-time\">" + date_time + "</span>\n" +
            "                        </div>\n" +
            "                    </div>\n" +
            "                </div>";
    }else{
        alert("Заповніть всі поля!");
    }
});



function formatDate(date){
    let m = date.getMonth() > 10 ? date.getMonth() : '0' + date .getMonth();
    let d = date.getDay() > 10 ? date.getDay() : '0' + date .getDay();
    let h = date.getHours() > 10 ? date.getHours() : '0' + date .getHours();
    let min = date.getMinutes() > 10 ? date.getMinutes() : '0' + date .getMinutes();

    return m + "." + d + " " + h + ":" + min;
}

let count_click = 0;
let sort = document.querySelector("#sort");

sort.addEventListener("change", e => {
    count_click = 0;
    let xhr = new XMLHttpRequest();

    xhr.open("get", "http://feedbacker/components/AjaxHandler.php?method=loadResponse&sort=" + e.target.value + "&offset=0", false);

    xhr.send();

    if (xhr.status != 200) {
        // обработать ошибку
        alert( xhr.status + ': ' + xhr.statusText ); // пример вывода: 404: Not Found
    } else {
        // вывести результат
        let div = document.querySelector("#responses-block");
         div.innerHTML = xhr.response; // responseText -- текст ответа.
    }
});

let btn_load_more = document.querySelector("#load-more");

btn_load_more.addEventListener("click", e =>{

   let select = document.querySelector("#sort");
   let index = document.querySelector("#sort").options.selectedIndex;
   count_click+=5;

   let xhr = new XMLHttpRequest();

    xhr.open("get", "http://feedbacker/components/AjaxHandler.php?method=loadResponse&sort=" + select.options[index].value + "&offset=" + count_click, false);

    xhr.send();

    if (xhr.status != 200) {
        // обработать ошибку
        alert( xhr.status + ': ' + xhr.statusText ); // пример вывода: 404: Not Found
    } else {
        // вывести результат
        let div = document.querySelector("#responses-block");
        div.innerHTML += xhr.response; // responseText -- текст ответа.
    }
});

function openEditMessage(el){
    let response_id = el.closest(".response").id;
    document.querySelector("#user").setAttribute('value', response_id);
    let response_message = el.closest(".response-message").textContent;

    let text_area_message = document.querySelector("#edit-message");

    text_area_message.value = response_message;
}

function editResponse(){

    let xhr = new XMLHttpRequest();

    let message = document.querySelector("#edit-message").value;
    let id = document.querySelector("#user").getAttribute('value');


    xhr.open("get", "http://feedbacker/components/AjaxHandler.php?method=editResponse&id=" + id +"&message=" + message, false);

    xhr.send();

    if (xhr.status != 200) {
        // обработать ошибку
        alert( xhr.status + ': ' + xhr.statusText ); // пример вывода: 404: Not Found
    } else {
        // вывести результат
        let response = document.getElementById(id);
        let response_mess = response.querySelector(".response-message");

        response_mess.innerHTML = message + '<span class="text-primary">Редаговано адміном</span>';
    }
}

function deleteResponse(el){
    let xhr = new XMLHttpRequest();
    let response_id = el.closest(".response").id;

    xhr.open("get", "http://feedbacker/components/AjaxHandler.php?method=deleteResponse&id=" + response_id, false);

    xhr.send();

    if (xhr.status != 200) {
        // обработать ошибку
        alert( xhr.status + ': ' + xhr.statusText ); // пример вывода: 404: Not Found
    } else {
        let response = document.getElementById(response_id);
        response.remove();
    }
}