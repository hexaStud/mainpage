class I18nInterface extends I18n {
    async #urlExists(url) {
        return new Promise((resolve) => {
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (this.readyState === 4) {
                    resolve(this.status !== 404 && this.status !== 500);
                }
            }
            xhr.open('HEAD', url, true);
            xhr.send();
        });
    }


    /**
     * @param root {string}
     * @param langKey {string}
     * @param filename {string}
     * @param method {"POST"|"GET"}
     * @return {Promise<void>}
     */
    async loadFromInterface(root, filename, langKey, method) {
        if (await this.#urlExists(`${root}/${filename}.${langKey}.json`)) {
            await this.load(`${root}/${filename}.${langKey}.json`, method);
        } else {
            await this.load(`${root}/${filename}.en.json`, method);
        }
    }
}
