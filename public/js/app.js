
function copyElementText(element) {
    const text = element.textContent || element.innerText;
    const el = document.createElement('textarea');
    const toast = document.querySelector('.toast');
    var toastBody = toast.querySelector('.toast-body');
    toast.classList.remove('text-bg-danger');
    toast.classList.add('text-bg-primary');
    toastBody.innerText = "تم نسخ النص";
    el.value = text;
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
    toast.classList.add('active');
    setTimeout(function() {
        toast.classList.remove('active')
    }, 5000);
};
function SubmitMessage(text ,responeCode) {
    const toast = document.querySelector('.toast');
    var toastBody = toast.querySelector('.toast-body');
    if (responeCode == 200){
        toast.classList.remove('text-bg-danger');
        toast.classList.add('text-bg-primary');
        toastBody.innerText = "تم التأكيد";
    }else{
        toast.classList.remove('text-bg-danger');
        toast.classList.add('text-bg-danger');
        toastBody.innerText = text;
    }
    toast.classList.add('active');
    setTimeout(function() {
        toast.classList.remove('active')
    }, 5000);
}
const elementsToCopy = document.querySelectorAll('.copy-element');
elementsToCopy.forEach(function(element) {
    element.addEventListener('click', function() {
        copyElementText(element);
        console.log(element.textContent || element.innerText);
    });
});

let submitDesign = document.querySelectorAll('.submit-design-btn');
function makeAjaxRequest(type,id, user, language ,input ,checkBox, spinner) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/api/submit-design', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', 'xHOztgiVBG9D0k4Cclk5SAASb028epFGFZdvXvgV'); // If you're using CSRF protection
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 401) {
                // The user is not logged in, redirect to the login route
                window.location.href = "/login";
            }
            else if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            // Handle the response data
            checkBox.classList.remove('d-none');
            spinner.classList.add('d-none');
            input.classList.add('active');
            SubmitMessage(response.message, 200)
            } else {
            var response = JSON.parse(xhr.responseText);
            checkBox.classList.remove('d-none');
            input.checked = false;
            spinner.classList.add('d-none');
            // Handle the error
            SubmitMessage(response.message, 400)
            }
        }
    };
    var requestData = JSON.stringify({
        design_id: id,
        type: type,
        user_id: user,
        lang: language,
    }); // Replace with your request payload
    xhr.send(requestData);
}
submitDesign.forEach(function(design) {
    design.addEventListener('click', function() {
    let delay = 3000; // 5 Seconds
    if (design.classList.contains('active')) {
        console.log('yes')
    }else{
        const spinner = document.createElement('div');
        spinner.classList.add('spinner-border');
        spinner.setAttribute("role", "status");
        let input = design.parentElement.children[0];
        let checkBox = design.parentElement.children[1];
        checkBox.classList.add('d-none')
        design.parentElement.appendChild(spinner);
        console.log(checkBox);
        function sendRequest(){
            let id = design.dataset.id;
            let type = design.dataset.type;
            let user = design.dataset.user;
            let language = design.dataset.language;
            makeAjaxRequest(type, id, user, language ,input ,checkBox, spinner);
        }
        setTimeout(sendRequest, delay);
    }
});
});
