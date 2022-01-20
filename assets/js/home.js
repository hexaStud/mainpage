let projects;
let id = atob(decodeURIComponent(window.location.href).split("name=")[1]);
let i18n = new I18nInterface();
let method = "GET";
i18n.on("load", function () {
    i18n.update();
});
i18n.loadFromInterface("/assets/lang", "home", (navigator.language || navigator.userLanguage).split("-")[0],method);

window.addEventListener("load", () => {
    window.addEventListener("scroll", (e) => {
        if (window.scrollY === 0) {
            document.getElementById("navbar").classList.add("transparent");
        } else {
            document.getElementById("navbar").classList.remove("transparent");
        }
    });

    document.getElementById("logout").addEventListener("click", () => window.location.href = "/logout");

    loadProject();
});


function loadProject() {
    let lang = (navigator.language || navigator.userLanguage).split("-")[0];
    let queryString = `?lang=${lang}`;
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            projects = JSON.parse(this.responseText);
            projects.forEach((value, index) => {
                if (value.author.id.toString() !== id) {
                    projects.splice(index, 1);
                }
            });

            renderProject(projects);
        }
    }
    xhr.open("POST", "/project/get/all" + queryString, true);
    xhr.send();
}

function renderProject(projects) {
    const grid = document.getElementById("productList");
    grid.innerHTML = "";

    for (let entry of projects) {
        let gridItem = document.createElement("div");
        gridItem.classList.add("grid-item");

        let container = document.createElement("div");
        container.classList.add("container", "center");

        let iconBox = document.createElement("div");
        iconBox.classList.add("iconBox");

        let img = document.createElement("img");
        img.src = `/project/get/img?id=${entry.id}&c=${entry.icon}`;

        let subsubtitle = document.createElement("div");
        subsubtitle.classList.add("subsubtitle");

        let span = document.createElement("span");
        span.innerHTML = entry.name;

        let linkBox = document.createElement("div");
        linkBox.classList.add("linkBox", "margin-t-25px");

        let a = document.createElement("a");
        a.innerHTML = i18n.getTranslation("product>edit");
        a.href = "/home/edit/" + entry.id + window.location.search;

        linkBox.appendChild(a);
        subsubtitle.appendChild(span);
        iconBox.appendChild(img);
        container.appendChild(iconBox);
        container.appendChild(subsubtitle);
        container.appendChild(linkBox);

        gridItem.appendChild(container);
        grid.appendChild(gridItem);
    }
}

