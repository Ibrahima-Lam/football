export const Table = {
    tr: ({ idParticipant, nomEquipe, libelleEquipe, localiteEquipe }) => {
        return `
        <tr>
                        <td> ${idParticipant}</td>
                        <td><a class='link' href='?p=equipe/details&equipe=${idParticipant}'> ${nomEquipe} </a></td>
                        <td>${libelleEquipe} </td>
                        <td>${localiteEquipe ?? ''} </td>
        </tr>
        `
    },
    tbody: (tab) => {
        if (tab.length == 0) return `<p class="titre flex">Pas d'equipe </p>`

        return `
         <table class="table striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nom</th>
                    <th>Libelle</th>
                    <th>Localité</th>
                  
                </tr>
            </thead>
            <tbody>
            ${tab.map(elmt => Table.tr(elmt)).join('')}
            </tbody>
        `
    }

}