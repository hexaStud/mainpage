let projects;
let i18n = new I18nInterface();
let method = "GET";
i18n.on("load", function () {
    i18n.update();
});
i18n.loadFromInterface("/assets/lang", "projectDetail", (navigator.language || navigator.userLanguage).split("-")[0],method);


window.addEventListener("load", () => {
    window.addEventListener("scroll", (e) => {
        if (window.scrollY === 0) {
            document.getElementById("navbar").classList.add("transparent");
        } else {
            document.getElementById("navbar").classList.remove("transparent");
        }
    });

    document.getElementById("back").addEventListener("click", () => {
        history.back();
    });

    loadProject().then(() => {
        let id = window.location.pathname.split("/").pop()
        let project = getProject(id);

        document.title = "HexaStudio - " + project.name;

        if (!!project) {
            document.getElementById("projectIcon").src = `/project/get/img?id=${id}&c=${project.icon}`;
            document.getElementById("projectTitle").innerHTML = project.name;
            document.getElementById("projectWallpaper").src = `/project/get/img?id=${id}&c=${project.wallpaper}`;
            document.getElementById("projectLicense").innerHTML = i18n.getTranslation("details>license") + " " + project.license;
            document.getElementById("projectDescription").innerHTML = project.lang.globalDescription.replace(/\n/gi, "<br>");
            document.getElementById("projectSign").innerHTML = project.author.name;

            const list = document.getElementById("productList");
            list.innerHTML = "";

            for (const version of project.versions) {
                let li = document.createElement("li");

                let subsubtitel = document.createElement("div");
                subsubtitel.classList.add("subsubtitle", "left", "padding-b-25px");

                let span = document.createElement("span");
                span.innerHTML = i18n.getTranslation("productList>version") + " " + version.tag;

                let textBox = document.createElement("div");
                textBox.classList.add("textBox", "underlined", "left");

                let span2 = document.createElement("span");
                span2.innerHTML = i18n.getTranslation("productList>changes");

                let listBox = document.createElement("div");
                listBox.classList.add("listBox", "small");

                let ul = document.createElement("ul");

                for (let change of project.lang[version.tag].versionChange) {
                    let li = document.createElement("li");
                    li.innerHTML = change;
                    ul.appendChild(li);
                }

                let textBox2 = document.createElement("div");
                textBox2.classList.add("textBox", "underlined", "left", "padding-t-25px");

                let span3 = document.createElement("span");
                span3.innerHTML = i18n.getTranslation("productList>download");

                let listBox2 = document.createElement("div")
                listBox2.classList.add("listBox", "small");

                let ul1 = document.createElement("ul");
                for (const download of version.downloads) {
                    let li = document.createElement("li");
                    let linkBox = document.createElement("div");
                    linkBox.classList.add("linkBox");
                    let a = document.createElement("a");
                    a.href = `/project/download/${id}/` + download.file;
                    a.download = `V${version.tag}-${download.name}.zip`;
                    a.innerHTML = i18n.getTranslation("productList>downloadText") + " " + download.name;
                    linkBox.appendChild(a);
                    li.appendChild(linkBox);
                    ul1.appendChild(li);
                }

                let splitLine = document.createElement("div");
                splitLine.classList.add("splitLine");

                listBox2.appendChild(ul1);
                textBox2.appendChild(span3);
                listBox.appendChild(ul);
                textBox.appendChild(span2);
                subsubtitel.appendChild(span);
                li.appendChild(subsubtitel);
                li.appendChild(textBox);
                li.appendChild(listBox);
                li.appendChild(textBox2);
                li.appendChild(listBox2);
                li.appendChild(splitLine);

                list.appendChild(li);
            }
        } else {
            throw "Project '" + id + "' dont exists";
        }
    });
});

async function loadProject() {
    return new Promise(function (resolve) {
        let lang = (navigator.language || navigator.userLanguage).split("-")[0];
        let queryString = `?lang=${lang}`;
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                projects = JSON.parse(this.responseText);
                resolve();
            }
        }
        xhr.open("POST", "/project/get/all" + queryString, true);
        xhr.send();
    });
}

function getProject(id) {
    for (const project of projects) {
        if (project.id === id) {
            return project;
        }
    }

    return null;
}

