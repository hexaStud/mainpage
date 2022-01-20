class I18n {
    #translationFile;
    #event = new Map();

    /**
     * @param translation {string}
     * @param method {"POST"|"GET"}
     * @return {Promise<void>}
     */
    async load(translation, method) {
        return new Promise((resolve, reject) => {
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        let obj = JSON.parse(xhr.responseText);
                        this.#translationFile = obj;
                        this.#emit("load");
                        resolve();
                    } catch (err) {
                        reject(err);
                    }
                }
            }
            xhr.open(method, translation, true);
            xhr.send();
        });
    }

    update() {
        if (!!this.#translationFile) {
            let elements = document.querySelectorAll("[i18n]");

            elements.forEach((ele) => {
                function setDefault() {
                    if (ele.hasAttributes("i18nDefault")) {
                        if (attr) {
                            ele.setAttribute(attr, ele.getAttribute("i18nDefault"));
                        } else {
                            ele.innerHTML = ele.getAttribute("i18nDefault");
                        }
                    }
                }

                let path = ele.getAttribute("i18n");
                let attr;
                if (ele.hasAttributes("i18nAttr")) {
                    attr = ele.getAttribute("i18nAttr");
                }
                if (!!path) {
                    let t;
                    if (!!(t = this.getTranslation(path))) {
                        if (!!attr) {
                            ele.setAttribute(attr, t);
                        } else {
                            ele.innerHTML = t;
                        }
                    } else {
                        setDefault(attr);
                    }
                }
            });
        }
    }

    getTranslation(path) {
        let pathSegments = path.split(">");
        let value = this.#translationFile;
        for (const segment of pathSegments) {
            value = value[segment];
            console.log(value);
            if (!value) {
                console.error("Translation path does not exists");
                return null;
            }
        }
        if (typeof value === "object" || typeof value === "function" || Array.isArray(value)) {
            console.error("Datatype is not supported");
            return null;
        } else {
            return value;
        }
    }

    /**
     * @param ev {"load"}
     * @param cb
     */
    on(ev, cb) {
        if (this.#event.has(ev)) {
            let evs = this.#event.get(ev);
            evs.push(cb);
            this.#event.set(ev, evs);
        } else {
            this.#event.set(ev, [
                cb
            ]);
        }
    }

    /**
     * @param ev {"load"}
     */
    #emit(ev) {
        if (this.#event.has(ev)) {
            let evs = this.#event.get(ev);
            for (const ev of evs) {
                ev();
            }
        }
    }
}
