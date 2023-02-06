document.addEventListener("DOMContentLoaded", () => {

    const codePopup = document.querySelector('#codePopup');
    const btnClipboard = document.querySelector('#clipboard');
    const btnDownload = document.querySelector('#downloadJS');
    if (typeof(btnClipboard) != 'undefined' && btnClipboard != null && typeof(btnDownload) != 'undefined' && btnDownload != null)
    {
        btnClipboard.onclick = function () {
            text = codePopup.innerText;
            temp = document.createElement("textarea");
            temp.value = text;
            $body = document.body;
            $body.appendChild(temp);
            temp.select();
            document.execCommand("copy");
            temp.remove();
            let clipboard = document.querySelector('.bi-clipboard');
            let clipboard_check = document.querySelector('.bi-clipboard-check');
            clipboard.style.display = 'none';
            clipboard_check.style.display = 'block';

            setTimeout(() => {
                clipboard.style.display = 'block';
                clipboard_check.style.display = 'none';
            }, 5000);
        }

        btnDownload.onclick = function () {
            let a = document.createElement("a");
            let code = codePopup.innerText;
            let urlPopup = code.replace('<script type="text/javascript" src="', '');
            a.href = urlPopup.replace('"></script>', '');
            a.download = "popup.js";
            a.click();
        }
    }

});

