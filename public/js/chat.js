const msgerForm = get(".msger-inputarea");
const msgerInput = get(".msger-input");
const msgerChat = get(".msger-chat");
const PERSON_IMG = "https://image.flaticon.com/icons/svg/145/145867.svg";
const chatWith = get(".chatWith");
const chatStatus = get(".chatStatus");
const typing = get(".typing");
 
msgerForm.addEventListener("submit", event => {
 
    event.preventDefault();
 
    const msgText = msgerInput.value;
 
    if (!msgText) return;
 
    msgerInput.value = "";
 
});
 
function appendMessage(name, img, side, text) {

  const msgHTML = `
    <div class="msg ${side}-msg">
      <div class="msg-img" style="background-image: url(${img})"></div>
 
      <div class="msg-bubble">
        <div class="msg-info">
          <div class="msg-info-name">${name}</div>
          <div class="msg-info-time">${formatDate(new Date())}</div>
        </div>
 
        <div class="msg-text">${text}</div>
      </div>
    </div>
  `;
 
  msgerChat.insertAdjacentHTML("beforeend", msgHTML);
  msgerChat.scrollTop += 500;
}
 
function get(selector, root = document) {
  return root.querySelector(selector);
}
 
function formatDate(date) {
    const d = date.getDate();
    const mo = date.getMonth() + 1;
    const y = date.getFullYear();
    const h = "0" + date.getHours();
    const m = "0" + date.getMinutes();
    return `${d}/${mo}/${y} ${h.slice(-2)}:${m.slice(-2)}`;
}