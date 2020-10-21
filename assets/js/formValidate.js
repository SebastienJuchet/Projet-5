class FormValidate {
    constructor(id) {
        this.id = id
        this.input = document.querySelector('#' + id)
        this.textRegex = /^.{3,}$/
        this.textareaRegex = /^.{10,}$/
        this.kmsRegex = /^.[0-9]{1,6}$/
        this.priceRegex = /^.[0-9]{2,}$/
        this.emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/

        this.text()
        this.textarea()
        this.price()
        this.kms()
    }

    text() 
    {
        return this.textRegex.test(this.input.value)
    }

    textarea()
    {
        return this.textareaRegex.test(this.input.value)
    }

    price()
    {
        return this.priceRegex.test(this.input.value)
    }

    kms()
    {
        return this.kmsRegex.test(this.input.value)
    }

    checkText()
    {
        if (this.text() === false) {
            this.input.classList.add('is-invalid')
            if (!document.querySelector('.' + this.id)) {
                let divParent = this.input.parentNode
                let div = document.createElement('div')
                div.classList.add('invalid-feedback')
                div.classList.add(this.id)
                div.innerHTML = "Doit contenir au moins 3 caractères"
                divParent.append(div)
            }
                
        } else {
            this.input.classList.remove('is-invalid')
            return true
        }

        return false
    }

    checkTextarea()
    {
        if (this.textarea() === false) {
            this.input.classList.add('is-invalid')
            if (!document.querySelector('.' + this.id)) {
                let divParent = this.input.parentNode
                let div = document.createElement('div')
                div.classList.add('invalid-feedback')
                div.classList.add(this.id)
                div.innerHTML = "Doit contenir au moins 10 caractères"
                divParent.append(div)
            }
        }else {
            this.input.classList.remove('is-invalid')
            return true
        }
        
        return false
    }

    checkPrice()
    {
        if (this.price() === false) {
            this.input.classList.add('is-invalid')
            if (!document.querySelector('.' + this.id)) {
                let divParent = this.input.parentNode
                let div = document.createElement('div')
                div.classList.add('invalid-feedback')
                div.classList.add(this.id)
                div.innerHTML = "Doit contenir au moins 2 chiffres"
                divParent.append(div)
            }
        }else {
            this.input.classList.remove('is-invalid')
            return true
        }
        
        return false
    }

    checkKms()
    {
        if (this.kms() === false) {
            this.input.classList.add('is-invalid')
            if (!document.querySelector('.' + this.id)) {
                let divParent = this.input.parentNode
                let div = document.createElement('div')
                div.classList.add('invalid-feedback')
                div.classList.add(this.id)
                div.innerHTML = "Doit contenir entre 1 et 6 chiffres"
                divParent.append(div)
            }
        }else {
            this.input.classList.remove('is-invalid')
            return true
        }
        
        return false
    }

    checkCity()
    {
        if (this.text() === false) {
            this.input.classList.add('is-invalid')
            if (!document.querySelector('.' + this.id)) {
                let divParent = this.input.parentNode
                let div = document.createElement('div')
                div.classList.add('invalid-feedback')
                div.classList.add(this.id)
                div.innerHTML = "Entrez une ville"
                divParent.append(div)
            }
        }else {
            this.input.classList.remove('is-invalid')
            return true
        }
        
        return false
    }
}

export default FormValidate
