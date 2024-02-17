/* const actions = document.querySelectorAll('.action')
    actions.forEach(element => {
        const menu = element.querySelector(".menu")
        const listItem = element.querySelector(".menu-item")
        menu.addEventListener('click', function(e) {
            e.stopImmediatePropagation()
            actions.forEach(element => {
                element.querySelector(".menu-item").classList.remove("show")
            });
            listItem.classList.add("show")
        })

        document.addEventListener('click', function(e) {
            listItem.classList.remove("show")

        })
    }); */