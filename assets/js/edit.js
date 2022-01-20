let projects;
let project;
let descriptions = [];
let versions = [];
let wallpaper;
let icon;
let id = atob(decodeURIComponent(window.location.href).split("name=")[1]);
let projectID = window.location.pathname.split("/").pop();
let i18n = new I18nInterface();
let method = "GET";
i18n.on("load", function () {
    i18n.update();
});
i18n.loadFromInterface("/assets/lang", "edit", (navigator.language || navigator.userLanguage).split("-")[0],method);

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
        for (let p of projects) {
            if (p.id === projectID) {
                project = p;
                break;
            }
        }

        descriptions.push(document.getElementById("projectDescription"));

        document.getElementById("projectName").value = project.name;
        document.getElementById("projectLicense").value = project.license;
        document.getElementById("projectDescription").value = project.allLang.en.globalDescription;
        document.getElementById("wallpaper").src = `/project/get/img?id=${projectID}&c=${project.wallpaper}`;
        document.getElementById("icon").src = `/project/get/img?id=${projectID}&c=${project.icon}`;

        buildTranslations(project.allLang);
        buildVersions(project.versions);

        document.getElementById("addTranslation").addEventListener("click", () => {
            let newLang = prompt("Insert Language Character");
            addTranslation(newLang);
        });
        document.getElementById("changeWallpaper").addEventListener("click", () => {
            let input = document.createElement("input");
            input.type = "file";
            input.addEventListener("change", () => {
                console.log(input.files);
                if (input.files.length === 1) {
                    let url = URL.createObjectURL(input.files[0]);
                    document.getElementById("wallpaper").src = url;
                    wallpaper = input;
                }

                input.remove();
            });
            input.click();
            document.body.appendChild(input);
        });

        document.getElementById("changeIcon").addEventListener("click", () => {
            let input = document.createElement("input");
            input.type = "file";
            input.addEventListener("change", () => {
                console.log(input.files);
                if (input.files.length === 1) {
                    let url = URL.createObjectURL(input.files[0]);
                    document.getElementById("icon").src = url;
                    icon = input;
                }


                input.remove();
            });
            input.click();
            document.body.appendChild(input);
        });

        document.getElementById("addVersionFile").addEventListener("click", () => {
            addVersion();
        });
    });

    document.getElementById("saveData").addEventListener("click", () => {
        let shadow = document.createElement("div");
        shadow.classList.add("shadow");
        document.body.appendChild(shadow);

        function getVersions() {
            let obj = [];

            for (let version of versions) {
                let data = {
                    tag: version.tag.value,
                }

                let downloads = [];

                for (let download of version.files) {
                    downloads.push({
                        name: download.name.value,
                        file: (!!download.file.src) ? download.file.name : download.file
                    });
                }

                data.downloads = downloads;
                obj.push(data);
            }

            return obj;
        }

        let conf = {
            id: parseInt(project.id),
            name: document.getElementById("projectName").value,
            icon: project.icon,
            wallpaper: project.wallpaper,
            author: project.author,
            license: document.getElementById("projectLicense").value,
            versions: getVersions()
        }


        let lang = {};
        for (let desc of descriptions) {
            let key = desc.getAttribute("lang");
            if (!lang[key]) {
                lang[key] = {};
            }

            lang[key].globalDescription = desc.value;
            for (let v of versions) {
                if (!lang[key][v.tag.value]) {
                    lang[key][v.tag.value] = {
                        versionChange: []
                    }
                }

                if (!!v.changeNodes) {
                    for (let x of v.changeNodes) {
                        if (key === x.getAttribute("lang")) {
                            lang[key][v.tag.value].versionChange = x.value.split(/\n/gi);
                        }
                    }
                } else {
                    lang[key][v.tag.value].versionChange = [];
                }
            }
        }

        let x = {
            conf: conf,
            lang: lang,
        }

        function upload() {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/home/edit/set/data?d=" + btoa(JSON.stringify(x)), false);
            xhr.send();

            if (!!wallpaper) {
                let formData = new FormData();
                formData.append("file", wallpaper.files[0]);
                axios.post('/home/edit/set/img?id=' + x.conf.id + "&k=wallpaper", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
            }

            if (!!icon) {
                let formData = new FormData();
                formData.append("file", icon.files[0]);
                axios.post('/home/edit/set/img?id=' + x.conf.id + "&k=icon", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
            }

            for (let version of versions) {
                let index = 0;
                for (let download of version.files) {
                    if (!!download.file.src) {
                        let formData = new FormData();
                        formData.append("file", download.file.src.files[0]);
                        axios.post('/home/edit/set/version?id=' + x.conf.id + "&t=" + version.tag.value + "&i=" + index, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });
                    }
                    index++;
                }
            }
            shadow.remove();
            // window.location.href = "/home" + window.location.search;
        }

        upload();
    });
});

function buildVersions(versions) {
    for (let version of versions) {
        addVersion(version);
    }
}

function addVersion(version = {
    downloads: [],
    tag: ""
}) {
    let index = versions.length;
    let obj = {};
    let container = document.createElement("div");
    container.classList.add("container");

    let tag = document.createElement("input");
    tag.placeholder = i18n.getTranslation("versions>tag");
    tag.value = version.tag;
    obj.tag = tag;

    let splitLine = document.createElement("div");
    splitLine.classList.add("splitLine");

    let subtitle = document.createElement("div");
    subtitle.classList.add("subtitle", "margin-t-25px");
    let span = document.createElement("span");
    span.innerHTML = i18n.getTranslation("versions>subtitle0");


    let downloadContainer = document.createElement("div");
    obj.files = [];

    function addDownloadFile(download, i) {
        let wrap = document.createElement("div");
        let platform = document.createElement("input");
        platform.placeholder = i18n.getTranslation("versions>platform");
        platform.value = download.name;

        let doubleText = document.createElement("div");
        doubleText.classList.add("doubleTextBox");

        let file = document.createElement("div");
        file.classList.add("textBox", "left", "color:black");
        let span = document.createElement("span");
        span.innerHTML = download.file;

        let change = document.createElement("div");
        change.classList.add("linkBox", "right");
        let a = document.createElement("a");
        a.innerHTML = i18n.getTranslation("versions>changeFile");
        a.addEventListener("click", () => {
            let input = document.createElement("input");
            input.type = "file";
            input.addEventListener("change", () => {
                console.log(input.files);
                if (input.files.length === 1) {
                    versions[index].files[i].file = {};
                    versions[index].files[i].file.src = input;
                    versions[index].files[i].file.name = input.value.split("\\").pop()
                    span.innerHTML = versions[index].files[i].file.name;
                }
                input.remove();
            });
            input.click();
            document.body.appendChild(input);
        });

        let linkBox = document.createElement("div");
        linkBox.classList.add("linkBox");
        let a1 = document.createElement("a");
        a1.innerHTML = i18n.getTranslation("versions>removeFile");
        a1.addEventListener("click", () => {
            wrap.remove();
            versions[index].files.splice(i, 1);
            console.log(versions);
        });

        let splitLine = document.createElement("div");
        splitLine.classList.add("splitLine");

        file.appendChild(span);
        change.appendChild(a);
        doubleText.appendChild(file);
        doubleText.appendChild(change);
        linkBox.appendChild(a1);

        wrap.appendChild(platform);
        wrap.appendChild(doubleText);
        wrap.appendChild(linkBox);
        wrap.appendChild(splitLine);
        downloadContainer.appendChild(wrap);

        obj.files[i] = {};
        obj.files[i].name = platform
        obj.files[i].file = download.file;
    }

    for (let i = 0; i < version.downloads.length; i++) {
        addDownloadFile(version.downloads[i], i);
    }

    let linkBox = document.createElement("div");
    linkBox.classList.add("linkBox", "margin-t-25px");
    let a = document.createElement("a");
    a.innerHTML = i18n.getTranslation("versions>addVersionFile");
    a.addEventListener("click", () => {
        addDownloadFile({
            name: "",
        }, versions[index].files.length);
    });

    let splitLine1 = document.createElement("div");
    splitLine1.classList.add("splitLine");

    let subtitle1 = document.createElement("div");
    subtitle1.classList.add("subtitle", "margin-t-25px");
    let span1 = document.createElement("span");
    span1.innerHTML = i18n.getTranslation("versions>subtitle1");

    let changeNodesContainer = document.createElement("div");
    obj.changeNodes = [];

    function addChangeNode(lang, str) {
        let k = obj.changeNodes.length;
        let text = document.createElement("textarea");
        text.setAttribute("lang", lang);
        text.innerHTML = str;

        let linkBox = document.createElement("div");
        linkBox.classList.add("linkBox");
        let a = document.createElement("a");
        a.innerHTML = i18n.getTranslation("versions>removeChangeNode");
        a.addEventListener("click", () => {
            text.remove();
            linkBox.remove();
            versions[index].changeNodes.splice(k, 1);
        });

        linkBox.appendChild(a);

        changeNodesContainer.appendChild(text);
        changeNodesContainer.appendChild(linkBox);
        obj.changeNodes.push(text);
    }

    for (let lang of Object.keys(project.allLang)) {
        if (!!project.allLang[lang][version.tag]) {
            let data = project.allLang[lang][version.tag].versionChange;
            let str = data.join("\n");
            addChangeNode(lang, str);
        }
    }

    let linkBox2 = document.createElement("linkBox");
    linkBox2.classList.add("linkBox");
    let a2 = document.createElement("a");
    a2.innerHTML = i18n.getTranslation("versions>addChangeNode");
    a2.addEventListener("click", () => {
        let newLang = prompt("Insert Language Character");
        addChangeNode(newLang, "");
    });

    subtitle.appendChild(span);
    linkBox.appendChild(a);
    subtitle1.appendChild(span1);
    linkBox2.appendChild(a2);
    container.appendChild(tag);
    container.appendChild(splitLine);
    container.appendChild(subtitle);
    container.appendChild(downloadContainer);
    container.appendChild(linkBox);
    container.appendChild(splitLine1);
    container.appendChild(subtitle1);
    container.appendChild(changeNodesContainer);
    container.appendChild(linkBox2);
    document.getElementById("versionsContainer").appendChild(container);
    versions.push(obj);
}

function buildTranslations(languages) {
    let keys = Object.keys(languages);
    for (let key of keys) {
        if (key === "en") {
            continue;
        }

        addTranslation(key, languages[key].globalDescription);
    }
}

function addTranslation(lang, content) {
    let index = descriptions.length - 1;
    let text = document.createElement("textarea");
    text.setAttribute("lang", lang);
    text.placeholder = lang;
    text.value = content;

    let linkBox = document.createElement("div");
    linkBox.classList.add("linkBox", "left", "margin-b-50px");
    let a = document.createElement("a");
    a.innerHTML = i18n.getTranslation("general>removeTranslation");
    a.addEventListener("click", () => {
        text.remove();
        a.remove();
        descriptions.splice(index, 1);
    });
    linkBox.appendChild(a);

    document.getElementById("descriptionContainer").appendChild(text);
    document.getElementById("descriptionContainer").appendChild(linkBox);
    descriptions.push(text);
}

function loadProject() {
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
