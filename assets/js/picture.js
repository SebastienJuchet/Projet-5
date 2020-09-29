window.onload = () => {
    if (document.querySelectorAll('.delete-picture')) {
        let links = document.querySelectorAll('.delete-picture')
        for (const link of links) {
            link.addEventListener('click', (e) => {
                e.preventDefault()
                
                fetch(link, {
                    method: 'DELETE'
                    }
                ).then(
                    response => response.json()
                ).then(
                    data => {
                        if (data.success) {
                            link.parentElement.remove()
                        }
                    }
                ).catch( error => {
                        alert('Erreur : ' + error)
                    }
                )
            })
        }
    }
}
