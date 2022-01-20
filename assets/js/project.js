let projects;
let i18n = new I18nInterface();
let method = "GET";
i18n.on("load", function () {
    i18n.update();
});
i18n.loadFromInterface("/assets/lang", "project", (navigator.language || navigator.userLanguage).split("-")[0],method);

window.addEventListener("load", () => {
    window.addEventListener("scroll", (e) => {
        if (window.scrollY === 0) {
            document.getElementById("navbar").classList.add("transparent");
        } else {
            document.getElementById("navbar").classList.remove("transparent");
        }
    });
    loadProject();

    document.getElementById("back").addEventListener("click", () => {
        window.close();
    });

    document.getElementById("search").addEventListener("keyup", function () {
        let val = this.value;
        if (val === "") {
            renderProject(projects);
        } else {
            val = val.toLowerCase();
            let newProject = [];

            function push(value) {
                for (const pr of newProject) {
                    if (pr.id === value.id) {
                        return;
                    }
                }

                newProject.push(value);
            }

            projects.forEach((value) => {
                if (value.name.toLowerCase().startsWith(val)) {
                    push(value);
                }
            });

            projects.forEach((value) => {
                if (value.author.name.toLowerCase().startsWith(val) || value.author.id.toString() === val) {
                    push(value);
                }
            });

            projects.forEach((value) => {
                if (value.lang.globalDescription.toLowerCase().indexOf(val) !== -1) {
                    push(value);
                }
            });

            renderProject(newProject);
        }
    });
});

function loadProject() {
    let lang = (navigator.language || navigator.userLanguage).split("-")[0];
    let queryString = `?lang=${lang}`;
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            projects = JSON.parse(this.responseText);
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

        let textBox = document.createElement("div");
        textBox.classList.add("textBox");

        let p = document.createElement("p");
        p.innerHTML = entry.lang.globalDescription;

        let doubleTextBox = document.createElement("div");
        doubleTextBox.classList.add("doubleTextBox");

        let noteLeft = document.createElement("div");
        noteLeft.classList.add("noteText", "left");

        let span1 = document.createElement("span");
        span1.innerHTML = entry.author.name;

        let linkRight = document.createElement("div");
        linkRight.classList.add("linkBox", "right");
        let a = document.createElement("a");
        a.innerHTML = i18n.getTranslation("products>cardLink");
        a.href = "/project/detail/" + entry.id

        subsubtitle.appendChild(span);
        iconBox.appendChild(img);
        textBox.appendChild(p);
        noteLeft.appendChild(span1);
        linkRight.appendChild(a);
        doubleTextBox.appendChild(noteLeft);
        doubleTextBox.appendChild(linkRight);
        container.appendChild(iconBox);
        container.appendChild(subsubtitle);
        container.appendChild(textBox);
        container.appendChild(doubleTextBox);

        gridItem.appendChild(container);
        grid.appendChild(gridItem);
    }
}
