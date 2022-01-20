let i18n = new I18nInterface();
let method = "GET";
i18n.on("load", function () {
    i18n.update();
});
i18n.loadFromInterface("/assets/lang", "login", (navigator.language || navigator.userLanguage).split("-")[0], method);

window.addEventListener("load", () => {
    document.getElementById("back").addEventListener("click", () => {
        window.location.href = "/";
    });

    document.getElementById("login").addEventListener("submit", (e) => {
        e.preventDefault();
        let username = document.getElementById("username").value;
        let password = document.getElementById("password").value;

        let formData = new FormData();
        formData.set("u", username);
        formData.set("p", password);

        axios.post("/login/try", formData).then((res) => {
            if (res.data !== "fail") {
                window.location.href = "/home?name=" + encodeURIComponent(res.data);
            } else {
                alert("Your password or username is wrong");
            }
        });
    });
});
