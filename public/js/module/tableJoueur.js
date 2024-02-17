
export const Table = {
    tr: ({ idJoueur, nomJoueur, nomEquipe, idParticipant }) => {
        return `
            <tr>
                            <td> ${idJoueur} </td>
                            <td> <a class='link' href='?p=joueur/details&joueur=${idJoueur}'>${nomJoueur}</a> </td>
                            <td><a class='link' href='?p=equipe/details&equipe=${idParticipant}'> ${nomEquipe} </a></td>
            </tr>
        `
    },
    /**
     * 
     * @param {array} tab 
     * @returns {String}
     */
    tbody: (tab) => {
        if (tab.length == 0) return `<p class="titre flex">Pas de Joueurs </p>`
        return `
         <table class="table striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th> Equipe</th>
                       
                    </tr>
                </thead>
                ${tab.map(elmt => Table.tr(elmt)).join('')}
                <tbody>
        
        `
    }

}