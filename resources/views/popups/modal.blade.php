<div id="Popup"
     style="position: fixed; z-index: 1; padding-top: 100px; left: 0px; top: 0px; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.4);">
    <div style="position: relative; background-color: rgb(0, 0, 0); color: white; margin: auto; width: 70%;">
        <div style="text-align: center; padding: 20px; display: flex; justify-content: center;"><p
                style="margin: auto;">{{$popup->description}}</p></div>
        <div style="text-align: center; background: rgb(255, 255, 255); padding: 20px; width: 100%;">
            <button id="closePopup"
                    onclick="document.querySelector('#Popup').style.cssText = 'opacity:0; transition: opacity 1.5s ease-out; position: fixed; z-index: 1; padding-top: 100px; left: 0px; top: 0px; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.4);';  setTimeout(()=>{document.querySelector('#Popup').style.cssText = 'display:none;'}, 1000); return false;"
                    style="background: rgb(40, 167, 69); color: white; border: 1px solid; padding: 15px; width: 30%;">
                ЗАКРЫТЬ ПОПАП
            </button>
        </div>
    </div>
</div>
