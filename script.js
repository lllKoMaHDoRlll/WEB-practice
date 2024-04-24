function logout(event) {
    document.cookie = `${event.target.value}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`;
    reload_page();
}

function reload_page() {
    location.reload();
}

addEventListener("DOMContentLoaded", function() {
    let logoutButtonEl = this.document.getElementById("logout-button");
    logoutButtonEl.addEventListener("click", logout);
});