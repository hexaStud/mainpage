let i18n = new I18nInterface();
let method = "GET";
i18n.on("load", function () {
    i18n.update();
});
i18n.loadFromInterface("/assets/lang", "404", (navigator.language || navigator.userLanguage).split("-")[0], method);

window.addEventListener("load", () => {
    document.getElementById("text").innerHTML = i18n.getTranslation("text") + " " + window.location.href;
    document.getElementById("back").addEventListener("click", () => {
        history.back();
    });
});
