class Search {
    constructor(parent, text, search, description = null) {
        this.parent = document.querySelectorAll(parent)
        this.text = document.querySelectorAll(text)
        this.search = document.querySelector(search)
        if (description !== null) {
            this.description = document.querySelectorAll(description)
        }

        this.compareText()
    }

    compareText() {

        for (let i = 0; i < this.parent.length; i++) {
            const parent = this.parent[i]
            let lowerTitle = this.text[i].textContent.toLowerCase()

            if (this.search.value === '') {
                parent.style.display = 'block'
            } else if (this.description) {
                let lowerDescription = this.description[i].textContent.toLowerCase()

                if (lowerDescription.includes(this.search.value) === false && lowerTitle.includes(this.search.value) == false) {
                    this.parent[i].style.display = 'none'
                }
            } else if (lowerTitle.includes(this.search.value) == false) {
                this.parent[i].style.display = 'none'
            }

        }
        /*if (this.description.length !== 0) {
            for (let i = 0; i < this.parent.length; i++) {
                let lowerTitle = this.text[i].textContent.toLowerCase()
                let lowerDescription = this.description[i].textContent.toLowerCase()
        console.log(!lowerDescription.includes(this.search.value), !lowerTitle.includes(this.search.value))

                if (!lowerTitle.includes(this.search.value) || !lowerDescription.includes(this.search.value) === false) {
                    this.parent[i].style.display = 'none'
                }
            }
        } else {
            for (let i = 0; i < this.parent.length; i++) {
                let lowerTitle = this.text[i].textContent.toLowerCase()

                if (lowerTitle.includes(this.search.value) == false) {
                    this.parent[i].style.display = 'none'
                }
            }
        }*/
    }
}

export default Search